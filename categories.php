<?php

    // Include Init.php File
    include "init.php";
        
    echo "<h2>Welcome To Categories Page !! :)</h2>";

    echo "<pre>";
    print_r($_GET);
    echo "</pre>";

    // Include The Footer From Template Include
    include $template . "footer.php";

?>