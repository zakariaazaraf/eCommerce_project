<?php

    // Declaring English Phrases

    function lang($phrase){

        static $languages = array(
            "GREETING" => "Welcome",
            "ADMIN" => "administrator"
        );

        return $languages[$phrase];
    }