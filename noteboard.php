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
    </head>
    
    <?php
    include 'modules/navbar.php';
    
    if(!isset($_SESSION['email']))
        header("Location: login.php");
    ?>
    
    <body style="margin-top:80px;" class="mx-3 mx-lg-5">
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
            }
        }
        ?>
    </body>
</html>
