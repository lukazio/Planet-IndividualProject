<?php
if(isset($_POST['deletenote-submit'])){
    session_start();
    require '../modules/dbconnect.php';
    
    $note_id = $_POST['deletenote-submit'];
    $board_id = $_POST['board_id'];
    
    $noteCheckSql = "SELECT * FROM note WHERE note_id='$note_id';";
    if(mysqli_num_rows(mysqli_query($conn,$noteCheckSql)) > 0){
        $deleteNoteSql = "DELETE FROM note WHERE note_id='$note_id';";
        mysqli_query($conn,$deleteNoteSql);
    }
    
    header("Location: ../noteboard.php?id=".$board_id);
}
else{
    header("Location: ../index.php");
}
?>