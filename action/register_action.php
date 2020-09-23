<?php
if(isset($_POST['register-submit'])){
    session_start();
    require '../modules/dbconnect.php';
    
    $email = $_POST['email'];
    $username = trim($_POST['username']);
    $password = $_POST['pw'];
    $cfm_password = $_POST['cfm-pw'];
    
    if(empty($email) || empty($username) || empty($password) || empty($cfm_password)){
        //No empty fields error
        $_SESSION['register-error'] = 1;
        header("Location: ../register.php");
    }
    else{
        //Prepare statement
        $selectSql="select * from user where user_id=?; ";
        $stmt= mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$selectSql)){
            //Statement preparation error
            $_SESSION['register-error'] = 2;
            header("Location: ../register.php");
        }
        else{
            $INPUT_ERROR = false;
            
            mysqli_stmt_bind_param($stmt,"ssss",$email,$username,$password,$cfm_password);
            mysqli_stmt_execute($stmt);
            $stmtResult = mysqli_stmt_get_result($stmt);
            
            $checkEmailSql = "SELECT * FROM user WHERE user_email='$email' LIMIT 1;";
            $checkNameSql = "SELECT * FROM user WHERE user_name='$username' LIMIT 1;";
            
            $emailCheckResult = mysqli_fetch_assoc(mysqli_query($conn,$checkEmailSql));
            $nameCheckResult = mysqli_fetch_assoc(mysqli_query($conn,$checkNameSql));
            
            if($password !== $cfm_password){
                //Different password and confirm password error
                $_SESSION['register-error'] = 3;
                $INPUT_ERROR = true;
                header("Location: ../register.php");
            }
            else if($emailCheckResult){
                //Email exists error
                $_SESSION['register-error'] = 4;
                $INPUT_ERROR = true;
                header("Location: ../register.php");
            }
            else if($nameCheckResult){
                //Username exists error
                $_SESSION['register-error'] = 5;
                $INPUT_ERROR = true;
                header("Location: ../register.php");
            }
            
            //Success
            if($INPUT_ERROR == false){
                $password = password_hash($password,PASSWORD_ARGON2ID);
                $insertSql = "INSERT INTO user(user_name,user_email,user_password) VALUES('$username','$email','$password');";
                mysqli_query($conn,$insertSql);
                header("Location: ../login.php");
            }
        }
    }
}
else{
    header("Location: ../index.php");
}
?>