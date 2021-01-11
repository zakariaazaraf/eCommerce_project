<?php

    // STARTING THE SESSION
    session_start();

    $titlePage = 'categories';

    // Include Init.php File
    include "init.php";
    
    echo "<div class='container'>";
    
        echo "<h1 class='text-center'>Welcome To ".$_GET['catname']." Category !! :)</h1>";
        $cat_Id = $_GET['categoryid'];

        echo "<div class='cards'>";
            $i = 3;
            foreach(getItems('Cat_Id', $cat_Id) as $item){
                echo "<div class='card'><a class='card-item' href='item.php?itemid=".$item['Item_ID']."'>";
                    echo "<img class='card-img-top img-fluid' src='./layout/images/item".++$i.".jpg' alt='".$item['Name']."'/>";
                    echo "<div class='card-body'>";
                        echo "<div class='card-title'>".$item['Name']."</div>";
                        echo "<div class='card-text'>".$item['Description']."</div>";
                        echo "<div class='card-text'><small class='text-muted'>".$item['Made_In']."</small></div>";
                        echo "<span class='price'>".$item['Price']."</sapn>";
                    echo "</div>";
                echo "</a></div>";
                $i = $i > 9 ? 0 : $i;
            }
        echo "</div>";

    echo "</div>";


    // Include The Footer From Template Include
    include $template . "footer.php";

?>