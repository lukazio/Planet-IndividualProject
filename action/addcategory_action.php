<?php
if(isset($_POST['addcategory-submit'])){
    session_start();
    require '../modules/dbconnect.php';
    
    $cat_name = trim($_POST['cat_name']);
    $board_id = $_POST['board_id'];
    
    if(empty($cat_name))
        header("Location: ../noteboard.php?id=".$inviteBoard);
    else{
        //Check if same name exists in the same board or not
        $checkDupeCatSql = "SELECT * FROM category WHERE board_id='$board_id' AND cat_name='$cat_name';";
        $checkDupeCatResult = mysqli_query($conn,$checkDupeCatSql);
        
        if(mysqli_num_rows($checkDupeCatResult) == 0){
            $addCatSql = "INSERT INTO category(board_id,cat_name) VALUES('$board_id','$cat_name');";
            mysqli_query($conn,$addCatSql);
        }
    }
    
    header("Location: ../noteboard.php?id=".$board_id);
}
else{
    header("Location: ../index.php");
}
?>