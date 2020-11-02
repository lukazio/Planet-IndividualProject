<!DOCTYPE html>
<?php
session_start();
require 'modules/dbconnect.php';

$error_code = 0;

//Get noteboard information if valid noteboard ID
$board_id = $_GET['id'];
$boardInfoSql = "SELECT * FROM noteboard WHERE board_id='$board_id'";
$boardInfoResult = mysqli_query($conn,$boardInfoSql);
if(mysqli_num_rows($boardInfoResult) > 0)
    $board_info = mysqli_fetch_assoc($boardInfoResult);
else
    $error_code = 1;    //Invalid noteboard ID error

//Get current user's ID
$currentEmail = $_SESSION['email'];
$userIdSql = "SELECT user_id FROM user WHERE user_email='$currentEmail' LIMIT 1;";
$userIdResult = mysqli_fetch_assoc(mysqli_query($conn,$userIdSql));
$currentUserId = $userIdResult['user_id'];
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Planet - <?php
            if($error_code == 1)
                echo "Invalid ID";
            else
                echo $board_info['board_name']; ?>
        </title>
        
        <?php
        require 'modules/link.php';
        ?>
        <style>
            .stretched-link::after {
                position: absolute;
                top: 0;
                right: 0;
                bottom: 0;
                left: 0;
                z-index: 1;
                pointer-events: auto;
                content: "";
                background-color: rgba(0,0,0,0);
            }
        </style>
    </head>
    
    <?php
    include 'modules/navbar_noteboard.php';
    
    if(!isset($_SESSION['email']))
        header("Location: login.php");
    ?>
    
    <body style="margin-top:80px;" class="mx-3 mx-lg-5 bg-dark">
        <div class="container-fluid">
        <?php
        //Check if valid noteboard ID or not, print error if invalid
        if($error_code == 1){
            echo '<h1 class="text-center text-info">Invalid noteboard ID</h1>';
            echo '<div class="text-center"><a class="h4" href="index.php">Click to return to homepage</a></div>';
        }
        else{
            //SQLs to check if user belongs or owns this noteboard or not
            $currentBoardId = $board_info['board_id'];
            $checkOwnerSql = "SELECT * FROM noteboard WHERE board_id='$currentBoardId' AND board_owner='$currentUserId';";
            $checkJoinedSql = "SELECT * FROM user_noteboard WHERE board_id='$currentBoardId' AND user_id='$currentUserId';";
            $checkOwnerResult = mysqli_query($conn,$checkOwnerSql);
            $checkJoinedResult = mysqli_query($conn,$checkJoinedSql);
            if(mysqli_num_rows($checkOwnerResult) == 0 && mysqli_num_rows($checkJoinedResult) == 0)
                $error_code = 2;    //User is not owner or didn't join noteboard error
            
            if($error_code == 2){
                echo $error_code;
                echo '<h1 class="text-center text-info">You do not have permission to view this noteboard</h1>';
                echo '<div class="text-center"><a class="h4" href="index.php">Click to return to homepage</a></div>';
            }
            else{
                //Finally no problems! Code to show noteboard UI and get all notes in it
                //Retrieve all notes and categories associated with the noteboard
                $getCatsSql = "SELECT * FROM category WHERE board_id='$board_id' ORDER BY cat_name ASC";
                $getCatsResult = mysqli_query($conn,$getCatsSql);
                ?>
        
                <!-- CATEGORY ROW -->
                <div class="row">
                    <div class="col-6 p-0">
                        <form class="form-inline" action="noteboard.php" method="get">
                            <input type="hidden" name="id" value="<?php echo $board_id; ?>">
                            <div class="form-group">
                                <select name="category" class="form-control" required>
                                    <option value="" disabled selected>Select Category</option>
                                    <?php
                                    if(mysqli_num_rows($getCatsResult) > 0){
                                        foreach($getCatsResult as $catRow){
                                            echo '<option value="'.$catRow['cat_id'].'">'.$catRow['cat_name'].'</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-info" data-toggle-tooltip="tooltip" data-placement="right" title="Filter with category"><i class="fa fa-filter" aria-hidden="true"></i></button>
                        </form>
                        <div class="btn-group">
                            <div class="btn-group">
                                <button type="button" class="btn btn-warning dropdown-toggle" data-toggle-tooltip="tooltip" data-placement="top" title="Manage categories" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-list" aria-hidden="true"></i> </button>
                                <div class="dropdown-menu">
                                    <?php
                                    if(mysqli_num_rows($getCatsResult) > 0){
                                        foreach($getCatsResult as $catRow){
                                            echo '<a class="dropdown-item pb-0">'.$catRow['cat_name'].''
                                                    . '<form class="d-inline-block" action="action/deletecategory_action.php" method="post">'
                                                        . '<input type="hidden" name="board_id" value="'.$board_id.'">'
                                                        . '<button type="submit" title="Delete '.$catRow['cat_name'].'" onclick="return confirm(\'Confirm deleting category '.$catRow['cat_name'].'?\')" name="deletecategory-submit" value="'.$catRow['cat_id'].'" class="ml-1 btn btn-sm btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>'
                                                    . '</form>'
                                               . '</a>';
                                               
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-success dropdown-toggle" data-toggle-tooltip="tooltip" data-placement="top" title="Add new category" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-plus-circle" aria-hidden="true"></i> </button>
                                <div class="dropdown-menu p-2">
                                    <form action="action/addcategory_action.php" method="post">
                                        <input type="text" class="form-control form-control-sm" name="cat_name" placeholder="New Category" pattern="[a-zA-Z0-9 ]+" maxlength="32" required>
                                        <input type="hidden" name="board_id" value="<?php echo $board_id; ?>">
                                        <button type="submit" class="btn btn-sm btn-success" name="addcategory-submit" onclick="return confirm(\'Add new category?\')"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 text-right p-0">
                        <button type="button" class="btn btn-info" title="Create new note" data-toggle="modal" data-target="#newNoteModal" data-toggle-tooltip="tooltip" data-placement="left" title="Create new note"><i class="fa fa-sticky-note" aria-hidden="true"></i></button>
                        <div class="modal fade" id="newNoteModal" tabindex="-1" role="dialog" aria-labelledby="newNoteLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="newNoteLabel">Create New Note</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <form action="action/addnote_action.php" method="post">
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-12 col-sm-7">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="note_title" placeholder="Note Title" pattern="[a-zA-Z0-9 ]+" maxlength="64" required>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-5">
                                                    <div class="form-group">
                                                        <select name="note_category" class="form-control" required>
                                                            <option value="" disabled selected>Category</option>
                                                            <option value="0">(Uncategorised)</option>
                                                            <?php
                                                            if(mysqli_num_rows($getCatsResult) > 0){
                                                                foreach($getCatsResult as $catRow){
                                                                    echo '<option value="'.$catRow['cat_id'].'">'.$catRow['cat_name'].'</option>';
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <textarea class="form-control" rows="12" name="note_content" placeholder="Enter your note here..."></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 text-left">
                                                    <div class="dropdown dropright">
                                                        <button type="button" class="btn btn-link text-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-lg fa-question-circle" aria-hidden="true"></i></button>
                                                        <div class="dropdown-menu p-4">
                                                            <h5>Formatting Help</h5>
                                                            <p>Planet makes use of Markdown for text formatting in notes without the need for any advanced text editors.</p>
                                                            <p>Examples: <b>bold</b>, <i>italic</i>, <code class="text-dark">code</code>, and many more including lists, images, hyperlinks...</p>
                                                            <p>All about the usage of Markdown can be found <a href="https://www.markdownguide.org/basic-syntax" target="_blank">here.</a></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="hidden" name="board_id" value="<?php echo $board_id; ?>">
                                            <input type="hidden" name="note_creator_id" value="<?php echo $currentUserId; ?>">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-success" name="addnote-submit">Create Note</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                if(isset($_GET['category'])){
                    $getCatNameSql = "SELECT cat_name FROM category WHERE cat_id='".$_GET['category']."';";
                    $catNameRow = mysqli_fetch_assoc(mysqli_query($conn,$getCatNameSql));
                    $catName = $catNameRow['cat_name'];
                    
                    echo '<div class="row mt-3">'
                            . '<div class="m-0 alert alert-success alert-dismissible fade show" role="alert">'
                                . '<strong>Category: </strong>' . $catName
                                . '<button type="button" class="close" onclick="location.href=\'noteboard.php?id='.$board_id.'\';" data-dismiss="alert" aria-label="Clear"><span aria-hidden="true">&times;</span></button>'
                            . '</div>'
                       . '</div>';
                }
                ?>
                <div class="row mt-3 rounded" id="noteSection" style="border: 2px solid gray"></div>
        <?php
            }
        }
        ?>
        </div>
    </body>
</html>

<script type="text/javascript">
    //Enable tooltips
    $(function () {
        $('[data-toggle-tooltip="tooltip"]').tooltip();
    });
    
    //Auto refresh noteSection
    var url = new URL(location.href);
    var board_id = url.searchParams.get("id");
    var category = 0;
    if(url.toString().indexOf("category") > -1){
        category = url.searchParams.get("category");
    }
    
    $(document).ready( function(){
        $('#noteSection').load('notes.php?id=' + board_id + '&category=' + category);
        refresh();
    });
    function refresh(){
        setTimeout( function(){
            $('#noteSection').load('notes.php?id=' + board_id + '&category=' + category);
            refresh();
        }, 1000);
    }
</script>