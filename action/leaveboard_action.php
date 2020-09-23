<?php
if(isset($_POST['leaveboard-submit'])){
    session_start();
    require '../modules/dbconnect.php';
    
    //Get current user's ID
    $currentEmail = $_SESSION['email'];
    $userIdSql = "SELECT user_id FROM user WHERE user_email='$currentEmail' LIMIT 1;";
    $userIdResult = mysqli_fetch_assoc(mysqli_query($conn,$userIdSql));
    
    $currentUserId = $userIdResult['user_id'];
    $leaveId = $_POST['leaveboard-submit'];
    
    $boardCheckSql = "SELECT id FROM user_noteboard WHERE user_id='$currentUserId' AND board_id='$leaveId';";
    if(mysqli_num_rows(mysqli_query($conn,$boardCheckSql)) > 0){
        $leaveBoardSql = "DELETE FROM user_noteboard WHERE user_id='$currentUserId' AND board_id='$leaveId';";
        
        mysqli_query($conn,$leaveBoardSql);
        header("Location: ../index.php");
    }
    else{
        //Noteboard was already gone
        header("Location: ../index.php");
    }
}
?>