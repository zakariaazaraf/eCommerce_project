<?php 
    // START THE SESSION 
    session_start();

    $titlePage = "Profil";

    include 'init.php';

    

    echo "<div class='alert alert-success'>Welcome ". $_SESSION['user'] ." To Your Profil :)</div>";
?>