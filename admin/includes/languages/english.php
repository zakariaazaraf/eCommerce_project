<?php

    // Declaring English Phrases

    function lang($phrase){

        static $languages = array(
            "HOME" => "Home",
            "PRODUCT" => "Product",
            "CATEGORIES" => "Categories",
            "CAT1" => "Fashon",
            "CAT2" => "Toys",

            "GREETING" => "Welcome",
            "ADMIN" => "administrator"
        );

        return $languages[$phrase];
    }