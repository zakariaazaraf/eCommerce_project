<?php

    //START THE SESSION, ALWAYS REMEMBER TO START IT
    session_start();

    $titlePage = "Dashborad";

    //INCLUDES
    include 'init.php';

    // CHECK IF THE USER HAVE THE ACCESS TO THE DASHBOARD
    if(isset($_SESSION['username'])){

        echo "<div class='container'><h1 class='text-center'>Welcome " . $_SESSION['username'] . " To Dashboard !!!</h1></div>";
        
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
                    <h4 class="card-header"><i class='fas fa-users'></i> Latest Registred Users</h4>
                    <div class="card-body">
                        <p class="card-text">Some Text here !!</p>
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