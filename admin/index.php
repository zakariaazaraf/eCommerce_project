<?php

    // Include Init.php File
    include "init.php";

    //Include Languages Files
    
    include "./includes/languages/english.php"; // English Lang
    //include "./includes/languages/french.php"; // English Lang
    //include "./includes/languages/arabic.php"; // English Lang 

    // Include The Header From Template Include
    include $template . "header.php";


?>

<form class="login">

    <h3 class="text-center">Login To Forum</h3>

    <input class="form-control" type="text" name="username" placeholder="Username" autocomplate="off" />

    <input class="form-control" type="password" name="password" placeholder="Password" autocomplate="new-password"/> 

    <input class="btn btn-primary btn-block"type="submit" value="Login"/>

</form>



<?php

    
    // Include The Footer From Template Include
    include $template . "footer.php";

?>