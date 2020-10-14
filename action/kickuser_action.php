<?php
if(isset($_POST['kickuser-submit'])){
    session_start();
    require '../modules/dbconnect.php';
    
    $boardId = $_POST['board_id'];
    $userId = $_POST['kickuser-submit'];
    
    $userCheckSql = "SELECT * FROM user_noteboard WHERE user_id='$userId' AND board_id='$boardId';";
    if(mysqli_num_rows(mysqli_query($conn,$userCheckSql)) > 0){
        $kickUserSql = "DELETE FROM user_noteboard WHERE user_id='$userId' AND board_id='$boardId';";
        
        mysqli_query($conn,$kickUserSql);
    }
    header("Location: ../noteboard.php?id=".$boardId);
}
else{
    header("Location: ../index.php");
}
?>