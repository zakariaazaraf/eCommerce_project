<?php

    // Declaring English Phrases

    function lang($phrase){

        static $languages = array(

            // NAVBAR KEYS
            "LOGO" => "ShopNow",
            "CATEGORIES" => "Categories",
            "ITEMS" => "Items",
            "MEMBERS" => "Members",
            "LOGOSTICS" => "Logostics",
            "LOGS" => "Logs",


            "GREETING" => "Welcome",
            "ADMIN" => "administrator"
        );

        return $languages[$phrase];
    }