<?php

    // START THE SESSION
    session_start();

    // UNSET THE SESSION DATA
    session_unset();

    // DESTROY THE SESSION
    session_destroy();

    // REDIRECT THE USER TO INDEX PAGE
    header("location: index.php");

    exit(); // FOR AVOID THE ERROR IF THE LOCATION WAS WRONG