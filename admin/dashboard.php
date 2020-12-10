<?php

    //START THE SESSION, ALWAYS REMEMBER TO START IT
    session_start();

    $titlePage = "Dashborad";

    //INCLUDES
    include 'init.php';

    // CHECK IF THE USER HAVE THE ACCESS TO THE DASHBOARD
    if(isset($_SESSION['username'])){

        echo "<div class='container'><h1 class='text-center'>Welcome " . $_SESSION['username'] . " You Have The Access To The Website !!!</h1></div>";
        
    }else{

        header('location: index.php');
        exit();
    }

    //Include Footer
    include $template . 'footer.php';

?>