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

    $titlePage = 'Items';

    // CHECK IF THE USER HAVE THE ACCESS TO THIS PAGE
    if(isset($_SESSION['username'])){

        //INCLUDES
        include 'init.php';

        // Validation Classes
        require('form_validation.php');
        require('fields_validation.php');

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
            


            /*================================================================================*/
            
            echo "<h1 class='alert alert-success'>Welcome To Items Page</h1>";
            /*
            ================================================================================
            == ADD MEMBER
            ================================================================================
            */
        }elseif($do == 'add'){

            
            ?> 

                <div class="container items">
                    <h1 class="text-center">add item</h1>
                        <form action="?do=insert" method='POST'>
                            <div class="form-group row justify-content-center">
                                <label class="col col-sm-4 col-md-3 col-lg-2" for="item">Item:</label>
                                <input class="col col-sm-7 col-md-6 col-lg-5" type="text" name="item" id="item"  required placeholder="Item Name"/>
                            </div>
                            <div class="form-group row justify-content-center">
                                <label class="col col-sm-4 col-md-3 col-lg-2" for="description">Description:</label>
                                <textarea class="col col-sm-7 col-md-6 col-lg-5" name="description" id="description"  rows="4" placeholder="Write Item Description"></textarea>
                                <!-- <input class="col col-sm-7 col-md-6 col-lg-5" type="text" name="description" id="description" placeholder="Item Description"/> -->
                            </div>
                            <div class="form-group row justify-content-center">
                                <label class="col col-sm-4 col-md-3 col-lg-2" for="price">Price:</label>
                                <input class="col col-sm-7 col-md-6 col-lg-5" type="text" name="price" id="price" placeholder="Item Price"/>
                            </div>
                            <div class="form-group row justify-content-center">
                                <label class="col col-sm-4 col-md-3 col-lg-2" for="made">Made In:</label>
                                <input class="col col-sm-7 col-md-6 col-lg-5" type="text" name="made" id="made" placeholder="Made Country"/>
                            </div>
                            <div class="form-group row justify-content-center">
                                <label class="col col-sm-4 col-md-3 col-lg-2" for="status">Status:</label>
                                <select class="custom-select col col-sm-7 col-md-6 col-lg-5" name="status" id="status" required>
                                    <option value="new">new</option>
                                    <option value="like new">like new</option>
                                    <option value="used">used</option>
                                </select>        
                            </div>
                            <div class="form-group row justify-content-center">
                                <label class="col col-sm-4 col-md-3 col-lg-2" for="user">Category:</label>
                                <select class="custom-select col col-sm-7 col-md-6 col-lg-5" name="user" id="user" required>
                                    
                                    <?php
                                        //FETCH CATEGOORIES
                                        $statUser = $db->prepare("SELECT UserId, UserName FROM users");
                                        $statUser->execute();
                                        $users = $statUser->fetchAll();
                                        if($statUser->rowCount()){
                                            foreach($users as $user){
                                                echo "<option value='".$user['UserId']."'>".$user['UserName']."</option>";
                                            }
                                        }
                                    ?>
                                </select>        
                            </div>

                            <div class="form-group row justify-content-center">
                                <label class="col col-sm-4 col-md-3 col-lg-2" for="category">Category:</label>
                                <select class="custom-select col col-sm-7 col-md-6 col-lg-5" name="category" id="category" required>
                                    
                                    <?php
                                        //FETCH CATEGOORIES
                                        $statCat = $db->prepare("SELECT ID, Name FROM categories");
                                        $statCat->execute();
                                        $categories = $statCat->fetchAll();
                                        if($statCat->rowCount()){
                                            foreach($categories as $cat){
                                                echo "<option value='".$cat['ID']."'>".$cat['Name']."</option>";
                                            }
                                        }
                                    ?>
                                </select>        
                            </div>
                            
                            <div class="form-group row justify-content-center">
                                <div class="col-12 col-sm-11 col-md-9 col-lg-7">    
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i>Add Item</button>
                                </div>
                            </div>
                            
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

            if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
                // INSTANCIATE THE VAALIDATION CLASS
                $validate = new Validation($_POST);

                // GETING THE DATA THROUGH 'POST' METHOD
                $item = $_POST['item'];
                $desc = $_POST['description'];
                $price = $_POST['price'];
                $made = $_POST['made'];
                $status = $_POST['status'];
                $category = $_POST['category'];
                $user = $_POST['user'];

                // CALL VAIDATE FUNCTIONS
                $validate->validateName($item, 'Item');
                $validate->validateString($desc, 'Desc');
                //$validate->validateName($category, 'Category');

                // ERRORS ARRAY
                $errors = $validate->errors;
                
                if($errors){

                    foreach($errors as $error){
                        echo '<div class="alert alert-danger">' .$error. '</div>';
                    }
                }else{
                    $stmt = $db->prepare("INSERT INTO
                                            items
                                                (Name, Description, Price, Add_Date, Made_In, Status, ID, User_Id)
                                            values
                                                (:pitem, :pdesc, :pprice, now(), :pmade, :pstatus, :pid, :puser)");

                    
                    $stmt->execute(array(
                        "pitem" => $item,
                        "pdesc" => $desc,
                        "pprice" => $price,
                        "pmade" => $made,
                        "pstatus" => $status,
                        "pid" => $category,
                        "puser" => $user
                    ));

                    $row = $stmt->rowCount();

                    if($row){
                        $msg = "<div class='alert alert-success'>" . $row . " Member Inserted !!</div>";
                        redirectHome($msg, 'back');
                    }else{
                        $msg = "<div class='alert alert-success'>" . $row . " Member Inserted !!</div>";
                        redirectHome($msg, 'back');
                    }
                }

            }else{
                $msg = '<div class="alert alert-danger">You Can\'t Access This Page Directly</div></div>';
                redirectHome($msg);
            }
            
            
            /*
            ================================================================================
            == EDIT MEMBER
            ================================================================================
            */
        }elseif ($do == 'edit'){       
            /*
            ================================================================================
            == UPDATE MEMBER
            ================================================================================
            */
        }elseif($do == 'update'){

            echo '<div class="container"><h1 class="text-center">update member</h1>';
            
            /*
            ================================================================================
            == DELETE MEMBER
            ================================================================================
            */

        }elseif($do == 'delete'){

            echo "<div class='container'><h1 class='text-center'>Delete Member Page</h1>";

        }else{
            echo 'default';
        }

        //Include Footer
        include $template . 'footer.php';

    }else{

        header('location: index.php');
        exit();
    }

    