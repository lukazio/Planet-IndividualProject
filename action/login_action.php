<?php
if(isset($_POST['login-submit'])){
    session_start();
    require '../modules/dbconnect.php';
    
    $email = $_POST['email'];
    $password = $_POST['pw'];
    
    if(empty($email) || empty($password)){
        //No empty fields error
        $_SESSION['login-error'] = 1;
    }
    else{
        //Prepare statement
        $selectSql="select * from user where user_id=?; ";
        $stmt= mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$selectSql)){
            //Statement preparation error
            $_SESSION['login-error'] = 2;
        }
        else{
            mysqli_stmt_bind_param($stmt,"ss",$email,$password);
            mysqli_stmt_execute($stmt);
            $stmtResult = mysqli_stmt_get_result($stmt);
            
            //Get hashed password and verify
            $pwSql = "SELECT user_password FROM user WHERE user_email='$email';";
            $pwResult = mysqli_fetch_assoc(mysqli_query($conn,$pwSql));
            $hashed_pw = $pwResult['user_password'];
            $verify_pw = password_verify($password,$hashed_pw);
            
            //Login code
            $sql = "SELECT * FROM user WHERE user_email='$email';";
            $result= mysqli_query($conn,$sql);
            if(mysqli_num_rows($result) == 1 && $verify_pw){
                $row = mysqli_fetch_assoc($result);
                $_SESSION['email'] = $email;
                $_SESSION['username'] = $row['user_name'];
                
                if(isset($_POST['email_remember']))
                    setcookie('email',$email,'','/fyp/login.php');
                else
                    setcookie('email','',time()-3600,'/fyp/login.php');
                
                header("Location: ../index.php");
                exit();
            }
            else{
                //Wrong email or password error
                $_SESSION['login-error'] = 3;
            }
        }
    }
    
    header("Location: ../login.php");
}
else{
    header("Location: ../index.php");
}
?>