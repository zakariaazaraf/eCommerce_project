<?php 
    // START THE SESSION 
    session_start();

    $titlePage = "Profil";

    include 'init.php';

    if($sessionUser){

        // FETCH THE DATA RELATED TO THIS USER
        $stat = $db->prepare("SELECT * FROM users WHERE UserName = ?");
        $stat->bindParam(1, $sessionUser);
        $stat->execute();
        $userInfo = $stat->fetch();

        echo "<h1 class='text-center'>Welcome " . $sessionUser . " </h1>";

        ?>
            <div class="inforamtion-card profil-cards">
                <div class="container">
                    <div class="card bg-dark">
                        <h5 class="card-header">Personal Info</h5>
                        <div class="card-body">                     
                            <h4 class="card-title">
                                Your Infotmation:  
                            </h4>
                            <p class="card-text">
                                Name: <?php echo $userInfo['UserName'] . "<br />"?>
                                Full Name: <?php echo $userInfo['FullName'] . "<br />"?>
                                Email: <?php echo $userInfo['Email'] . "<br />"?>
                                Registred Date: <?php echo $userInfo['Date'] . "<br />"?>
                                Favorite Category: Games
                            </p>                
                        </div>
                       <!--  <div class="card-footer text-center text-muted">    
                            2 Days
                        </div> -->
                    </div>
                </div>
            </div>

            <?php 
                echo '<div class="advertisements-card mb-3">';
                    echo "<div class='container'>";
                        echo "<div class='card bg-dark'>";
                            echo "<h5 class='card-header'>Ads Section</h5>";
                            echo "<div class='card-body cards'>";
                                foreach(getItems('UserId', $userInfo['UserId']) as $item){
                                    echo "<div class='card'>";
                                        echo "<img class='card-img-top img-fluid' src='./layout/images/item1.jpg' alt='".$item['Name']."'/>";
                                        echo "<div class='card-body'>";
                                            echo "<p class='card-title'>".$item['Name']."</p>";
                                            echo "<p class='card-text'>".$item['Description']."</p>";
                                            echo "<p class='card-text'><small class='text-muted'>".$item['Made_In']."</small></p>";
                                            echo "<span class='price'>".$item['Price']."</sapn>";
                                        echo "</div>";
                                    echo "</div>";
                                }
                            echo "</div>";
                        echo "</div>";
                    echo "</div>";
                echo "</div>";

            ?>

         

            <div class="comments-card profil-cards">
                <div class="container">
                    <div class="card bg-dark">
                        <h5 class="card-header">Latest Comments</h5>
                        <div class="card-body">                     
                            <?php 
                                $stat = $db->prepare("SELECT 
                                                            U.UserName as username, I.Name as itemName, C.Comment, C.Comment_Date 
                                                        FROM 
                                                                comments as C 
                                                            INNER JOIN 
                                                                items as I 
                                                            On 
                                                                C.Item_Id = I.Item_Id 
                                                            INNER JOIN 
                                                                users as U 
                                                            ON 
                                                                C.User_Id = U.UserId WHERE U.UserId = ?");

                                $stat->execute(array($userInfo['UserId']));
                                $userComments = $stat->fetchAll();

                                if($userComments){
                                    foreach($userComments as $comment){
                                        echo "<div class='comment'>";
                                            echo "<h4 class='card-title'>".$comment['itemName']."</h4>";
                                            echo "<div class='d-flex justify-content-between'>";
                                                echo "<p class='card-text'>" . $comment['Comment'] . "</p>";
                                                echo "<small class='text-muted'>".$comment['Comment_Date']."</small>";
                                            echo "</div>";
                                        echo "</div>";
                                    }    
                                }
                            ?>               
                        </div>
                        
                    </div>
                </div>
            </div>

        <?php

    }else{
        header('Location: login.php');
        exit();
    }

    include $template . 'footer.php';
   
?>



