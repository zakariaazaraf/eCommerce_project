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
        

        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" class="log-form login <?php echo $_SERVER['REQUEST_METHOD'] == 'POST' ? isset($_POST['login']) ? '' : 'hide' : ''?>" method='post'>

            <h1>Log In</h1>
            <input type="text" name="user" autocomplate="off" placeholder="Username" required/>
            <input type="password" name="password" autocomplate="new-password" placeholder="Password" required/>
            <p>create new acount?<span data-class='login'>sign up</span></p>
            <input type="submit" value="log in" name="login"/>

        </form>

        <form action="" 
              class="log-form signup <?php echo $_SERVER['REQUEST_METHOD'] == 'POST' ? isset($_POST['signup']) ? '' : 'hide' : 'hide' ?>" 
              method="POST">

            <h1>Sign Up</h1>
            <input type="text" name="username" autocomplate="of" placeholder="User Name"  required/>
            <input type="text" name="fullname" autocomplate="of" placeholder="Full Name"  required/>
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
                    $username = $_POST['username'];
                    $fullname = $_POST['fullname'];
                    $email = $_POST['email'];
                    $password = $_POST['password'];
                    $validPassword = $_POST['valid-password'];

                    $validation->validateName($username, 'User Name');
                    $validation->validateString($fullname, 'Full name');
                    $validation->validateEmail($email, 'Email');
                    $validation->validatePassword($password, 'Password');
                    $validation->matchPassword($password, $validPassword);

                    $errors = $validation->errors;

                    // SHOW ERRORS IF EXISTS
                    if($errors){
                        echo "<div class='container errors'>";
                        foreach($errors as $error){
                            echo "<div class='alert alert-danger text-center'>".$error."</div>";
                        }
                        echo "<div>";
                    }else{

                        if(!checkItem('UserName', 'users', $username)){

                            // CREATE A NEW USER AND REIRECT IT TO HOME PAGE
                            $stat = $db->prepare("INSERT INTO 
                                                                users 
                                                            (UserId, UserName, Password, Email, FullName, GroupID, TrustStatus, RegStatus, Date)
                                                                VALUES
                                                            (null, ?, ?, ?, ?, '0', '0', '0', now())");

                            $stat->execute(array($username, sha1($password), $email, $fullname));

                            if($stat->rowCount()){

                                // CREATE SESSION FOR THIS USER
                                $_SESSION['user'] = $username;

                                // REDIRECT HIM TO HOME PAGE
                                header('Location: index.php');
                                exit();

                            }else{

                                echo "<div class='alert alert-danger'>We Encounter Some Isseus Creating A New User !</div>";

                            }

                        }else{

                            echo "<div class='alert alert-danger'>This User Already Exists Try Another One !</div>";

                        }

                        

                    }
                    
                }

            }
        
            
    ?>


<?php include $template . "footer.php"?>