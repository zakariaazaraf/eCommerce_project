<?php 

    // STARTING THE SESSION
    session_start();

    // CHECK THE SESSIONS OF THE USER
    if(isset($_SESSION['user'])){
        header('Location: index.php');
        exit();
    }

    $titlePage = "Login";


    include "init.php";

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        
        
        if(in_array('Log In', $_POST)){ // You Could Samply Write isset($_POST['login'])

            $user = $_POST['user'];
            $userPassword = sha1($_POST['password']); // HASHING THE PASSWORD

            $statement = $db->prepare("SELECT UserId, UserName, Password 
                                            FROM 
                                                users 
                                            WHERE 
                                                UserName = ? AND Password = ? LIMIT 1");

            $statement->execute(array($user, $userPassword));
            $data = $statement->fetch();

            if($data){

                // CREATE A SESSION FOR THIS USER
                $_SESSION['user'] = $user; // FOR A USER YOU SOULD GET HIS DATA OR EDIT IT BY THE SESSION
                header('Location: index.php');
                exit();

            }else{
                echo 'There\'s no Data matched those values';
            }

        }elseif(in_array('Sign Up', $_POST)){

            echo 'Came Form The Signup Form';

        }else{

            echo 'We Dont Knew Where You Came From';

        }
        

        
    }

    
?>

    <div class="container">
        

        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" class="login" method='post'>

            <h1>Log In</h1>
            <input type="text" name="user" autocomplate="off" placeholder="Username" required/>
            <input type="password" name="password" autocomplate="new-password" placeholder="Password" required/>
            <p>create new acount?<span data-class='login'>sign up</span></p>
            <input type="submit" value="log in" name="login"/>

        </form>

        <form action="" class="signup hide" method="POST">

            <h1>Sign Up</h1>
            <input type="email" name="email" autocomplate="on" placeholder="Email" required />
            <input type="password" name="password" autocomplate="new-password" placeholder="password" required/>
            <input type="password" name="valid-password" autocomplate="newèpassword" placeholder="retype password" required/>
            <p>already a member?<span data-class='signup'>log in</span></p>
            <input type="submit" value="Sign Up" name="signup"/>

        </form>
    </div>


<?php include $template . "footer.php"?>