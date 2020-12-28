<?php

    // DATABASE CONNECTION
    include 'connect.php';

    // Routes
    
    $template = './includes/templates/'; // Template Directory

    $function = './includes/functions/'; // Functions Directroy

    $css = './layout/css/'; // Css Directory

    $js = './layout/js/'; // Js Directory

    $language = './includes/languages/'; // languages directory

    // Include Functions File
    include $function . "functions.php";

    //Include Languages Files 
    include $language . "english.php"; // English Language

    // Include The Header From Template Include
    include $template . "header.php";




    
    