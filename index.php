<?php

    // START THE SESSION TO CHECK IF THIS USER WAS REGISTRED
    session_start();

    // Include Init.php File
    include "init.php";

    if(isset($_SESSION['user'])){
        echo '<h1 class="bg-primary d-flex justify-content-center mh-100 align-items-center">Hello From The Outside !!! :)</h1>';
        /* session_unset();
        session_destroy();
        exit(); */
    }else{
        header('Location: login.php');
        exit();
    }
        
    

    // Include The Footer From Template Include
    include $template . "footer.php";

?>