<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Planet - Login</title>
        
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
                    <h1 class="card-title text-center">Login</h1>
                    
                    <form class="mx-2 mx-md-3 mx-lg-5 pt-5" action="action/login_action.php" method="post">
                        <div class="form-group pt-2">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
			</div>
			<div class="form-group pt-2">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="pw" placeholder="Enter password" pattern="[a-zA-Z0-9]+" maxlength="20" required>
			</div>
                        <div class="text-center">
                            <?php
                            if(isset($_SESSION['login-error'])){
                                $login_error = $_SESSION['login-error'];

                                switch($login_error){
                                    case 1:
                                        echo "<span class=\"text-danger\">No empty fields are allowed.</span>";
                                        break;
                                    case 2:
                                        echo "<span class=\"text-danger\">Internal server error.</span>";
                                        break;
                                    case 3:
                                        echo "<span class=\"text-danger\">Invalid email or password.</span>";
                                        break;
                                }

                                unset($_SESSION['login-error']);
                            }
                            ?>
                            <br>
                            <button type="submit" class="mt-5 btn btn-primary" name="login-submit">Login</button>
			</div>
                    </form>
                    
                    <div class="text-right mt-5">
                        <span>Don't have an account? <a href="register.php">Click here to create one!</a></span>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>