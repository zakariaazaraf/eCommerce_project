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

    
?>

    <div class="container">
        

        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" class="login <?php echo $_SERVER['REQUEST_METHOD'] == 'POST' ? isset($_POST['login']) ? '' : 'hide' : ''?>" method='post'>

            <h1>Log In</h1>
            <input type="text" name="user" autocomplate="off" placeholder="Username" required/>
            <input type="password" name="password" autocomplate="new-password" placeholder="Password" required/>
            <p>create new acount?<span data-class='login'>sign up</span></p>
            <input type="submit" value="log in" name="login"/>

        </form>

        <form action="" 
              class="signup <?php echo $_SERVER['REQUEST_METHOD'] == 'POST' ? isset($_POST['signup']) ? '' : 'hide' : 'hide' ?>" 
              method="POST">

            <h1>Sign Up</h1>
            <input type="email" name="email" autocomplate="on" placeholder="Email"  required/>
            <input type="password" name="password" autocomplate="new-password" placeholder="password" required/>
            <input type="password" name="valid-password" autocomplate="newèpassword" placeholder="retype password" required/>
            <p>already a member?<span data-class='signup'>log in</span></p>
            <input type="submit" value="Sign Up" name="signup"/>

        </form>
    </div>

    <?php 
        
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                // THE VALIDATION CLASS INSTANCE
                $validation = new Validation($_POST);

                
                if(isset($_POST['login'])){ 

                    // GET THE FORM INPUTS
                    $username = $_POST['user'];
                    $password = $_POST['password'];

                    // VALIDATE THE FIELDS
                    $validation->validateString($username, 'User');
                    $validation->validatePassword($password, 'Password');

                    $errors = $validation->errors;

                    // SHOW ERRORS IF EXISTS
                    if($errors){

                        echo "<div class='container'>";
                        foreach($errors as $error){
                            echo "<div class='alert alert-danger text-center'>".$error."</div>";
                        }
                        echo "<div>";

                    }else{
 
                        $user = $username;
                        $userPassword = sha1($password); // HASHING THE PASSWORD

                        $statement = $db->prepare("SELECT UserId, UserName, Password 
                                                        FROM 
                                                            users 
                                                        WHERE 
                                                            UserName = ? AND Password = ? LIMIT 1");

                        $statement->execute(array($user, $userPassword));
                        $data = $statement->fetch();

                        // CHECK THE EXISTENS OF THIS USER IN DATABASE
                        if($data){

                            // CREATE A SESSION FOR THIS USER
                            $_SESSION['user'] = $user; // FOR A USER YOU SOULD GET HIS DATA OR EDIT IT BY THE SESSION
                            header('Location: index.php');
                            exit();

                        }else{
                            echo 'There\'s no Data matched those values';
                        } 
                    }

                }else{

                    // GET THE FORM INPUTS
                    $email = $_POST['email'];
                    $password = $_POST['password'];
                    $validPassword = $_POST['valid-password'];

                    $validation->validateEmail($email, 'Email');
                    $validation->validatePassword($password, 'Password');
                    $validation->matchPassword($password, $validPassword);

                    $errors = $validation->errors;

                    // SHOW ERRORS IF EXISTS
                    if($errors){
                        echo "<div class='container'>";
                        foreach($errors as $error){
                            echo "<div class='alert alert-danger text-center'>".$error."</div>";
                        }
                        echo "<div>";
                    }else{

                        // CREATE A NEW USER AND REIRECT IT TO HOME PAGE

                    }
                    
                }

            }
        
            
    ?>


<?php include $template . "footer.php"?>