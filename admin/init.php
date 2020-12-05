<?php

    // DATABASE CONNECTION
    include 'connect.php';

    // Routes
    
    $template = './includes/templates/'; // Template Directory

    $css = './layout/css/'; // Css Directory

    $js = './layout/js/'; // Js Directory

    $language = './includes/languages/'; // languages directory

    //Include Languages Files 
    include $language . "english.php"; // English Language

    // Include The Header From Template Include
    include $template . "header.php";

    // Include this navbar in the page or Not, by verify if $navbar is set
    if(!isset($navbar)){
        include $template . "navbar.php";
    }


    
    