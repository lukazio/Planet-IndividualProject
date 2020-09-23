<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Planet - Profile</title>
        
        <?php
        require 'modules/link.php';
        ?>
    </head>
    
    <?php
    require 'modules/dbconnect.php';
    include 'modules/navbar.php';
    
    if(!isset($_SESSION['email']))
        header("Location: login.php");
    ?>
    
    <body style="margin-top:80px;" class="mx-3 mx-lg-5">
        <div class="container-fluid">
            <div class="card bg-light border-secondary mb-5" style="margin:0 20%;">
                <div class="card-header"><b>Profile</b></div>
                <div class="card-body">
                    <div class="row my-2 mb-5">
                        <div class="col-12 col-md-6 text-center text-md-right align-self-center">
                            <img class="img-fluid" src="img/profile_icon_black.png" height="150" width="150" alt="">
                        </div>
                        <div class="col-12 col-md-6 text-center text-md-left align-self-center">
                            <h2><?php echo $_SESSION['username']; ?></h2>
                            <p><?php echo $_SESSION['email']; ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mb-3 text-center text-md-left">
                            <h4 class="text-secondary">Change Password</h4>
                        </div>
                        <div class="col-12 text-center text-md-left">
                            <form action="action/changepw_action" method="post">
                                <div class="form-group mb-3 pb-3 col-12 col-md-6 px-0" style="border-bottom: 1px solid #cccccc">
                                    <input type="password" class="form-control" name="current-pw" placeholder="Current Password" pattern="[a-zA-Z0-9]+" maxlength="20" required>
                                </div>
                                <div class="form-group col-12 col-md-6 px-0">
                                    <input type="password" class="form-control" name="new-pw" placeholder="New Password" pattern="[a-zA-Z0-9]+" maxlength="20" required>
                                </div>
                                <div class="form-group col-12 col-md-6 px-0">
                                    <input type="password" class="form-control" name="cfm-pw" placeholder="Confirm Password" pattern="[a-zA-Z0-9]+" maxlength="20" required>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card bg-light border-info text-info" style="margin:0 20%;">
                <div class="card-header"><b>Invitations</b></div>
                <div class="card-body">
                    <?php
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>