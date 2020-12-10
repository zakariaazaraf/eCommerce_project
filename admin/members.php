<?php

    /*
        ===================================================
        == Manage Memebers Page
        == Edit | Delete | Add Memebers
        ===================================================
    */

    // VERIFT THE SESSION
    //START THE SESSION, ALWAYS REMEMBER TO START IT
    session_start();

    $titlePage = 'Members';


    // CHECK IF THE USER HAVE THE ACCESS TO THIS PAGE
    if(isset($_SESSION['username'])){

        //INCLUDES
        include 'init.php';

        // Validation Class
        require('form_validation.php');

        // CHECK THE GET ACTION
        if(isset($_GET['do'])){
            $do = $_GET['do'];
        }else{
            $do = 'Manage';
        }

        /*
        ================================================================================
        == Manage SECTION
        ================================================================================
        */
        if($do == 'Manage'){

            echo 'Manage page<br>';
            echo "<a href='members.php?do=add'>Add New Member</a>";

            /*
            ================================================================================
            == ADD MEMBER
            ================================================================================
            */
        }elseif($do == 'add'){


            
            ?> 

                    <div class="form-container">
                    <h1>add member</h1>
                        <form action="?do=insert" method='POST'>
                            <div class="group">
                                <label for="username">Username:</label>
                                <input type="text" name="username" id="username"  required autocomplete="off" placeholder="Member Username"/>
                            </div>
                            <div class="group">
                                <label for="password">Password:</label>
                                <input class="password" type="password" name="password" id="password" required autocomplete="new-password" placeholder="Enter Strong Password"/>
                                <i class="show-pass fas fa-eye fa-x"></i>
                            </div>
                            <div class="group">
                                <label for="email">Email:</label>
                                <input type="email" name="email" id="email" required placeholder="Enter Valid Email"/>
                            </div>
                            <div class="group">
                                <label for="fullname">Full Name:</label>
                                <input type="text" name="fullname" id="fullname" required placeholder="Member Fullname"/>
                            </div>

                            <input type="submit" value="add member" class="btn btn-primary">
                        </form>
                    </div>    

            <?php

            /*
            ================================================================================
            == INSERT MEMBER
            ================================================================================
            */
        }elseif($do == 'insert'){

            // CHECK IF THE USER CAME BY A POST REQUEST
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                
                echo '<h1>Insert member</h1>';

                // GET THE DATA FROM THE POST REQUEST
                $username = $_POST['username'];
                $email = $_POST['email'];
                $fullname = $_POST['fullname'];
                $pass = $_POST['password'];


                // HASH THE PASSWORD
                $hashpassword = sha1($_POST['password']);

                /*==========================================================
                =================== Form Validation =======================*/

                $validation = new UserValidator($_POST);
                $validation->validateForm();
                $errors = $validation->errors;

                /*==========================================================*/

                if(count($errors) > 0){

                    // THROW THE ERRORS
                    echo "<h3>Errors Encountered !!</h3>";

                    $errors['username'] = isset($errors['username']) ? $errors['username'] : '';
                    $errors['password'] = isset($errors['password']) ? $errors['password'] : '';
                    $errors['email'] = isset($errors['email']) ? $errors['email'] : '';
                    $errors['fullname'] = isset($errors['fullname']) ? $errors['fullname'] : '';

                    echo "<div >" . $errors['username'] ?? '' . "</div>";
                    echo "<div >" . $errors['password'] ?? '' . "</div>";
                    echo "<div >" . $errors['email'] ?? '' . "</div>";
                    echo "<div >" . $errors['fullname'] ?? '' . "</div>";
                    
                }else{

                    // INSERT A NEW MEMBER IN DATABASE WITH PREPARE STETMENT METHOS
                    /* $stmt = $db->prepare("INSERT INTO users(UserName, Password, Email, FullName) 
                                            VALUES (:zuser, :zpass, :zemail, :zfullname)"); */

                    // PASS THE PARAMS AND EXECUTE THE QUERY
                    /* $stmt->execute(
                        array(
                            'zuser' => $username,
                            'zpass' => $hashpassword, 
                            'zemail' => $email, 
                            'zfullname' => $fullname
                        )
                    );  */

                    
                    // INSERT A NEW MEMBER WITH THE BINDING METHOD I DATABASE
                    $stmt = $db->prepare("INSERT INTO users (UserName, Password, Email, FullName) VALUES (?, ?, ?, ?)");     
                    
                    $stmt->execute(array($username, $hashpassword, $email, $fullname));
                    

                    $row = $stmt->rowCount();

                    echo $row . " Member Inserted !!" ;
                }


            }else{
                echo "You Cant't Access This Page Directly ";
            }

            echo "<pre>";
            print_r($_POST);
            echo "</pre>";

            /*
            ================================================================================
            == EDIT MEMBER
            ================================================================================
            */
        }elseif ($do == 'edit'){ 

        
            $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid'])  : 0;

            // GET THE INFORMATION OF THIS USER BY HIS ID
            $stmt = $db->prepare("SELECT * FROM users WHERE userId = ? LIMIT 1"); // QUERY
            $stmt->execute(array($userid)); // PASS THE PARAMETER AND EXECUTE THE QUEY
            $data = $stmt->fetch(); // FETCH THE DATA 
            $rowCount = $stmt->rowCount(); // GET THE NUMBER OF ROWS

            // CHECK IF A CHANGE HAS MADE IN THE DATABASE
            if($rowCount > 0){

                ?> 

                    <div class="form-container">
                    <h1>edit member</h1>
                        <form action="?do=update" method='POST'>
                            <!-- HIDDEN INPUT FIELD TO SEND userid -->
                            <input type="hidden" name="userid" value="<?php echo $userid?>">
                            <div class="group">
                                <label for="username">Username:</label>
                                <input type="text" name="username" id="username"  required value="<?php echo $data["UserName"]?>" autocomplete="off">
                            </div>
                            <div class="group">
                                <label for="password">Password:</label>
                                <!-- HIDDEN OLD PASS INPUT -->
                                <input type="hidden" name="oldPassword" value="<?php echo $data["Password"]?>">
                                <input type="password" name="password" id="password" value="" autocomplete="new-password">
                            </div>
                            <div class="group">
                                <label for="email">Email:</label>
                                <input type="email" name="email" id="email" required value="<?php echo $data["Email"]?>">
                            </div>
                            <div class="group">
                                <label for="fullname">Full Name:</label>
                                <input type="text" name="fullname" id="fullname" required value="<?php echo $data["FullName"]?>"/>
                            </div>

                            <input type="submit" value="save" class="btn btn-primary">
                        </form>
                    </div>    

                <?php 
            
            } 

            // IF SOMEONE PLAY WITH ID IN THE LINK
            else{
            echo "there's no such ID";
            }
      
            /*
            ================================================================================
            == UPDATE MEMBER
            ================================================================================
            */
        }elseif($do == 'update'){
            
            // CHECK IF THE USER CAME BY A POST REQUEST
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                
                echo '<h1>update member</h1>';

                // GET THE DATA FROM THE POST REQUEST
                $id = $_POST['userid'];
                $username = $_POST['username'];
                $email = $_POST['email'];
                $fullname = $_POST['fullname'];

                // PASSWORD TRICK
                $pass = "";

                // USE TERNARY OPERATOR
                $pass = empty($_POST['password']) ? $_POST['oldPassword'] : sha1($_POST['password']) ;

                /*==========================================================
                =================== Form Validation =======================*/

                $validation = new UserValidator($_POST);
                $validation->validateForm();
                $errors = $validation->errors;

                /*==========================================================*/

                if(count($errors) > 0){

                    // THROW THE ERRORS
                    echo "<h3>Errors Encountered !!</h3>";

                    $errors['username'] = isset($errors['username']) ? $errors['username'] : '';
                    $errors['password'] = isset($errors['password']) ? $errors['password'] : '';
                    $errors['email'] = isset($errors['email']) ? $errors['email'] : '';
                    $errors['fullname'] = isset($errors['fullname']) ? $errors['fullname'] : '';

                    echo "<div >" . $errors['username'] ?? '' . "</div>";
                    echo "<div >" . $errors['password'] ?? '' . "</div>";
                    echo "<div >" . $errors['email'] ?? '' . "</div>";
                    echo "<div >" . $errors['fullname'] ?? '' . "</div>";
                    
                }else{

                    // UPDATE THE IFORMATION BY SENDING A QUERY TO DATABASE
                    $stmt = $db->prepare("UPDATE users SET UserName = ?, Email = ?, FullName = ?, Password = ? WHERE userId = ?");
                    // PASS THE PARAMS AND EXECUTE THE QUERY
                    $stmt->execute(array($username, $email, $fullname, $pass, $id)); 

                    $row = $stmt->rowCount();

                    echo $row . " of records updated !!" ;
                }


            }else{
                echo "You Cant't Access This Page Directly ";
            }

        }else{
            echo 'default';
        }
        //Include Footer
        include $template . 'footer.php';

    }else{

        header('location: index.php');
        exit();
    }

    