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

            <div class="advertisements-card profil-cards">
                <div class="container">
                    <div class="card bg-primary">
                        <h5 class="card-header">Ads Section</h5>
                        <div class="card-body">                     
                            <h4 class="card-title">
                                your info
                            </h4>
                            <p class="card-text">
                                Body Of Information
                            </p>                
                        </div>
                        
                    </div>
                </div>
            </div>

            <div class="Comments-card profil-cards">
                <div class="container">
                    <div class="card bg-secondary">
                        <h5 class="card-header">Latest Comments</h5>
                        <div class="card-body">                     
                            <h4 class="card-title">
                                your info
                            </h4>
                            <p class="card-text">
                                Body Of Information
                            </p>                
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



