<?php
if(!isset($_SESSION))
    session_start();
?>

<nav class="fixed-top navbar navbar-expand-md navbar-dark bg-dark px-3 px-lg-5">
    <a class="navbar-brand" href="index.php">
        <img src="img/planet.png" width="35" height="35" class="d-inline-block align-top mr-1" alt="">
        <span class="h3">Planet</span>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Expand navbar">
        <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="about.php">About</a>
            </li>
        </ul>
        
        <ul class="navbar-nav flex-row ml-auto">
            <li class="nav-item active dropdown">
                <a class="nav-link dropdown-toggle" href="" id="profileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="img/profile_icon.png" width="35" height="35" class="d-none d-md-inline-block align-middle mr-2" alt="">
                    <?php
                    $countInviteSql = "SELECT COUNT(*) FROM invite WHERE invite_to='".$_SESSION['email']."'";
                    $countInviteRow = mysqli_fetch_array(mysqli_query($conn,$countInviteSql));
                    $countInvite = intval($countInviteRow[0]);
                    
                    echo $_SESSION['username'];
                    if($countInvite > 0)
                        echo ' <span class="badge badge-danger">'.$countInvite.'</span>';
                    ?>
                </a>
                <div class="dropdown-menu" aria-labelledby="profileDropdown">
                    <a class="dropdown-item" href="profile.php">Profile</a>
                    <a class="dropdown-item text-danger" href="action/logout_action.php">Logout</a>
                </div>
            </li>
        </ul>
    </div>
</nav>