<?php
    // ########### this page is to destory the sign in the website

    session_start();                 // start data from the session
    session_unset();                // unset data from the session
    session_destroy();      // destroy data from the session
    header('Location:index.php');
    exit();