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
        <link rel="stylesheet" href="<?php echo $css ?>custom/style.css?v=<?php echo time(); ?>">
        

    </head>
    <body>

    <!-- BRING THE NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="#">Logo Link</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#zakaria" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="zakaria">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="#">Link 1</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link 2</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link 3</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link 4</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link 5</a>
        </li>
      </ul>
    </div>
      
      <div class="collapse navbar-collapse" id="zakaria">
        <ul class="nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Zakaria
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="members.php?do=edit&userid=<?php echo $_SESSION['userID']; ?>">Edit Profile</a>
            <a class="dropdown-item" href="#">Settings</a>
            <a class="dropdown-item" href="logout.php">Logout</a>
          </div>
        </li>
      </ul>
      </div>
      
    
  </div>
</nav>
