<?php
if(isset($_POST['addboard-submit'])){
    session_start();
    require '../modules/dbconnect.php';
    
    $boardname = trim($_POST['newboard_name']);
    
    if(empty($boardname))
        header("Location: ../index.php");
    else{
        //Get current user's ID
        $currentEmail = $_SESSION['email'];
        $userIdSql = "SELECT user_id FROM user WHERE user_email='$currentEmail' LIMIT 1;";
        $userIdResult = mysqli_fetch_assoc(mysqli_query($conn,$userIdSql));
        $currentUserId = $userIdResult['user_id'];
        
        //Generate unique hard-to-predict noteboard ID and add into system
        $board_id = md5(uniqid($currentEmail,true));
        $insertSql = "INSERT INTO noteboard(board_id,board_name,board_owner) VALUES('$board_id','$boardname','$currentUserId');";
        mysqli_query($conn,$insertSql);
        header("Location: ../index.php");
    }
}
else{
    header("Location: ../index.php");
}
?>