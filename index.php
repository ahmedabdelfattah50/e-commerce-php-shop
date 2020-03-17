<?php

    // $noNavbar = '';
    $pageTitle = "Main Website";
    
    include 'init.php';                   // ======== include the init file ========   

    $stmt = $con->prepare("SELECT * FROM users");
    $stmt->execute();
    $cats = $stmt->fetchAll();

    foreach ($cats as $cat) {
        echo "<pre>";
        echo $cat['username'];
        echo "</pre>";
    }

    echo "Welcome to the main website";

    




