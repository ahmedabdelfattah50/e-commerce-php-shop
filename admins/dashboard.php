<?php
    session_start(); 
    if(isset($_SESSION['username'])) {
        include "init.php";
    }
?>

<h1>Hello <?php echo $_SESSION['username']?></h1>



