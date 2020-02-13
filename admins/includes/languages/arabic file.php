<?php

    function lang( $phrase ) {
        static $lang = array(

            // the Home page 

            "hello" => " أهلا بك فى لوحة التحكم",
            "name" => "أستاذ أحمد"
        );

        return $lang[$phrase];
    }