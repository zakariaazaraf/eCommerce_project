<?php

    // Include Init.php File
    include "init.php";

    //Include Languages Files
    
    include "./includes/languages/english.php"; // English Lang
    //include "./includes/languages/french.php"; // English Lang
    //include "./includes/languages/arabic.php"; // English Lang 

    // Include The Header From Template Include
    include $template . "header.php";

    echo "<h2>Lang Test " . lang('GREETING') . "</h2>";

?>

<div class="btn btn-dark btn-inline">buttoon test</div>
<i class="fa fa-home fa-2x"></i>



<?php

    
    // Include The Footer From Template Include
    include $template . "footer.php";

?>