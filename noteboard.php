<!DOCTYPE html>
<?php
require 'modules/dbconnect.php';

$board_id = filter_input(INPUT_GET,'id');

$boardInfoSql = "SELECT * FROM noteboard WHERE board_id='$board_id'";
$board_info = mysqli_fetch_assoc(mysqli_query($conn,$boardInfoSql));
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Planet - <?php echo $board_info['board_name']; ?></title>
        
        <?php
        require 'modules/link.php';
        ?>
    </head>
    
    <?php
    include 'modules/navbar.php';
    
    if(!isset($_SESSION['email']))
        header("Location: login.php");
    ?>
    
    <body>
        <?php
        // put your code here
        ?>
    </body>
</html>
