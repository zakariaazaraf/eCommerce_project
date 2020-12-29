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
