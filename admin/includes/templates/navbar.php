<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="dashboard.php"><?php echo lang('LOGO')?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#zakaria" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="zakaria">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="categories.php"><?php echo lang("CATEGORIES") ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="items.php"><?php echo lang("ITEMS") ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="members.php"><?php echo lang("MEMBERS") ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#"><?php echo lang("LOGOSTICS") ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="comments.php"><?php echo lang("COMMENTS") ?></a>
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
            <a class="dropdown-item" href="../index.php">Shop</a>
            <a class="dropdown-item" href="members.php?do=edit&userid=<?php echo $_SESSION['userID']; ?>">Edit Profile</a>
            <a class="dropdown-item" href="#">Settings</a>
            <a class="dropdown-item" href="logout.php">Logout</a>
          </div>
        </li>
      </ul>
      </div>
      
    
  </div>
</nav>
