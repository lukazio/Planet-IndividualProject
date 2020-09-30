<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Planet - About</title>
        
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
        <h3 class="text-info">
            Made by Lukaz Lim Wei Hwang<br>
            303COM Individual Project<br>
            IICP: P17009036<br>
            CU: 9856242<br>
            <br>
            GitHub repo: <a href="https://github.com/lukazio/Planet-IndividualProject">https://github.com/lukazio/Planet-IndividualProject</a>
        </h3>
    </body>
</html>