<?php
if(isset($_POST['changepw-submit'])){
    session_start();
    require '../modules/dbconnect.php';
    
    $current_pw = $_POST['current-pw'];
    $new_pw = $_POST['new-pw'];
    $cfm_pw = $_POST['cfm-pw'];
    
    if(empty($current_pw) || empty($new_pw) || empty($cfm_pw)){
        //No empty fields error
        $_SESSION['changepw-error'] = 1;
    }
    else if($new_pw != $cfm_pw){
        //New password doesn't match confirm password error
        $_SESSION['changepw-error'] = 2;
    }
    else{
        //Get hashed password and verify
        $currentEmail = $_SESSION['email'];
        $pwSql = "SELECT user_password FROM user WHERE user_email='$currentEmail';";
        $pwResult = mysqli_fetch_assoc(mysqli_query($conn,$pwSql));
        $hashed_pw = $pwResult['user_password'];
        $verify_pw = password_verify($current_pw,$hashed_pw);
        
        //Check if new password is still same
        if(password_verify($new_pw,$hashed_pw)){
            //New password is still same error
            $_SESSION['changepw-error'] = 3;
        }
        else{
            if($verify_pw){
                $new_pw_hashed = password_hash($new_pw,PASSWORD_ARGON2ID);
                $sql = "UPDATE user SET user_password='$new_pw_hashed' WHERE user_email='$currentEmail';";
                mysqli_query($conn,$sql);
                
                $_SESSION['changepw-error'] = 5;//This is actually success message, not error
            }
            else{
                //Invalid current password verification error
                $_SESSION['changepw-error'] = 4;
            }
        }
    }
    
    header("Location: ../profile.php");
}
else{
    header("Location: ../index.php");
}
?>