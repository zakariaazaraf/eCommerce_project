<?php

    // STARTING A SESSION
    session_start();

    // To check the possibility of including the navbar
    $navbar = "";
    $titlePage = "Home";
        
    
    //CHECK IF THE SESSION REGESTRED
        if(isset($_SESSION['username'])){

            // REDIRECT IF THIS USER WAS REGISTRED IN SESSION
            header('loaction: dashboard.php');

        }

    // Include Init.php File
    include "init.php";
        

    //CHECK THE REQUEST METHOD

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $username = $_POST['username'];
        $password = $_POST['password'];

        $hashedPawwsord = sha1($password); // HASHING THE PASSWORD

        // CHECK IF THE USER AN ADMIN

        // THIS IS FOR SECURITY RESION
        $stmt = $db->prepare('SELECT 
                                        userID, UserName, Password, GroupID 
                                FROM users 
                                where UserName = ? AND Password = ? AND GroupID = 1 LIMIT 1');

        // EXECUTE THE STATEMENT
        $stmt->execute(array($username, $hashedPawwsord));

        // GET THE DATA 
        $data = $stmt->fetch();

        // RETURNED ROW FROM THE DB, THIS FUNCTION IS A PDO'S ONE
        $NumberRows = $stmt->rowCount();

        if($NumberRows > 0){

            //echo "<h2>Welcome " . $username . " You're Admin !!!</h2>";

            //DEFINE A SESSION
            $_SESSION['username'] = $username;
            $_SESSION['userID'] = $data['userID'];

            //REDIRECT TO DASHBOARD PAGE
            header('location: dashboard.php');
            exit();

        }

        

    }


?>

<form class="login" action="<?php $_SERVER['PHP_SELF'] ?>" method='POST'>

    <h3 class="text-center">Login To Forum</h3>

    <input class="form-control" type="text" name="username" placeholder="Username" autocomplate="off" />

    <input class="form-control" type="password" name="password" placeholder="Password" autocomplate="new-password"/> 

    <input class="btn btn-primary btn-block"type="submit" value="Login"/>

</form>



<?php

    
    // Include The Footer From Template Include
    include $template . "footer.php";

?>