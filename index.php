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
    require 'modules/dbconnect.php';
    include 'modules/navbar.php';
    
    if(!isset($_SESSION['email']))
        header("Location: login.php");
    ?>
    
    <body style="margin-top:80px;" class="mx-3 mx-lg-5">
        <?php   //test can remove
        echo $_SESSION['username'];
        echo "<br>";
        echo $_SESSION['email'];
        ?>
    </body>
</html>