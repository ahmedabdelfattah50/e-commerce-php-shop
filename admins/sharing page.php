<?php

    $do = '';
    if(isset($_GET['do'])) {
        $do = $_GET['do'];
    } else {
        $do = 'Manage';
    }

    if($do == 'Manage') {
        echo "Welcome to page manage";
    } elseif($do == 'Insert') {
        echo "Welcome to insert page";
    } else {
        echo "There is no page exist";
    }