<?php
if(isset($_POST['joinboard-accept-submit']) || isset($_POST['joinboard-reject-submit'])){
    session_start();
    require '../modules/dbconnect.php';
    
    //Get current user's ID
    $currentEmail = $_SESSION['email'];
    $userIdSql = "SELECT user_id FROM user WHERE user_email='$currentEmail' LIMIT 1;";
    $userIdResult = mysqli_fetch_assoc(mysqli_query($conn,$userIdSql));
    
    $currentUserId = $userIdResult['user_id'];
    $currentBoardId = $_POST['joinboard-id'];
    
    if(isset($_POST['joinboard-accept-submit'])){
        $inviteAcceptId = $_POST['joinboard-accept-submit'];
        
        //Check for duplicates
        $dupeBoardSql = "SELECT id FROM user_noteboard WHERE user_id='$currentUserId' AND board_id='$currentBoardId';";
        $dupeBoardResult = mysqli_query($conn,$dupeBoardSql);
        if(mysqli_num_rows($dupeBoardResult) > 0){
            //Already joined noteboard notice
            $_SESSION['joinboard-info'] = 1;
        }
        else{
            $joinAcceptSql = "INSERT INTO user_noteboard(user_id,board_id) VALUES('$currentUserId','$currentBoardId')";
            mysqli_query($conn,$joinAcceptSql);
            
            //Successfully joined noteboard notice
            $_SESSION['joinboard-info'] = 2;
        }
        
        //Delete replied invite
        $delInviteSql = "DELETE FROM invite WHERE invite_id='$inviteAcceptId';";
        mysqli_query($conn,$delInviteSql);
    }
    if(isset($_POST['joinboard-reject-submit'])){
        $inviteRejectId = $_POST['joinboard-reject-submit'];
        
        //Delete rejected invite
        $delInviteSql = "DELETE FROM invite WHERE invite_id='$inviteRejectId';";
        mysqli_query($conn,$delInviteSql);
        
        //Rejected invitation notice
        $_SESSION['joinboard-info'] = 3;
    }
    
    header("Location: ../profile.php");
}
else{
    header("Location: ../index.php");
}
?>