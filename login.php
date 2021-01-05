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

    require('form_validation.php');

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        // THE VALIDATION CLASS INSTANCE
        $validation = new Validation($_POST);

        
        if(isset($_POST['login'])){ // You Could Samply Write isset($_POST['login'])

            /* $user = $_POST['user'];
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
            } */

            // GET THE FORM INPUTS
            $username = $_POST['user'];
            $password = $_POST['password'];

            $validation->validateString($username, 'User');
            $validation->validatePassword($password, 'Password');
            

        }else{

            // GET THE FORM INPUTS
            $email = $_POST['email'];
            $password = $_POST['password'];
            $validPassword = $_POST['valid-password'];

            $validation->validateEmail($email, 'Email');
            $validation->validatePassword($password, 'Password');
            $validation->matchPassword($password, $validPassword);
            
        }
           
    }

    
?>

    <div class="container">
        

        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" class="login <?php echo $_SERVER['REQUEST_METHOD'] == 'POST' ? isset($_POST['login']) ? '' : 'hide' : ''?>" method='post'>

            <h1>Log In</h1>
            <input type="text" name="user" autocomplate="off" placeholder="Username" />
            <input type="password" name="password" autocomplate="new-password" placeholder="Password" />
            <p>create new acount?<span data-class='login'>sign up</span></p>
            <input type="submit" value="log in" name="login"/>

        </form>

        <form action="" class="signup <?php echo $_SERVER['REQUEST_METHOD'] == 'POST' ? isset($_POST['sigiup']) ? '' : 'hide' : 'hide' ?>" method="POST">

            <h1>Sign Up</h1>
            <input type="email" name="email" autocomplate="on" placeholder="Email"  />
            <input type="password" name="password" autocomplate="new-password" placeholder="password" />
            <input type="password" name="valid-password" autocomplate="newèpassword" placeholder="retype password" />
            <p>already a member?<span data-class='signup'>log in</span></p>
            <input type="submit" value="Sign Up" name="signup"/>

        </form>
    </div>

    <?php 
        
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $errors = $validation->errors;

            // SHOW ERRORS IF EXISTS
            if($errors){
                echo "<div class='container'>";
                foreach($errors as $error){
                    echo "<div class='alert alert-danger text-center'>".$error."</div>";
                }
                echo "<div>";
            }
            }
        
            
    ?>


<?php include $template . "footer.php"?>