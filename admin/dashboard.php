<?php

    //START THE SESSION, ALWAYS REMEMBER TO START IT
    session_start();

    $titlePage = "Dashborad";

    //INCLUDES
    include 'init.php';

    // CHECK IF THE USER HAVE THE ACCESS TO THE DASHBOARD
    if(isset($_SESSION['username'])){

        echo "<div class='container'><h1 class='text-center'>Welcome " . $_SESSION['username'] . " To Dashboard !!!</h1></div>";

        // GET THE LATEST USERS
        $limitUsers = 5;
        $latestUsers = getLatest('*', 'users', 'UserId', $limitUsers);
        $limitUsers = count($latestUsers); // IF THE USERS IN DB LESS THEN LIMIT WE PASS

        // GET THE LATEST ITEMS
        $limitItems = 5;
        $latestItems = getLatest('*', 'items', 'Item_ID', $limitItems);
        $limitItems = count($latestItems);
        
    }else{

        header('location: index.php');
        exit();
    }

    ?>

    <!-- START DASHBOARD BODY -->

    <div class="container home-static text-center text-capitalize">
        <div class="row">

            <div class="col-md-6 col-lg-3 px-lg-1 my-1">              
                <div class='static st-members d-flex align-items-center justify-content-around'>
                    <i class="fas fa-users"></i>
                    <div>
                        total members
                        <a href="members.php">
                            <span class='d-block'><?php echo countColumns('UserId', 'users')?></span>
                        </a>
                    </div>                   
                </div>
            </div>

            <div class="col-md-6 col-lg-3 px-lg-1 my-1">
                <div class='static st-panding d-flex align-items-center justify-content-around'>
                        <i class="fas fa-plane-arrival"></i>
                        <div>
                            panding memebers
                            <a href='members.php?do=Manage&page=panding'>
                                <span class='d-block'><?php echo checkItem('RegStatus', 'users', 0)?></span>
                            </a>
                        </div>                   
                </div>
            </div>
            
            <div class="col-md-6 col-lg-3 px-lg-1 my-1">
                <div class='static st-items d-flex align-items-center justify-content-around'>
                    <i class="fas fa-gopuram"></i>
                    <div>
                        total items
                        <a href='items.php?do=Manage'>
                            <span class='d-block'><?php echo countColumns('Item_ID', 'items')?></span>
                        </a>
                    </div>                   
                </div>
            </div>

            <div class="col-md-6 col-lg-3 px-lg-1 my-1">
                <div class='static st-comments d-flex align-items-center justify-content-around'>
                    <i class="fas fa-comments"></i>
                    <div>
                        total comments
                        <a href='comments.php?do=Manage'>
                            <span class='d-block'><?php echo countColumns('Comment_Id', 'comments')?></span>
                        </a>
                    </div>                   
                </div>
            </div>
      
        </div>
    </div>

    <div class="container latest">
        <div class="row">
            <div class="col-sm-6 px-lg-1">
                <div class="card my-4">
                    <h4 class="card-header selected">
                        <i class='fas fa-users'></i> 
                        Latest 
                        <?php echo $limitUsers ?> 
                        Registred Users 
                        <span class="plus">
                            <i class="plus fas fa-plus"></i>
                        </span>
                    </h4>
                    <div class="card-body">
                        <div class="card-text">
                            <ul class="list-group">
                                <?php
                                    // BRING LATEST USERS 
                                    foreach($latestUsers as $$user){
                                        echo '<li class="list-group-item py-2 px-2 d-flex col justify-content-between">';
                                            echo '<p class="m-0 p-0 font-weight-bold text-capitalize">' .$$user['UserName']. '</p>';
                                            echo '<div class="p-0 d-flex justify-content-between">';
                                                echo '<a href="members.php?do=edit&userid='.$$user['UserId'].'" class="btn btn-success mx-1 py-1 px-2"><i class="fas fa-edit"></i>Edit</a>';
                                                // DISPLAY ACTIVATE BUTTON CONDTION
                                                echo !$$user['RegStatus'] ? '<a href="members.php?do=activate&userid='.$$user['UserId'].'" class="btn btn-info mx-1 py-1 px-2"><i class="fas fa-pen-fancy">Activate</i></a>' : '';
                                            echo '</div>';
                                        echo '</li>';
                                        
                                    }
                                ?>
                            </ul>                     
                        </div>
                    </div>
                </div>   
            </div>

            <div class="col-sm-6  px-lg-1">
                <div class="card my-4">
                    <h4 class="card-header selected">
                        <i class='fas fa-sitemap'></i> 
                        Latest 
                        <?php echo $limitItems?> 
                        Registred Items
                        <span class="plus">
                            <i class="plus fas fa-plus"></i>
                        </span>
                    </h4>
                    <div class="card-body">
                        <div class="card-text">
                            <ul class="list-group">
                                <?php
                                    // BRING LATEST USERS 
                                    foreach($latestItems as $item){
                                        echo '<li class="list-group-item py-2 px-2 d-flex col justify-content-between">';
                                            echo '<p class="m-0 p-0 font-weight-bold text-capitalize">' .$item['Name']. '</p>';
                                            echo '<div class="p-0 d-flex justify-content-between">';
                                                echo '<a href="items.php?do=edit&itemid='.$item['Item_ID'].'" class="btn btn-success mx-1 py-1 px-2"><i class="fas fa-edit"></i>Edit</a>';
                                                // DISPLAY ACTIVATE BUTTON CONDTION
                                                echo !$item['Approved'] ? '<a href="items.php?do=approve&itemid='.$item['Item_ID'].'" class="btn btn-info mx-1 py-1 px-2"><i class="fas fa-check">Approve</i></a>' : '';
                                            echo '</div>';
                                        echo '</li>';
                                        
                                    }
                                ?>
                            </ul>                     
                        </div>
                    </div>
                </div>        
            </div>
        </div>
    </div>
    <!-- END DASHBOARD BODY -->

    <?php

    //Include Footer
    include $template . 'footer.php';

?>