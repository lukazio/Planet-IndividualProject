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
                            <form action="action/changepw_action.php" method="post">
                                <div class="form-group col-12 col-md-6 px-0">
                                    <input type="password" class="form-control" name="new-pw" placeholder="New Password" pattern="[a-zA-Z0-9]+" maxlength="20" required>
                                </div>
                                <div class="form-group col-12 col-md-6 px-0">
                                    <input type="password" class="form-control" name="cfm-pw" placeholder="Confirm Password" pattern="[a-zA-Z0-9]+" maxlength="20" required>
                                </div>
                                <div class="form-group mt-3 pt-3 col-12 col-md-6 px-0" style="border-top: 1px solid #cccccc">
                                    <input type="password" class="form-control" name="current-pw" placeholder="Current Password" pattern="[a-zA-Z0-9]+" maxlength="20" required>
                                </div>
                                <div class="text-center text-md-left">
                                    <?php
                                    if(isset($_SESSION['changepw-error'])){
                                        $changepw_error = $_SESSION['changepw-error'];

                                        switch($changepw_error){
                                            case 1:
                                                echo "<span class=\"text-danger\">No empty fields are allowed.</span>";
                                                break;
                                            case 2:
                                                echo "<span class=\"text-danger\">New password and confirm password must match.</span>";
                                                break;
                                            case 3:
                                                echo "<span class=\"text-danger\">New password must not be the same as your old password.</span>";
                                                break;
                                            case 4:
                                                echo "<span class=\"text-danger\">Your current password is wrong.</span>";
                                                break;
                                            case 5:
                                                echo "<span class=\"text-success\">Your password has been successfully changed!</span>";
                                                break;
                                        }

                                        unset($_SESSION['changepw-error']);
                                    }
                                    ?>
                                </div>
                                <button type="submit" class="mt-3 btn btn-primary" name="changepw-submit">Change</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card bg-light border-info text-info mb-4" style="margin:0 20%;">
                <div class="card-header"><b>Invitations</b></div>
                <div class="card-body">
                    <?php
                    if(isset($_SESSION['joinboard-info'])){
                        $joinboard_info = $_SESSION['joinboard-info'];

                        switch($joinboard_info){
                            case 1:
                                echo "<span class=\"text-warning mb-3\">You have already joined that noteboard, the invitation will be deleted.</span>";
                                break;
                            case 2:
                                echo "<span class=\"text-success mb-3\">Invitation accepted and noteboard join success.</span>";
                                break;
                            case 3:
                                echo "<span class=\"text-danger mb-3\">Invitation rejected.</span>";
                                break;
                        }
                        echo '<div class="mb-3"></div>';
                        
                        unset($_SESSION['joinboard-info']);
                    }
                    
                    $currentEmail = $_SESSION['email'];
                    $inviteSql = "SELECT * FROM invite WHERE invite_to='$currentEmail' ORDER BY invite_datetime DESC;";
                    
                    if($inviteResult = mysqli_query($conn,$inviteSql)){
                        if(mysqli_num_rows($inviteResult) > 0){
                            while($row = mysqli_fetch_assoc($inviteResult)){
                                //Get sender's name
                                $nameSql = "SELECT user_name FROM user WHERE user_email='".$row['invite_from']."'";
                                $nameRow = mysqli_fetch_assoc(mysqli_query($conn,$nameSql));
                                $senderName = $nameRow['user_name'];
                                
                                //Get noteboard name
                                $boardNameSql = "SELECT board_name FROM noteboard WHERE board_id='".$row['invite_board']."'";
                                $boardRow = mysqli_fetch_assoc(mysqli_query($conn,$boardNameSql));
                                $boardName = $boardRow['board_name'];
                                
                                echo '<div class="row mb-4">';
                                    echo '<div class="col-12 col-md-7 text-wrap">';
                                        echo '<i class="fa fa-user fa-fw" aria-hidden="true"></i> <b>'.$senderName.'</b><br>';
                                        echo '<i class="fa fa-sticky-note fa-fw" aria-hidden="true"></i> <b>'.$boardName.'</b><br>';
                                        echo '<i class="fa fa-clock-o fa-fw" aria-hidden="true"></i> <b>'.$row['invite_datetime'].'</b><br>';
                                        echo $row['invite_msg'];
                                    echo '</div>';
                                    echo '<div class="col-12 col-md-5 mt-2 my-md-auto text-left text-md-right">';
                                        echo '<form action="action/joinboard_action.php" method="post">';
                                            echo '<div class="btn-group" role="group">';
                                                echo '<input type="hidden" name="joinboard-id" value="'.$row['invite_board'].'">';
                                                echo '<button type="submit" onclick="return confirm(\'Join the noteboard?\')" name="joinboard-accept-submit" value="'.$row['invite_id'].'" class="btn btn-success">Accept</button>';
                                                echo '<button type="submit" onclick="return confirm(\'Reject join invitation?\')" name="joinboard-reject-submit" value="'.$row['invite_id'].'" class="btn btn-danger">Reject</button>';
                                            echo '</div>';
                                        echo '</form>';
                                    echo '</div>';
                                echo '</div>';
                            }
                        }
                        else{
                            echo '<h4 class="text-info text-center">You have no pending invitations.</h4>';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>