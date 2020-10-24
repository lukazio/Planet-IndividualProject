<?php
if(isset($_POST['renameboard-submit'])){
    session_start();
    require '../modules/dbconnect.php';
    
    $board_id = $_POST['renameboard-submit'];
    $board_newname = trim($_POST['editboard_name']);
    
    if(empty($board_newname))
        header("Location: ../index.php");
    else{
        //Check if noteboard is still in the system or not
        $checkBoardSql = "SELECT * FROM noteboard WHERE board_id='$board_id';";
        $checkBoardResult = mysqli_query($conn,$checkBoardSql);
        
        if(mysqli_num_rows($checkBoardResult) > 0){
            $updateNameSql = "UPDATE noteboard SET board_name='$board_newname' WHERE board_id='$board_id';";
            mysqli_query($conn,$updateNameSql);
        }
    }
    
    header("Location: ../index.php");
}
else{
    header("Location: ../index.php");
}
?>