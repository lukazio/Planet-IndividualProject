<?php
if(isset($_POST['editnote-submit'])){
    session_start();
    require '../modules/dbconnect.php';
    
    $note_id = $_POST['note_id'];
    $board_id = $_POST['board_id'];
    $note_editor = $_SESSION['username'];
    $note_title = trim($_POST['note_title']);
    $note_category = $_POST['note_category'];
    $note_content = addslashes($_POST['note_content']);
    
    if(empty($note_title))
        header("Location: ../noteboard.php?id=".$board_id);
    else{
        //Check if current noteboard or chosen category still exists or not
        $checkBoardSql = "SELECT * FROM noteboard WHERE board_id='$board_id';";
        $checkCatSql = "SELECT * FROM category WHERE cat_id='$note_category';";
        $checkBoardResult = mysqli_query($conn,$checkBoardSql);
        $checkCatResult = mysqli_query($conn,$checkCatSql);
        
        if(mysqli_num_rows($checkBoardResult) > 0){
            date_default_timezone_set("Asia/Kuala_Lumpur");
            $note_modified = date('Y-m-d H:i:s');
            
            if(mysqli_num_rows($checkCatResult) > 0){
                $updateNoteSql = "UPDATE note SET note_editor='$note_editor',note_title='$note_title',note_category='$note_category',note_content='$note_content',note_modified='$note_modified' WHERE note_id='$note_id';";
                mysqli_query($conn,$updateNoteSql);
            }
            else{
                $updateNoteSql = "UPDATE note SET note_editor='$note_editor',note_title='$note_title',note_category='0',note_content='$note_content',note_modified='$note_modified' WHERE note_id='$note_id';";
                mysqli_query($conn,$updateNoteSql);
            }
        }
        else{
            header("Location: ../index.php");
        }
    }
    
    header("Location: ../note_view.php?note_id=".$note_id."&id=".$board_id);
}
else{
    header("Location: ../index.php");
}
?>