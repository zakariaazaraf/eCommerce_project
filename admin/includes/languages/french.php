<?php

    // Declaring Freanch Phrases

    function lang($phrase){

        static $languages = array(
            "GREETING" => "bonjour",
            "ADMIN" => "administrateur"
        );

        return $languages[$phrase];
    }