<?php

    $titlePage = 'Item';

    include 'init.php';

    

    $itemId = isset($_GET['itemid']) ? is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 : null;

    if($itemId){

        if(checkItem('Item_ID', 'items', $itemId)){
            
            /* $item = getItems('Item_ID', $itemId); */
            $stat = $db->prepare("SELECT I.*, U.UserName as username, C.Name as category 
                                        FROM items  as I
                                        INNER JOIN users as U
                                        ON I.UserId = U.UserId
                                        INNER JOIN categories as C
                                        ON I.Cat_Id = C.Cat_Id
                                        WHERE I.Item_ID = ?");

            $stat->execute(array($itemId));
            $item = $stat->fetch();

            echo "<div class='container'>";
                echo "<div class='item mt-5'>";
                    echo "<div class='card bg-dark text-white justify-content-between no-gutters'>";
                        echo "<img class='card-img col-md-4' src='./layout/images/item1.jpg' alt='Image'/>";
                        echo "<span class='price'>".$item['Price']."</span>";
                        echo "<div class='card-body col-md-7 py-4'>";
                            echo "<h4 class='card-title'>".$item['Name']."</h4>";
                            echo "<p class='card-text'>".$item['Description']."</p>";
                            echo "<p class='card-text'><i class='fas fa-calendar-day pr-2'></i><strong>Added Date :</strong>".$item['Add_Date']."</p>";
                            echo "<p class='card-text'><i class='fas fa-house-damage pr-2'></i><strong>Made In :</strong>".$item['Made_In']."</p>";
                            echo "<p class='card-text'><i class='fas fa-dollar-sign pr-2'></i><strong>Price :</strong>".$item['Price']."</p>";
                            echo "<p class='card-text'><i class='fas fa-puzzle-piece pr-2'></i><strong>Category :</strong>".$item['category']."</p>";
                            echo "<p class='card-text'><i class='fas fa-signature pr-2'></i><strong>Added By :</strong>".$item['username']."</p>";
                            
                        echo "</div>";
                    echo "</div>";
                echo "</div>";

            echo "</div>";

            echo "<pre>";
            print_r($item);
            echo "</pre>";
        }else{
            $msg = "<div class='alert alert-danger'>This Item Doesn't Exists</div>";
            redirectHome($msg, 'index.php', 1);
        }     
    }else{
        $msg = "<div class='alert alert-danger'>You Can't Access This Page Directly</div>";
        redirectHome($msg, 'index.php', 1);
    }

    


    include $template . 'footer.php';

?>