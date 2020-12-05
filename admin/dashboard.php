<?php

    //START THE SESSION, ALWAYS REMEMBER TO START IT
    session_start();

    //INCLUDES
    include 'init.php';

    include $template . 'header.php';

    // CHECK IF THE USER HAVE THE ACCESS TO THE DASHBOARD
    if(isset($_SESSION['username'])){

        echo "<h1>Welcome " . $_SESSION['username'] . " You Have The Access To The Website !!!</h1>";

    }else{

        header('location: index.php');
        exit();
    }

    //Include Footer
    include $template . 'footer.php';

?>