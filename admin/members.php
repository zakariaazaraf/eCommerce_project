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

        require('validate_image.php');

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

            /*
            ==================================================================================
            ====================== BRING THE USERS FROM THE DATABASE =========================*/

            // ADD ANOTHER OPTION : IF THE ADMIN WANT THE UNACTIVATE MEMBERS
            $panding = isset($_GET['page']) && $_GET['page'] == 'panding' ? 'AND RegStatus = 0' : '';

            
            $stmt = $db->prepare("SELECT * FROM users WHERE GroupID != 1 $panding");
            $stmt->execute();
            $rows = $stmt->fetchAll();

            /*================================================================================*/
            ?>

            <h1 class="text-center">manage member</h1>
            <div class="container">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered text-center">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>User Name</th>
                                <th>Email</th>
                                <th>Full Name</th>
                                <th>Registred Date</th>
                                <th>Control</th>
                            </tr>
                        </thead>
                        <tbod>

                            <!-- START A PHP CODE WHISH BRIGN USERS FROM DB -->
                            <?php
                                foreach($rows as $row){

                                    echo "<tr>";
                                        echo "<th>" . $row['UserId'] . "</th>";
                                        echo "<th> <img src='./layout/images/upload/" . $row['Image'] ."' alt='".$row['UserName']."'/></th>";
                                        echo "<td>" . $row['UserName'] . "</td>";
                                        echo "<td>" . $row['Email'] . "</td>";
                                        echo "<td>" . $row['FullName'] . "</td>";
                                        echo "<td>" . $row['Date'] . "</td>";
                                        echo "<td>";
                                            echo "<a href='?do=edit&userid=" . $row['UserId'] . "' class='btn btn-success' role='button'><i class='fas fa-edit'></i>Edit</a>";
                                            echo "<a href='?do=delete&userid=" . $row['UserId'] . "' class='btn btn-danger confirm' role='button'><i class='fas fa-trash'></i>Delete</a>";
                                            echo !$row['RegStatus'] ? "<a href='?do=activate&userid=" . $row['UserId'] . "' class='btn btn-info' role='button'><i class='fas fa-pen-fancy'></i>Activate</a>" : '';
                                        echo "</td>";
                                    echo "</tr>";

                                }
                            ?>
                            <!-- END A PHP CODE WHISH BRIGN USERS FROM DB -->
                            
                        </tbody>
                    </table>
                </div>
                <a href='members.php?do=add' class="btn btn-primary"><i class="fas fa-plus"></i>New Member</a>
            </div>
            
            <?php
            /*
            ================================================================================
            == ADD MEMBER
            ================================================================================
            */
        }elseif($do == 'add'){

            
            ?> 

                    <div class="container members">
                    <h1 class="text-center">add member</h1>
                        <form action="?do=insert" method='POST' enctype="multipart/form-data">
                            <div class="form-group row justify-content-center">
                                <label class="col col-sm-4 col-md-3 col-lg-2" for="username">Username:</label>
                                <input class="col col-sm-7 col-md-6 col-lg-5" type="text" name="username" id="username"  required autocomplete="off" placeholder="Member Username"/>
                            </div>
                            <div class="form-group row justify-content-center">
                                <label class="col col-sm-4 col-md-3 col-lg-2" for="password">Password:</label>    
                                <input class="col col-sm-7 col-md-6 col-lg-5 password" type="password" name="password" id="password" required autocomplete="new-password" placeholder="Enter Strong Password"/>
                                <i class="show-pass fas fa-eye fa-x"></i>
                                
                            </div>
                            <div class="form-group row justify-content-center">
                                <label class="col col-sm-4 col-md-3 col-lg-2" for="email">Email:</label>
                                <input class="col col-sm-7 col-md-6 col-lg-5" type="email" name="email" id="email" required placeholder="Enter Valid Email"/>
                            </div>
                            <div class="form-group row justify-content-center">
                                <label class="col col-sm-4 col-md-3 col-lg-2" for="fullname">Full Name:</label>
                                <input class="col col-sm-7 col-md-6 col-lg-5" type="text" name="fullname" id="fullname" required placeholder="Member Fullname"/>
                            </div>

                            <div class="form-group row justify-content-center">
                                <label class="col col-sm-4 col-md-3 col-lg-2" for="image">Image :</label>
                                <input class="col col-sm-7 col-md-6 col-lg-5" type="file" name="image" id="image" required/>
                            </div>

                            <div class="form-group row justify-content-center">
                                <div class="col-12 col-sm-11 col-md-9 col-lg-7">    
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i>add member</button>
                                </div>
                            </div>

                            <!-- <input type="submit" value="add member" class="btn btn-primary"> -->
                        </form>
                    </div>    

            <?php

            /*
            ================================================================================
            == INSERT MEMBER
            ================================================================================
            */
        }elseif($do == 'insert'){

            echo '<div class="container"><h1 class="text-center">Insert member</h1>';

            // CHECK IF THE USER CAME BY A POST REQUEST
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                
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
                $validateImage = new Image(); // CALL THE IMAGE VALIDATION CLASS

                $validateImage->validateImage($_FILES['image'], 'user image');
                $validation->validateForm();

                $errors = $validation->errors;
                $imageError = $validateImage->errors;
                isset($imageError) ? array_push($errors, $imageError) : '';

                


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

                    echo "<div class='alert alert-danger'>" . $imageError ?? '' . "</div>";

                    
                }else{

                    // CHECK IF THE USER EXISTS IN DATABASE
                    if(!checkItem('UserName', 'users', $username)){

                        // INSERT A NEW MEMBER IN DATABASE WITH PREPARE STETMENT METHOS
                        /* $stmt = $db->prepare("INSERT INTO users(UserName, Password, Email, FullName, Image) 
                                                VALUES (:zuser, :zpass, :zemail, :zfullname, zimage)"); */

                        // PASS THE PARAMS AND EXECUTE THE QUERY
                        /* $stmt->execute(
                            array(
                                'zuser' => $username,
                                'zpass' => $hashpassword, 
                                'zemail' => $email, 
                                'zfullname' => $fullname,
                                'zimage' => $image
                            )
                        );  */


                        // GENERATE A NAME FOR THE IMAGE
                        $image = rand(1, 100000) . "_" . $_FILES['image']['name'];

                        // MOVE IMAGES TO UPLOAD FILE IN THE PROJECT
                        move_uploaded_file($_FILES['image']['tmp_name'], "./layout/images/upload/" . $image);


                        // INSERT A NEW MEMBER WITH THE BINDING METHOD I DATABASE
                        $stmt = $db->prepare("INSERT INTO users (UserName, Password, Email, FullName, RegStatus, Date, Image) VALUES (?, ?, ?, ?, 1, now(), ?)");     
                        
                        $stmt->execute(array($username, $hashpassword, $email, $fullname, $image));
                        
                        $row = $stmt->rowCount();

                        $msg = "<div class='alert alert-success'>" . $row . " Member Inserted !!</div>";
                        redirectHome($msg, 'members.php');

                        

                        

                    }else{

                        $msg = '<div class="alert alert-danger">This Name Allready Exists</div></div>';
                        redirectHome($msg, 'back');

                    }       

                }

            }else{
                
                $msg = '<div class="alert alert-danger">You Cant\'t Access This Page Directly</div>';
                redirectHome($msg);        
            }

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

                    <div class="container members">
                    <h1 class="text-center">edit member</h1>
                        <form action="?do=update" method='POST'>
                            <!-- HIDDEN INPUT FIELD TO SEND userid -->
                            <input type="hidden" name="userid" value="<?php echo $userid?>">
                            <div class="form-group row justify-content-center">
                                <label class="col col-sm-4 col-md-3 col-lg-2" for="username">Username:</label>
                                <input class="col col-sm-7 col-md-6 col-lg-5" type="text" name="username" id="username"  required value="<?php echo $data["UserName"]?>" autocomplete="off">
                            </div>
                            <div class="form-group row justify-content-center">
                                <label class="col col-sm-4 col-md-3 col-lg-2" for="password">Password:</label>
                                <!-- HIDDEN OLD PASS INPUT -->
                                <input type="hidden" name="oldPassword" value="<?php echo $data["Password"]?>">
                                <input class="col col-sm-7 col-md-6 col-lg-5" type="password" name="password" id="password" value="" autocomplete="new-password">
                            </div>
                            <div class="form-group row justify-content-center">
                                <label class="col col-sm-4 col-md-3 col-lg-2" for="email">Email:</label>
                                <input class="col col-sm-7 col-md-6 col-lg-5" type="email" name="email" id="email" required value="<?php echo $data["Email"]?>">
                            </div>
                            <div class="form-group row justify-content-center">
                                <label class="col col-sm-4 col-md-3 col-lg-2" for="fullname">Full Name:</label>
                                <input class="col col-sm-7 col-md-6 col-lg-5" type="text" name="fullname" id="fullname" required value="<?php echo $data["FullName"]?>"/>
                            </div>

                            <div class="form-group row justify-content-center">
                                <label class="col col-sm-4 col-md-3 col-lg-2" for="image">Image:</label>
                                <input class="col col-sm-5 col-md-2 col-lg-3" type="file" name="image" id="image" required value="<?php echo $data["FullName"]?>"/>
                                <img class="col col-sm-2 col-md-2 col-lg-2" src="./layout/images/upload/<?php echo $data['Image']?>" alt="<?php echo $data['UserName']?>"/>
                            </div>

                            <div class="form-group row justify-content-center">
                                <div class="col-12 col-sm-11 col-md-9 col-lg-7">    
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i>Edit Item</button>
                                </div>
                            </div>
                            <!-- <input type="submit" value="save" class="btn btn-primary"> -->
                        </form>
                    </div>    

                <?php 
            
            }else{ // IF SOMEONE PLAY WITH ID IN THE LINK

                $msg = "<div class='alert alert-danger'>there's no such ID<div>";
                redirectHome($msg);
            
            }
      
            /*
            ================================================================================
            == UPDATE MEMBER
            ================================================================================
            */
        }elseif($do == 'update'){

            echo '<div class="container"><h1 class="text-center">update member</h1>';
            
            // CHECK IF THE USER CAME BY A POST REQUEST
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                
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

                    echo "<div class='alert alert-danger'>";

                    echo  $errors['username'] ?? '' . "<br />";
                    echo  $errors['password'] ?? '' . "<br />";
                    echo  $errors['email'] ?? '' . "<br />";
                    echo  $errors['fullname'] ?? '' . "<br />";

                    echo "</div>";

                    $msg = "<div class='alert alert-danger'>Reinter Your Infos</div>";
                    redirectHome($msg, 'back');
                    
                }else{

                    // UPDATE THE IFORMATION BY SENDING A QUERY TO DATABASE
                    $stmt = $db->prepare("UPDATE users SET UserName = ?, Email = ?, FullName = ?, Password = ? WHERE userId = ?");
                    // PASS THE PARAMS AND EXECUTE THE QUERY
                    $stmt->execute(array($username, $email, $fullname, $pass, $id)); 

                    $row = $stmt->rowCount();

                    $msg = "<div class='alert alert-success'>" .$row . " of records updated !!</div>" ;
                    redirectHome($msg, 'members.php');
                }


            }else{
                
                $msg = "<div class='alert alert-danger'>You Cant't Access This Page Directly</div>";
                redirectHome($msg);
            }

            /*
            ================================================================================
            == DELETE MEMBER
            ================================================================================
            */

        }elseif($do == 'delete'){

            echo "<div class='container'><h1 class='text-center'>Delete Member Page</h1>";

            $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid'])  : 0;

            /* // GET THE INFORMATION OF THIS USER BY HIS ID
            $stmt = $db->prepare("SELECT * FROM users WHERE userId = ? LIMIT 1"); // QUERY
            $stmt->execute(array($userid)); // PASS THE PARAMETER AND EXECUTE THE QUEY
            $rowCount = $stmt->rowCount(); // GET THE NUMBER OF ROWS */

            // CHECK IF A CHANGE HAS MADE IN THE DATABASE
            if(checkItem('UserId', 'users', $userid) > 0){     

                // DELETE MEMBER PROCESS
                $stmt = $db->prepare("DELETE FROM users WHERE UserId = :userID");

                $stmt->bindParam('userID', $userid);

                $stmt->execute();

                $msg = "<div class='alert alert-success'>" . $stmt->rowCount() . " Member Deleted</div>";
                redirectHome($msg, 'members.php');

            }else{
                $msg = "<div class='alert alert-danger'>ID DOESN'T EXISTS !!</div>";
                redirectHome($msg);
            }


        }elseif($do == 'activate'){
            
            echo "<div class='container'><h1 class='text-center'>Activate Member Page</h1>";

            $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid'])  : 0;

            // CHECK IF A CHANGE HAS MADE IN THE DATABASE
            if(checkItem('UserId', 'users', $userid) > 0){     

                // DELETE MEMBER PROCESS
                $stmt = $db->prepare("UPDATE users SET RegStatus = 1 WHERE UserId = ?"); // :userID
                //$stmt->bindParam('userID', $userid);

                $stmt->execute(array($userid));

                $msg = "<div class='alert alert-success'>" . $stmt->rowCount() . " Member Activated</div>";
                redirectHome($msg, 'members.php');

            }else{
                $msg = "<div class='alert alert-danger'>ID DOESN'T EXISTS !!</div>";
                redirectHome($msg);
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

