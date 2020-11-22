<?php

    //START THE SESSION, ALWAYS REMEMBER TO START IT
    session_start();

    // CHECK IF THE USER HAVE THE ACCESS TO THE DASHBOARD
    if(isset($_SESSION['username'])){

        echo "<h1>Welcome " . $_SESSION['username'] . " You Have The Access To The Website !!!</h1>";

    }else{

        header('location: index.php');
    }

?>