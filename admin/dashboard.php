<?php

    //START THE SESSION, ALWAYS REMEMBER TO START IT
    session_start();

    $titlePage = "Dashborad";

    //INCLUDES
    include 'init.php';

    // CHECK IF THE USER HAVE THE ACCESS TO THE DASHBOARD
    if(isset($_SESSION['username'])){

        echo "<h1>Welcome " . $_SESSION['username'] . " You Have The Access To The Website !!!</h1>";
        echo "<h3>Your ID : " . $_SESSION['userID']. "</h3>";
    }else{

        header('location: index.php');
        exit();
    }

    //Include Footer
    include $template . 'footer.php';

?>