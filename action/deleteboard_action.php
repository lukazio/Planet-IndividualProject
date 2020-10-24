<?php
if(isset($_POST['deleteboard-submit'])){
    session_start();
    require '../modules/dbconnect.php';
    
    $deleteId = $_POST['deleteboard-submit'];
    
    $boardCheckSql = "SELECT board_id FROM noteboard WHERE board_id='$deleteId'";
    if(mysqli_num_rows(mysqli_query($conn,$boardCheckSql)) > 0){
        $leaveBoardSql = "DELETE FROM user_noteboard WHERE board_id='$deleteId'";
        $deleteBoardSql = "DELETE FROM noteboard WHERE board_id='$deleteId'";
        $deleteInviteSql = "DELETE FROM invite WHERE invite_board='$deleteId'";
        $deleteNoteSql = "DELETE FROM note WHERE board_id='$deleteId'";
        $deleteCategorySql = "DELETE FROM category WHERE board_id='$deleteId'";
        
        //Every data tied to the noteboard must be deleted first before deleting the noteboard itself
        if(mysqli_query($conn,$leaveBoardSql) && mysqli_query($conn,$deleteInviteSql) && mysqli_query($conn,$deleteNoteSql) && mysqli_query($conn,$deleteCategorySql)){
            mysqli_query($conn,$deleteBoardSql);
        }
        header("Location: ../index.php");
    }
    else{
        //Noteboard was already gone
        header("Location: ../index.php");
    }
}
?>