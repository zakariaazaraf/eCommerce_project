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
        $limit = 5;
        $latestUsers = getLatest('*', 'users', 'UserId', $limit);
        
    }else{

        header('location: index.php');
        exit();
    }

    ?>

    <!-- START DASHBOARD BODY -->

    <div class="container home-static text-center text-capitalize">
        <div class="row">
            <div class="col-md-3"><div class='static st-members'>total members<a href="members.php"><span class='d-block'><?php echo countColumns('UserId', 'users')?></span></a></div></div>
            <div class="col-md-3"><div class='static st-panding'>panding memebers<a href='members.php?do=Manage&page=panding'><span class='d-block'><?php echo checkItem('RegStatus', 'users', 0)?></span></a></div></div>
            <div class="col-md-3"><div class='static st-items'>total items<span class='d-block'>1500</span></div></div>
            <div class="col-md-3"><div class='static st-comments'>total comments<span class='d-block'>3300</span></div></div>
        </div>
    </div>

    <div class="container latest">
        <div class="row">
            <div class="col-sm-6">

                <div class="card my-4">
                    <h4 class="card-header"><i class='fas fa-users'></i> Latest <?php echo $limit ?> Registred Users</h4>
                    <div class="card-body">
                        <div class="card-text">
                            <ul class="list-group">
                                <?php
                                    // BRING LATEST USERS 
                                    foreach($latestUsers as $last){
                                        echo '<li class="list-group-item py-2 px-2 d-flex col justify-content-between">';
                                            echo '<p class="m-0 p-0 font-weight-bold text-capitalize">' .$last['UserName']. '</p>';
                                            echo '<div class="p-0 d-flex justify-content-between">';
                                                echo '<a href="members.php?do=edit&userid='.$last['UserId'].'" class="btn btn-success mx-1 py-1 px-2"><i class="fas fa-edit"></i>Edit</a>';
                                                // DISPLAY ACTIVATE BUTTON CONDTION
                                                echo !$last['RegStatus'] ? '<a href="members.php?do=activate&userid='.$last['UserId'].'" class="btn btn-info mx-1 py-1 px-2"><i class="fas fa-pen-fancy">Activate</i></a>' : '';
                                            echo '</div>';
                                        echo '</li>';
                                        
                                    }
                                ?>
                            </ul>                     
                        </div>
                    </div>
                </div>
                
            </div>

            <div class="col-sm-6">
                <div class="card my-4">
                    <h4 class="card-header"><i class='fas fa-sitemap'></i> Latest Items</h4>
                    <div class="card-body">
                        <p class="card-text">Some Text Here !!</p>
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