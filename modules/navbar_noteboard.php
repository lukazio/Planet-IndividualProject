<?php
if(!isset($_SESSION))
    session_start();
?>

<nav class="fixed-top navbar navbar-expand-md navbar-dark px-3 px-lg-5" style="background-color: #73808c;">
    <a class="navbar-brand">
        <span class="h5 text-white">
            <?php
            if($error_code == 1)
                echo "ERROR: Invalid ID";
            else{
                echo $board_info['board_name'];
                
                //Check if current user is this board's owner or not to access invite and kick controls
                $currentBoardId = $board_info['board_id'];
                $ownerFormSql = "SELECT * FROM noteboard WHERE board_id='$currentBoardId' AND board_owner='$currentUserId';";
                $ownerFormResult = mysqli_query($conn,$ownerFormSql);
            }
            ?>
        </span>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Expand navbar">
        <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="index.php">Home</a>
            </li>
        </ul>
        
        <ul class="navbar-nav ml-auto">
            <li class="nav-item active dropdown">
                <a class="nav-link dropdown-toggle" href="" title="List of members in this noteboard" id="profileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <b>Members</b>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profileDropdown">
                    <?php
                    $ownerNameSql = "SELECT user_name,user_email FROM user WHERE user_id='".$board_info['board_owner']."';";
                    $ownerNameRow = mysqli_fetch_assoc(mysqli_query($conn,$ownerNameSql));
                    ?>
                    <a class="dropdown-item text-info" href="#" title="<?php echo $ownerNameRow['user_email']; ?> (Owner)">
                        <span><i class="fa fa-fw fa-user" aria-hidden="true"></i><?php echo " ".$ownerNameRow['user_name']; ?></span>
                    </a>
                    <?php
                    if($error_code == 0){
                        $currentBoardId = $board_info['board_id'];
                        $memberSql = "SELECT user_id FROM user_noteboard WHERE board_id='$currentBoardId';";
                        
                        if($memberResult = mysqli_query($conn,$memberSql)){
                            if(mysqli_num_rows($memberResult) > 0){
                                while($row = mysqli_fetch_assoc($memberResult)){
                                    $currentMemberId = $row['user_id'];
                                    $usernameSql = "SELECT user_name,user_email FROM user WHERE user_id='$currentMemberId';";
                                    $usernameResult = mysqli_query($conn,$usernameSql);
                                    $userRow = mysqli_fetch_assoc($usernameResult);
                                    
                                    echo '<a class="dropdown-item pb-0" href="#" title="'.$userRow['user_email'].'">'
                                        . '<span><i class="fa fa-fw fa-user" aria-hidden="true"></i> '.$userRow['user_name'].'</span>';
                                    //Allow user to kick members if is board owner
                                    if(mysqli_num_rows($ownerFormResult) > 0){
                                        echo '<form class="d-inline-block" action="action/kickuser_action.php" method="post">'
                                            . '<input type="hidden" name="board_id" value="'.$board_info['board_id'].'">'
                                            . '<button type="submit" onclick="return confirm(\'Are you sure you want to kick '.$userRow['user_name'].'?\')" name="kickuser-submit" value="'.$currentMemberId.'" class="ml-1 btn btn-sm btn-danger"><i class="fa fa-sign-out" aria-hidden="true"></i></button>'
                                           . '</form>';
                                    }
                                    echo '</a>';
                                }
                            }
                        }
                    }
                    ?>
                </div>
            </li>
            <li class="nav-item active dropdown">
                <a class="nav-link dropdown-toggle" href="" title="Pending invites for this noteboard" id="profileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <b>Pending</b>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profileDropdown">
                    <?php
                    if($error_code == 0){
                        $currentBoardId = $board_info['board_id'];
                        $boardInviteSql = "SELECT invite_to,invite_id FROM invite WHERE invite_board='$currentBoardId';";
                        
                        if($boardInviteResult = mysqli_query($conn,$boardInviteSql)){
                            if(mysqli_num_rows($boardInviteResult) > 0){
                                while($row = mysqli_fetch_assoc($boardInviteResult)){
                                    echo '<a class="dropdown-item pb-0" href="#">'
                                        . '<span><i class="fa fa-fw fa-envelope" aria-hidden="true"></i> '.$row['invite_to'].'</span>';
                                    //Allow user to revoke invites if is board owner
                                    if(mysqli_num_rows($ownerFormResult) > 0){
                                        echo '<form class="d-inline-block" action="action/removeinvite_action.php" method="post">'
                                            . '<input type="hidden" name="board_id" value="'.$board_info['board_id'].'">'
                                            . '<button type="submit" onclick="return confirm(\'Remove invitation for '.$row['invite_to'].'?\')" name="removeinvite-submit" value="'.$row['invite_id'].'" class="ml-1 btn btn-sm btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>'
                                           . '</form>';
                                    }
                                    echo '</a>';
                                }
                            }
                        }
                    }
                    ?>
                </div>
            </li>
            <?php
            if($error_code == 0){
                if(mysqli_num_rows($ownerFormResult) == 1){
                    echo '<li class="nav-item active dropdown">'
                            . '<a class="nav-link dropdown-toggle" href="" title="Invite new users to this noteboard" id="profileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
                                . '<b>Invite User</b>'
                            . '</a>'
                            . '<div class="dropdown-menu dropdown-menu-right p-2" aria-labelledby="profileDropdown">'
                                . '<form action="action/inviteuser_action.php" method="post">'
                                    . '<input type="email" class="form-control form-control-sm" name="invite_email" placeholder="Email" required>'
                                    . '<input type="text" class="form-control form-control-sm" name="invite_msg" placeholder="Message" pattern="[a-zA-Z0-9 ]+" maxlength="100" required>'
                                    . '<input type="hidden" name="invite_board" value="'.$board_info['board_id'].'">'
                                    . '<input type="hidden" name="invite_from" value="'.$_SESSION['email'].'">'
                                    . '<button type="submit" class="btn btn-sm btn-success" name="inviteuser-submit" onclick="return confirm(\'Invite this user?\')"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>'
                                . '</form>'
                            . '</div>'
                        . '</li>';
                }
            }
            ?>
        </ul>
    </div>
</nav>