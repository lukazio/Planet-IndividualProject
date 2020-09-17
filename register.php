<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Planet - Sign Up</title>
        
        <?php
        require 'modules/link.php';
        ?>
    </head>
    
    <?php
    session_start();
    require 'modules/dbconnect.php';
    
    if(isset($_SESSION['email']))
        header("Location: index.php");
    ?>
    
    <body style="background: linear-gradient( rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6) ), url('img/canteen.jpg'); background-position:center; background-size:auto; background-repeat:no-repeat">
        <div class="container">
            <div class="card" style="margin:25% 20%; background: linear-gradient( rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.9) )">
                <div class="card-body">
                    <h1 class="card-title text-center">Welcome, New User!</h1>
                    <p class="card-subtitle text-center">But first, we need some details.</p>
                    
                    <form class="mx-2 mx-md-3 mx-lg-5 pt-5" action="action/register_action.php" method="post">
                        <div class="form-group pt-2">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
			</div>
                        <div class="form-group pt-2">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" maxlength="12" required>
			</div>
			<div class="form-group pt-2">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="pw" placeholder="Enter password" maxlength="20" required>
			</div>
                        <div class="form-group pt-2">
                            <label for="cfm-password">Confirm Password</label>
                            <input type="password" class="form-control" id="cfm-password" name="cfm-pw" placeholder="Confirm password" maxlength="20" required>
			</div>
                        <div class="text-center">
                            <?php
                            if(isset($_SESSION['register-error'])){
                                $register_error = $_SESSION['register-error'];

                                switch($register_error){
                                    case 1:
                                        echo "<span class=\"text-danger\">No empty fields are allowed.</span><br>";
                                        break;
                                    case 2:
                                        echo "<span class=\"text-danger\">Internal server error.</span><br>";
                                        break;
                                    case 3:
                                        echo "<span class=\"text-danger\">Password and confirm password do not match.</span><br>";
                                        break;
                                    case 4:
                                        echo "<span class=\"text-danger\">Email already exists.</span><br>";
                                        break;
                                    case 5:
                                        echo "<span class=\"text-danger\">Username already exists.</span><br>";
                                        break;
                                }

                                unset($_SESSION['register-error']);
                            }
                            ?>
                            <br>
                            <button type="submit" class="mt-5 btn btn-primary" name="register-submit">Sign Up!</button>
			</div>
                    </form>
                    
                    <div class="text-right mt-5">
                        <span>Already have an account? <a href="login.php">Click here to login!</a></span>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>