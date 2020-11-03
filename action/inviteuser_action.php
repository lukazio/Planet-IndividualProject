<?php
if(isset($_POST['inviteuser-submit'])){
    session_start();
    require '../modules/dbconnect.php';
    
    $inviteEmail = $_POST['invite_email'];
    $inviteFrom = $_POST['invite_from'];
    $inviteBoard = $_POST['invite_board'];
    $inviteMsg = trim($_POST['invite_msg']);
    
    if(empty($inviteEmail) || empty($inviteMsg))
        header("Location: ../noteboard.php?id=".$inviteBoard);
    else{
        //Check if invite_email is existing user or not
        $checkUserSql = "SELECT * FROM user WHERE user_email='$inviteEmail';";
        $checkUserResult = mysqli_query($conn,$checkUserSql);
        
        if(mysqli_num_rows($checkUserResult) > 0){
            $checkUserRow = mysqli_fetch_assoc($checkUserResult);
            
            //Check if user has already joined or not
            $checkUserJoinedSql = "SELECT * FROM user_noteboard WHERE user_id='".$checkUserRow['user_id']."' AND board_id='$inviteBoard';";
            $checkUserJoinedResult = mysqli_query($conn,$checkUserJoinedSql);
            
            //Check if invitation has already been sent to this user or not
            $checkInvitationSql = "SELECT * FROM invite WHERE invite_board='$inviteBoard' AND invite_to='$inviteEmail';";
            $checkInvitationResult = mysqli_query($conn,$checkInvitationSql);
            
            //Check if user is the noteboard owner or not
            $checkOwnerSql = "SELECT * FROM noteboard WHERE board_id='$inviteBoard' AND board_owner='".$checkUserRow['user_id']."';";
            $checkOwnerResult = mysqli_query($conn,$checkOwnerSql);
            
            if(mysqli_num_rows($checkUserJoinedResult) == 0 && mysqli_num_rows($checkInvitationResult) == 0 && mysqli_num_rows($checkOwnerResult) == 0){
                //Successfully invited user
                $inviteDatetime = date('Y-m-d H:i:s');
                $insertInviteSql = "INSERT INTO invite(invite_board,invite_to,invite_from,invite_msg,invite_datetime) VALUES('$inviteBoard','$inviteEmail','$inviteFrom','$inviteMsg','$inviteDatetime');";
                mysqli_query($conn,$insertInviteSql);
            }
        }
    }
    
    header("Location: ../noteboard.php?id=".$inviteBoard);
}
else{
    header("Location: ../index.php");
}
?>