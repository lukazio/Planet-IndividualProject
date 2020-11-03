<!DOCTYPE html>
<?php
session_start();
require 'modules/dbconnect.php';
require 'frameworks/parsedown-1.7.4/Parsedown.php';

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
        <title>Planet - Note View</title>
        
        <?php
        require 'modules/link.php';
        ?>
        <style>
            .blockquote {
                background: #f9f9f9;
                border-left: 10px solid #ccc;
                padding: 1em 10px .1em 10px;
                quotes: "\201C""\201D""\2018""\2019";
            }
        </style>
    </head>
    
    <?php
    require 'modules/dbconnect.php';
    include 'modules/navbar_noteboard.php';
    
    if(!isset($_SESSION['email']))
        header("Location: login.php");
    else if(empty($_GET['note_id']) || empty($_GET['id']))
        header("Location: index.php");
    else{
        $note_id = $_GET['note_id'];
        $board_id = $_GET['id'];
        
        //Validate note access
        $checkOwnerSql = "SELECT * FROM noteboard WHERE board_id='$board_id' AND board_owner='$currentUserId';";
        $checkJoinedSql = "SELECT * FROM user_noteboard WHERE board_id='$board_id' AND user_id='$currentUserId';";
        $checkOwnerResult = mysqli_query($conn,$checkOwnerSql);
        $checkJoinedResult = mysqli_query($conn,$checkJoinedSql);
        
        if(mysqli_num_rows($checkOwnerResult) > 0 || mysqli_num_rows($checkJoinedResult) > 0){
            $getNoteSql = "SELECT * FROM note WHERE note_id='$note_id';";
            $getNoteResult = mysqli_query($conn,$getNoteSql);
            $noteRow = mysqli_fetch_assoc($getNoteResult);
    ?>
    
    <body style="margin-top:80px;" class="mx-3 mx-lg-5 bg-dark">
        <div class="container-fluid">
            <!-- CONTROL ROW -->
            <div class="row">
                <div class="col-6 p-0">
                    <a href="noteboard.php?id=<?php echo $board_id; ?>" class="btn btn-info" data-toggle-tooltip="tooltip" data-placement="right" title="Back to noteboard"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
                </div>
                <div class="col-6 text-right p-0">
                    <form action="action/deletenote_action.php" method="post">
                        <div class="btn-group">
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#editNoteModal" data-toggle-tooltip="tooltip" data-placement="bottom" title="Edit note"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                            <input type="hidden" name="board_id" value="<?php echo $board_id; ?>">
                            <button type="submit" class="btn btn-danger" name="deletenote-submit" value="<?php echo $note_id; ?>" onclick="return confirm('Are you sure you want to delete this note?')" data-toggle-tooltip="tooltip" data-placement="bottom" title="Delete note"><i class="fa fa-trash" aria-hidden="true"></i></button>
                        </div>
                    </form>
                    
                    <!-- edit note modal -->
                    <div class="modal fade" id="editNoteModal" tabindex="-1" role="dialog" aria-labelledby="editNoteLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editNoteLabel">Edit Note</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <form action="action/editnote_action.php" method="post">
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-12 col-sm-7">
                                                <div class="form-group">
                                                    <textarea type="text" class="form-control" rows="4" name="note_title" placeholder="Note Title" pattern="[a-zA-Z0-9 ]+" maxlength="200" required><?php echo $noteRow['note_title'] ?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-5">
                                                <div class="form-group">
                                                    <select name="note_category" class="form-control" required>
                                                        <option value="" disabled selected>Category</option>
                                                        <option value="0" <?php if($noteRow['note_category'] == 0){echo 'selected';} ?>>(Uncategorised)</option>
                                                        <?php
                                                        $getCatsSql = "SELECT * FROM category WHERE board_id='$board_id' ORDER BY cat_name ASC";
                                                        $getCatsResult = mysqli_query($conn,$getCatsSql);
                                                        if(mysqli_num_rows($getCatsResult) > 0){
                                                            foreach($getCatsResult as $catRow){
                                                                $selected = "";
                                                                if($noteRow['note_category'] == $catRow['cat_id'])
                                                                    $selected = "selected";
                                                                echo '<option value="'.$catRow['cat_id'].'"'.$selected.'>'.$catRow['cat_name'].'</option>';
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
                                                    <textarea class="form-control" rows="16" name="note_content" placeholder="Enter your note here..."><?php echo $noteRow['note_content']; ?></textarea>
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
                                        <input type="hidden" name="note_id" value="<?php echo $note_id; ?>">
                                        <input type="hidden" name="board_id" value="<?php echo $board_id; ?>">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-success" name="editnote-submit">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- NOTE ROW -->
            <div class="row my-4">
                <div class="p-0 col-10 col-md-9 col-lg-8 col-xl-6 card mx-auto">
                    <?php
                    if($noteRow['note_category'] != 0){
                        $catRow = mysqli_fetch_assoc(mysqli_query($conn,"SELECT cat_name FROM category WHERE cat_id=".$noteRow['note_category']));
                        echo '<p class="card-header text-secondary">'.$catRow['cat_name'].'</p>';
                    }
                    ?>
                    <p class="h5 card-header font-weight-bold bg-secondary text-white py-2"><?php echo $noteRow['note_title']; ?></p>
                    <div class="card-body">
                        <?php
                        if($noteRow != ""){
                            echo '<div class="card-text">';
                                $Parsedown = new Parsedown();
                                $note_content = $noteRow['note_content'];
                                echo $Parsedown->text($note_content);
                            echo '</div>';
                        }
                        ?>
                    </div>
                    <small class="card-footer text-muted py-2">
                        <i class="fa fa-fw fa-user" aria-hidden="true"></i> Created by <?php echo $noteRow['note_creator']; ?><br>
                        <i class="fa fa-fw fa-pencil-square-o" aria-hidden="true"></i> Last edited by <?php echo $noteRow['note_editor']; ?><br>
                        <i class="fa fa-fw fa-clock-o" aria-hidden="true"></i> Last modified on <?php echo $noteRow['note_modified']; ?>
                    </small>
                </div>
            </div>
        </div>
    </body>
    <?php
            }
            else
                header("Location: index.php");
        }
    ?>
</html>

<script type="text/javascript">
    //Enable tooltips
    $(function () {
        $('[data-toggle-tooltip="tooltip"]').tooltip();
    });
</script>