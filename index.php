<?php

    // START THE SESSION TO CHECK IF THIS USER WAS REGISTRED
    session_start();

    $titlePage = "Home";

    // Include Init.php File
    include "init.php";

    

    if(isset($_SESSION['user'])){

        if(!checkUserStatus($_SESSION['user'])){
            echo "<div class='aler alert-success'>You Have All The Functionalies !! :)</div>";
        }else{
            echo "<div class='alert alert-danger'>You Haven't All Functionalties !! :(</div>";
        } 

        // FETCH ALL ITEMS OR IMITED NUMBER
        $stat = $db->prepare("SELECT * FROM items");
        $stat->execute();
        $items = $stat->fetchAll();

        echo "<div class='container'>";
    
            echo "<div class='cards'>";
                $i = 0;
                foreach($items as $item){
                    echo "<div class='card'>";
                        echo "<img class='card-img-top img-fluid' src='./layout/images/item".++$i.".jpg' alt='".$item['Name']."'/>";
                        echo "<div class='card-body'>";
                            echo "<div class='card-title'>".$item['Name']."</div>";
                            echo "<div class='card-text'>".$item['Description']."</div>";
                            echo "<p class='card-text d-flex justify-content-between'><small class='text-muted'>".$item['Made_In']."</small><small class='text-muted'>".$item['Add_Date']."</small></p>";
                            echo "<span class='price'>".$item['Price']."</sapn>";
                        echo "</div>";
                    echo "</div>";
                    $i = ($i === 9) ? 0 : $i;
                }
            echo "</div>";

        echo "</div>";

       
    }else{
        header('Location: login.php');
        exit();
    }
        
    

    // Include The Footer From Template Include
    include $template . "footer.php";

?>