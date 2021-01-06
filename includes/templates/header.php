<?php

    // START THE SESSION 
    //session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="zakaria azaraf">
        <title><?php echo getTitle(); ?></title>
        <!-- The bootstrap fraemwork -->
        <link rel="stylesheet" href="<?php echo $css ?>libs/bootstrap.min.css">
        <!-- The font Awesome librery -->
        <link rel="stylesheet" href="<?php echo $css ?>all.min.css">
        <!-- The Normalize Css File -->
        <link rel="stylesheet" href="<?php echo $css ?>libs/normalize.css">
        <!-- Main Css File -->
        
        <link rel="stylesheet" href="<?php echo $css ?>custom/frontend.css?v=<?php echo time(); ?>">
        

    </head>
    <body>
        <div class="container">
            <div class="log-bar d-flex justify-content-between">
                <a href="#" class="logo">Logoo</a>

                <!-- CHECK THE PERMISSION OF THE USER -->
                <?php echo !checkUserStatus($sessionUser) && ($sessionUser) ? '<a href="profil.php" class="logo">Profil</a>' : ''?> 
                
                <a href="logout.php" class="logo">LogOut</a>
                <a href="newAd.php" class="logo">new ads</a>
                
                <div>
                    <a href="login.php" class="login">Login</a>
                    <a href="login.php" class="signup">Sigin up</a>
                </div>

                
            </div>
        </div>
    <!-- BRING THE NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container justify-content-between">

            <div>
                <a class="navbar-brand" href="#">Logo Link</a>
                <button class="navbar-toggler" 
                        type="button" 
                        data-toggle="collapse" 
                        data-target="#zakaria" 
                        aria-controls="navbarSupportedContent" 
                        aria-expanded="false" 
                        aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>

            <div class="collapse navbar-collapse navbar-right">
                <ul class="navbar-nav mr-auto">

                    <?php
                        // CALL getCategories FUNCTION
                        $categories = getCategories(5);
                        foreach($categories as $category){
                            echo '<li>';
                                echo '<a class="nav-link" href="categories.php?categoryid='.$category['Cat_Id'].'&catname='.$category['Name'].'">'.$category['Name'].'</a>';
                            echo '</li>';
                        }      
                    ?>
                    
                </ul>
            </div>
      
        </div>
    </nav>
