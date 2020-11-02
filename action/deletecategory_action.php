<?php
if(isset($_POST['deletecategory-submit'])){
    session_start();
    require '../modules/dbconnect.php';
    
    $cat_id = $_POST['deletecategory-submit'];
    $board_id = $_POST['board_id'];
    
    if(empty($cat_id))
        header("Location: ../noteboard.php?id=".$inviteBoard);
    else{
        //Check if category still exists and data coming from correct board
        $verifyCatSql = "SELECT * FROM category WHERE cat_id='$cat_id' AND board_id='$board_id';";
        $verifyCatResult = mysqli_query($conn,$verifyCatSql);
        
        if(mysqli_num_rows($verifyCatResult) > 0){
            //Remove all notes from that category before deleting category
            $nullNoteCatSql = "UPDATE note SET note_category=NULL WHERE note_category='$cat_id';";
            if(mysqli_query($conn,$nullNoteCatSql)){
                $deleteCatSql = "DELETE FROM category WHERE cat_id='$cat_id';";
                mysqli_query($conn,$deleteCatSql);
            }
        }
    }
    
    header("Location: ../noteboard.php?id=".$board_id);
}
else{
    header("Location: ../index.php");
}
?>