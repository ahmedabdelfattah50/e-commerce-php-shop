<?php

    function lang( $phrase ) {
        static $lang = array(            
            // Generial Character
            'title'       => 'E-Commerce Shop',
            'HomeTitle'   => 'Home'              
        );

        return $lang[$phrase];
    }