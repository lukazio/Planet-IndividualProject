<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Planet - Home</title>
        
        <?php
        require 'modules/link.php';
        ?>
    </head>
    
    <?php
    session_start(); //session start put in navbar.php
    require 'modules/dbconnect.php';
    include 'modules/navbar.php';
    
    if(!isset($_SESSION['email']))
        header("Location: login.php");
    ?>
    
    <body>
        <a href="login.php" class="h1">test login</a>
        <a href="action/logout_action.php" class="h1">test logout</a>
        <?php   //test can remove
        echo $_SESSION['username'];
        echo "<br>";
        echo $_SESSION['email'];
        ?>
    </body>
</html>