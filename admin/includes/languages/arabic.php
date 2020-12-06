<?php

    // Declaring Arabic Phrases

    function lang($phrase){

        static $languages = array(

            "GREETING" => "مرحبا",
            "ADMIN" => "المسؤول"
        );

        return $languages[$phrase];
    }