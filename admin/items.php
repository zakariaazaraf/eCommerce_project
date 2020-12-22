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
            
            $statemnt = $db->prepare("SELECT items.*, users.UserName as User, categories.Name as Category 
                                        FROM 
                                            items 
                                        inner join 
                                            users
                                        on items.UserId = users.UserId
                                        inner join 
                                            categories
                                        on items.Cat_Id = categories.Cat_Id");
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
                                <th>User</th>
                                <th>Category</th>
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
                                        //JOIN TO MAKE USER AND CATEGORY NAMES
                                        echo "<td>" . $item['User']. "</td>";
                                        echo "<td>" . $item['Category']. "</td>";
                                        echo "<td>" . $item['Add_Date'] . "</td>";
                                        echo "<td>" . $item['Made_In'] . "</td>";
                                        echo "<td>";
                                            echo "<a href='?do=edit&itemid=" . $item['Item_ID'] . "' class='btn btn-success' role='button'><i class='fas fa-edit'></i>Edit</a>";
                                            echo "<a href='?do=delete&itemid=" . $item['Item_ID'] . "' class='btn btn-danger confirm' role='button'><i class='fas fa-trash'></i>Delete</a>";
                                        echo "</td>";
                                    echo "</tr>";

                                }
                            ?>
                            <!-- END A PHP CODE WHISH BRIGN USERS FROM DB -->          
                        </tbody>
                    </table>
                </div>
                <a href='items.php?do=add' class="btn btn-primary"><i class="fas fa-plus"></i>New Item</a>
            </div>
            
            <?php
        
            /*
            ================================================================================
            == ADD ITEM
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

            echo '<div class="container mt-5">';

            $itemId = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']): 0;

            if(checkItem('Item_ID', 'items', $itemId)){
                $statement = $db->prepare("SELECT * FROM items WHERE Item_Id = ?");
                $statement->bindParam(1, $itemId);
                $statement->execute();
                $item = $statement->fetch();
            
                ?> 
                    <div class="container items">
                        <h1 class="text-center">edit item</h1>
                            <form action="?do=update" method='POST'>
                                <div class="form-group row justify-content-center">
                                    <label class="col col-sm-4 col-md-3 col-lg-2" for="item">Item:</label>
                                    <input class="col col-sm-7 col-md-6 col-lg-5" type="text" name="item" id="item"  required placeholder="Item Name" value="<?php echo $item['Name']?>"/>
                                    <input type='hidden' name='item_Id' value="<?php echo $itemId?>"/>
                                </div>
                                <div class="form-group row justify-content-center">
                                    <label class="col col-sm-4 col-md-3 col-lg-2" for="description">Description:</label>
                                    <textarea class="col col-sm-7 col-md-6 col-lg-5" name="description" id="description"  rows="4" placeholder="Write Item Description" required><?php echo $item['Description']?></textarea>
                                    <!-- <input class="col col-sm-7 col-md-6 col-lg-5" type="text" name="description" id="description" placeholder="Item Description"/> -->
                                </div>
                                <div class="form-group row justify-content-center">
                                    <label class="col col-sm-4 col-md-3 col-lg-2" for="price">Price:</label>
                                    <input class="col col-sm-7 col-md-6 col-lg-5" type="text" name="price" id="price" placeholder="Item Price" required value="<?php echo $item['Price']?>"/>
                                </div>
                                <div class="form-group row justify-content-center">
                                    <label class="col col-sm-4 col-md-3 col-lg-2" for="made">Made In:</label>
                                    <input class="col col-sm-7 col-md-6 col-lg-5" type="text" name="made" id="made" placeholder="Made Country" required value="<?php echo $item['Made_In']?>"/>
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
                                                    echo "<option value='".$user['UserId']."' "; echo $user['UserId'] === $item['UserId'] ? 'selected' : ''; echo ">".$user['UserName']."</option>";
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
                                                    echo "<option value='".$cat['Cat_Id']."' "; echo $cat['Cat_Id'] === $item['Cat_Id'] ? 'selected' : ''; echo ">".$cat['Name']."</option>";
                                                }
                                            }
                                        ?>
                                    </select>        
                                </div>
                                
                                <div class="form-group row justify-content-center">
                                    <div class="col-12 col-sm-11 col-md-9 col-lg-7">    
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i>Save Item</button>
                                    </div>
                                </div>
                                
                            </form>
                        </div>
                <?php
            }else{
                $msg = "<div class='alert alert-danger'>There's No ID Like This</div>";
                redirectHome($msg);
            }
            

            

            /*
            ================================================================================
            == UPDATE MEMBER
            ================================================================================
            */
        }elseif($do == 'update'){

            if($_SERVER['REQUEST_METHOD'] === 'POST'){

                echo "<div class='container'> <h1 class='text-center'>Update item</h1>";

                $itemID = $_POST['item_Id'];
                $item = $_POST['item'];
                $desc = $_POST['description'];
                $price = $_POST['price'];
                $made = $_POST['made'];
                $status = $_POST['status'];
                $user = $_POST['user'];
                $category = $_POST["category"];

                $validate = new Validation($_POST); 
                $validate->validateName($item, 'Item Name');
                $validate->validateString($desc, 'Description');

                $errors = $validate->errors;

                // VERIFY FORM ERRORS 
                if($errors){
                    throughErrors($errors);
                    //redirectHome('back');
                }else{
                    
                    $statement = $db->prepare('UPDATE items SET 
                                                            Name = ?,
                                                            Description = ?, 
                                                            Price = ?, 
                                                            Made_In = ?, 
                                                            Status = ?, 
                                                            Cat_Id = ?, 
                                                            UserId = ?
                                                        WHERE 
                                                            Item_ID = ?
                                                    ');

                    // BINDING PARAMETERS
                    $statement->bindParam(1, $item);
                    $statement->bindParam(2, $desc);
                    $statement->bindParam(3, $price);
                    $statement->bindParam(4, $made);
                    $statement->bindParam(5, $status);
                    $statement->bindParam(6, $category);
                    $statement->bindParam(7, $user);
                    $statement->bindParam(8, $itemID);

                    //array($item, $desc, $price, $made, $status, $category, $user, $itemID)

                    $statement->execute();
                    $rowCount = $statement->rowCount();

                    if($rowCount){
                        $msg = "<div class='alert alert-success'>".$rowCount." Of Records Updated !! :)</div>";
                        redirectHome($msg, 'back');
                        
                    }else{
                        $msg = "<div class='alert alert-danger'>".$rowCount." Of Records Updated !! :(</div>";
                        redirectHome($msg, 'back');
                        
                    }
                }


            }else{
                $msg = "<div class'alert alert-danger'>You Can't Acces This Page Directly</div>";
                redirectHome($msg);
            }
            
            /*
            ================================================================================
            == DELETE MEMBER
            ================================================================================
            */

        }elseif($do == 'delete'){

            echo "<div class='container'><h1 class='text-center'>Delete Member Page</h1>";
            $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
            

            if(checkItem('Item_ID', 'items',$itemid)){

                $statement = $db->prepare('DELETE FROM items WHERE Item_ID = ?');
                $statement->bindParam(1, $itemid);
                $statement->execute();
                $row = $statement->rowCount();

                if($row){ 
                    $msg = "<div class='alert alert-success'>$row Item Deleted !</div>";
                    redirectHome($msg, 'back');
                }else{
                    $msg = "<div class='alert alert-danger'>$row Item Deleted ! </div>";
                    redirectHome($msg, 'back');
                }

            }else{
                $msg = "<div class='alert alert-danger'>THIS ITEM DOES\'T EXISTS</div>";
                redirectHome($msg);
            }

        }elseif($do == 'approve'){
            echo '<div class="container"><h1 clas="text-center">You\'re In Approved Page</h1></div>';
            $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0 ;

            if(checkItem('Item_ID', 'items', $itemid)){
                echo "This Id Is There";
            }else{
                echo "This Aren't Exists In Database";
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

    