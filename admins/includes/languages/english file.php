<?php

    function lang( $phrase ) {
        static $lang = array(
            // the Home page 

            "hello" => "Hello To Your page of control",
            "name" => " MR/ Ahmed"
        );

        return $lang[$phrase];
    }