<?php
if(isset($_POST['removeinvite-submit'])){
    session_start();
    require '../modules/dbconnect.php';
    
    $inviteId = $_POST['removeinvite-submit'];
    $boardId = $_POST['board_id'];
    
    $inviteCheckSql = "SELECT * FROM invite WHERE invite_id='$inviteId';";
    if(mysqli_num_rows(mysqli_query($conn,$inviteCheckSql)) > 0){
        $removeInviteSql = "DELETE FROM invite WHERE invite_id='$inviteId';";
        mysqli_query($conn,$removeInviteSql);
    }
    
    header("Location: ../noteboard.php?id=".$boardId);
}
else{
    header("Location: ../index.php");
}
?>