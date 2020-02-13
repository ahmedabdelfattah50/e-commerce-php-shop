<?php

    session_start();
    if(isset($_SESSION['username'])) {
        header('Location: dashboard.php');
        echo "Hello " . $_SESSION['username'];
    } else {
        echo "you can't Enter This page";
    }