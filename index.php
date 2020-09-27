<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Planet - Home</title>
        
        <?php
        require 'modules/link.php';
        ?>
    </head>
    
    <?php
    require 'modules/dbconnect.php';
    include 'modules/navbar.php';
    
    if(!isset($_SESSION['email']))
        header("Location: login.php");
    ?>
    
    <body style="margin-top:80px;" class="mx-3 mx-lg-5">
        <div class="container-fluid">
            <div class="row pb-3 mb-3" style="border-bottom: 2px solid;">
                <div class="col-12 col-sm-6 text-center text-sm-right align-self-center">
                    <img class="img-fluid" src="img/planet.png" width="200" height="200" alt="">
                </div>
                <div class="col-12 col-sm-6 text-center text-sm-left align-self-center">
                    <h1>Planet</h1>
                    <h5>Welcome, <?php echo $_SESSION['username']; ?>.</h5>
                </div>
            </div>
            
            <div class="row pb-3 mb-3">
                <div class="col-12 col-lg-6">
                    <h3 class="pb-3" style="border-bottom: 1px solid;">Your Noteboards</h3>
                    <form class="pb-3 my-3 form-inline" action="action/addboard_action.php" method="post" style="border-bottom: 1px solid;">
                        <input type="text" class="form-control" name="newboard_name" placeholder="Add New" pattern="[a-zA-Z0-9 ]+" maxlength="50" required>
                        <button type="submit" class="btn btn-success" name="addboard-submit" onclick="return confirm('Create noteboard?')"><i class="fa fa-plus" aria-hidden="true"></i></button>
                    </form>
                    <?php
                    $currentEmail = $_SESSION['email'];
                    $noteboardSql = "SELECT * FROM noteboard WHERE board_owner=(SELECT user_id FROM user WHERE user_email='$currentEmail') ORDER BY board_name;";
                    
                    if($noteboardResult = mysqli_query($conn,$noteboardSql)){
                        if(mysqli_num_rows($noteboardResult) > 0){
                            while($row = mysqli_fetch_assoc($noteboardResult)){
                                echo '<div class="btn-group btn-group-toggle mb-2">'
                                    . '<a href="noteboard.php?id='.$row['board_id'].'" class="btn btn-primary">';
                                        if(strlen($row['board_name']) > 35){
                                            echo substr($row['board_name'],0,35).'...';
                                        }
                                        else{
                                            echo $row['board_name'];
                                        }
                                echo '</a>'
                                    . '<form action="action/deleteboard_action.php" method="post">'
                                        . '<button type="submit" onclick="return confirm(\'Confirm noteboard deletion?\nEveryone that has joined this noteboard will lose everything here!\')" name="deleteboard-submit" value="'.$row['board_id'].'" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>'
                                    . '</form>'
                                   . '</div><br>';
                            }
                        }
                        else{
                            echo '<h4 class="text-info">No noteboards found.</h4>';
                            echo '<h6 class="text-info">Create a new noteboard with the mini form above!</h6>';
                        }
                    }
                    else{
                        echo "database error: can't retrieve your noteboard list<br><b>ERROR: </b>".mysqli_error($conn);
                    }
                    ?>
                </div>
                <div class="col-12 col-lg-6 mt-4 mt-lg-0">
                    <h3 class="pb-3 mb-3" style="border-bottom: 1px solid;">Joined Noteboards</h3>
                    <?php
                    $joinedBoardsSql = "SELECT * FROM user_noteboard WHERE user_id=(SELECT user_id FROM user WHERE user_email='$currentEmail');";
                    
                    if($joinedBoardsResult = mysqli_query($conn,$joinedBoardsSql)){
                        if(mysqli_num_rows($joinedBoardsResult) > 0){
                            while($row = mysqli_fetch_array($joinedBoardsResult)){
                                $currentBoardId = $row['board_id'];
                                $boardNameSql = "SELECT board_name FROM noteboard WHERE board_id='$currentBoardId';";
                                $row_board = mysqli_fetch_assoc(mysqli_query($conn,$boardNameSql));
                                        
                                echo '<div class="btn-group btn-group-toggle mb-2">'
                                    . '<a href="noteboard.php?id='.$row['board_id'].'" class="btn btn-info">';
                                        if(strlen($row_board['board_name']) > 35){
                                            echo substr($row_board['board_name'],0,35).'...';
                                        }
                                        else{
                                            echo $row_board['board_name'];
                                        }
                                echo '</a>'
                                    . '<form action="action/leaveboard_action.php" method="post">'
                                        . '<button type="submit" onclick="return confirm(\'Are you sure you want to leave this noteboard?\')" name="leaveboard-submit" value="'.$row['board_id'].'" class="btn btn-danger"><i class="fa fa-sign-out" aria-hidden="true"></i></a>'
                                    . '</form>'
                                   . '</div><br>';
                            }
                        }
                        else{
                            echo '<h4 class="text-info">You have not joined any noteboards.</h4>';
                        }
                    }
                    else{
                        echo "database error: can't retrieve your noteboard list<br><b>ERROR: </b>".mysqli_error($conn);
                    }
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>