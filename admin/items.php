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
             **
             * Fetch All Items
             * 
             *    
             **/
            /*
            ==================================================================================
            ====================== BRING THE USERS FROM THE DATABASE =========================*/
            
            $statemnt = $db->prepare("SELECT * FROM items");
            $statemnt->execute();
            $items = $statemnt->fetchAll();

            /*================================================================================*/
            ?>

            <h1 class="text-center">manage items</h1>
            <div class="container">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered text-center">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Add Date</th>
                                <th>Made In</th>
                                <th>Control</th>
                            </tr>
                        </thead>
                        <tbod>

                            <!-- START A PHP CODE WHISH BRIGN USERS FROM DB -->
                            <?php
                                foreach($items as $item){

                                    echo "<tr>";
                                        echo "<th>" . $item['Item_ID'] . "</th>";
                                        echo "<td>" . $item['Name'] . "</td>";
                                        echo "<td>" . $item['Description'] . "</td>";
                                        echo "<td>" . $item['Price'] . "</td>";
                                        echo "<td>" . $item['Add_Date'] . "</td>";
                                        echo "<td>" . $item['Made_In'] . "</td>";
                                        echo "<td>";
                                            echo "<a href='?do=edit&userid=" . $item['UserId'] . "' class='btn btn-success' role='button'><i class='fas fa-edit'></i>Edit</a>";
                                            echo "<a href='?do=delete&userid=" . $item['UserId'] . "' class='btn btn-danger confirm' role='button'><i class='fas fa-trash'></i>Delete</a>";
                                        echo "</td>";
                                    echo "</tr>";

                                }
                            ?>
                            <!-- END A PHP CODE WHISH BRIGN USERS FROM DB -->
                            
                        </tbody>
                    </table>
                </div>
                <a href='members.php?do=add' class="btn btn-primary"><i class="fas fa-plus"></i>New Item</a>
            </div>
            
            <?php
        
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
                                <label class="col col-sm-4 col-md-3 col-lg-2" for="user">User:</label>
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
                                        $statCat = $db->prepare("SELECT Cat_Id, Name FROM categories");
                                        $statCat->execute();
                                        $categories = $statCat->fetchAll();
                                        if($statCat->rowCount()){
                                            foreach($categories as $cat){
                                                echo "<option value='".$cat['Cat_Id']."'>".$cat['Name']."</option>";
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
                                                (Name, Description, Price, Add_Date, Made_In, Status, Cat_Id, UserId)
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

    