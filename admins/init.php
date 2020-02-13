<?php

    // ====================== Routes #######################
    
    $tmpl = 'includes/templates/';              // path of template admin    
    $css_path = 'layout/CSS/';                  // path of CSS     
    $js_path = 'layout/JS/';                    // path of JS    
    $lang_path = 'includes/languages/';         // path of languages file

    // ====================== Files include #######################

    // the connection with database
    include 'connect database.php';
    include $lang_path . 'english file.php';         // ======== inclue the english file ======== 
    include $tmpl . "header.php";                    // ======== inclue the header ======== 

    if(!isset($noNavbar)) {                // ##### if it has not noNavbar variable it will include the navbar file 
        include $tmpl . "navbar.php";                    // ======== inclue the navbar ========    
    }
