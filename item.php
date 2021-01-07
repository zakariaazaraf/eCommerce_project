<?php

    $titlePage = 'Item';

    include 'init.php';

    

    $itemId = isset($_GET['itemid']) ? is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 : null;

    if($itemId){

        if(checkItem('Item_ID', 'items', $itemId)){
            echo "<h1>The Item Info</h1>";
        }else{
            $msg = "<div class='alert alert-danger'>This Item Doesn't Exists</div>";
            redirectHome($msg, 'index.php', 1);
        }     
    }else{
        $msg = "<div class='alert alert-danger'>You Can't Access This Page Directly</div>";
        redirectHome($msg, 'index.php', 1);
    }

    echo "<pre>";
    print_r($_GET);
    echo "</pre>";


    include $template . 'footer.php';

?>