<?php
if(isset($_POST['addnote-submit'])){
    session_start();
    require '../modules/dbconnect.php';
    
    $board_id = $_POST['board_id'];
    $note_creator = $_POST['note_creator_id'];
    $note_title = trim($_POST['note_title']);
    $note_category = $_POST['note_category'];
    $note_content = addslashes($_POST['note_content']);
    
    if(empty($note_title))
        header("Location: ../noteboard.php?id=".$board_id);
    else{
        //Get username of note creator
        $usernameSql = "SELECT user_name FROM user WHERE user_id='$note_creator';";
        $usernameRow = mysqli_fetch_assoc(mysqli_query($conn,$usernameSql));
        $note_creator_name = $usernameRow['user_name'];
        
        //Check if current noteboard or chosen category still exists or not
        $checkBoardSql = "SELECT * FROM noteboard WHERE board_id='$board_id';";
        $checkCatSql = "SELECT * FROM category WHERE cat_id='$note_category';";
        $checkBoardResult = mysqli_query($conn,$checkBoardSql);
        $checkCatResult = mysqli_query($conn,$checkCatSql);
        
        if(mysqli_num_rows($checkBoardResult) > 0){
            date_default_timezone_set("Asia/Kuala_Lumpur");
            $note_modified = date('Y-m-d H:i:s');
            
            if(mysqli_num_rows($checkCatResult) > 0){
                $insertNoteSql = "INSERT INTO note(board_id,note_creator,note_editor,note_title,note_category,note_content,note_modified) VALUES('$board_id','$note_creator_name','$note_creator_name','$note_title','$note_category','$note_content','$note_modified')";
                mysqli_query($conn,$insertNoteSql);
            }
            else{
                $insertNoteSql = "INSERT INTO note(board_id,note_creator,note_editor,note_title,note_category,note_content,note_modified) VALUES('$board_id','$note_creator_name','$note_creator_name','$note_title',0,'$note_content','$note_modified')";
                mysqli_query($conn,$insertNoteSql);
            }
        }
        else{
            header("Location: ../index.php");
        }
    }
    
    header("Location: ../noteboard.php?id=".$board_id);
}
else{
    header("Location: ../index.php");
}
?>