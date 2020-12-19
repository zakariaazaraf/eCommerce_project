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

    $titlePage = 'Categories';

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

            /*
            ==================================================================================
            ====================== BRING THE USERS FROM THE DATABASE =========================*/
            $order = 'ASC'; // DESC
            $sort_array = array('ASC', 'DESC');
            if(isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)){
                $order = $_GET['sort'];
            }
            $stmt = $db->prepare("SELECT * FROM categories ORDER BY ID $order");
            $stmt->execute();
            $categories = $stmt->fetchAll();

            /*================================================================================*/
            ?>

            <h1 class="text-center">manage categories</h1>
            <div class="container categories">
                <div class="row justify-content-center">
                
                <!-- START A PHP CODE WHISH BRIGN CATEGORIES FROM DB -->
                <?php  

                    foreach($categories as $category){

                        echo "<div class='card border-secondary col-11 col-sm-10 col-md-8 col-lg-7 px-0 my-3'>";

                            echo "<div class='card-header d-flex justify-content-between py-0'>";
                                echo "<h5 class='card-title my-1 text-capitalize font-weight-bold'>" . $category['Name']. "</h5>";
                                echo "<div>";
                                    echo "<a href='?do=edit&ID=".$category['ID']."' class='btn btn-success m-1' role='button'><i class='fas fa-edit'></i>Edit</a>";
                                    echo "<a href='?do=delete&ID=".$category['ID']."' class='btn btn-danger m-1 confirm' role='button'><i class='fas fa-trash'></i>Delete</a>";
                                echo "</div>";
                                
                            echo "</div>";

                            echo "<div class='card-body text-secondary'>";
                                echo "<p class='card-text'>" . $category['Description']. "</p>";
                            echo "</div>";

                            echo "<div class='card-footer bg-transparent border-secondary'>";
                                echo "<span class='m-1 alert alert-";  echo $category['Visibility'] ? 'success' : 'danger'; echo "'>Visibility</span>";
                                echo "<span class='m-1 alert alert-";  echo $category['Allow_Comments'] ? 'success' : 'danger'; echo "'>Comments</span>";
                                echo "<span class='m-1 alert alert-";  echo $category['Add_Ads'] ? 'success' : 'danger'; echo "'>Advertise</span>";
                                
                            echo "</div>";

                        echo "</div>";

                    }
                    
                ?>

                </div>
                <!-- END A PHP CODE WHISH BRIGN CATEGORIES FROM DB -->
                            
                <a href='categories.php?do=add' class="btn btn-primary"><i class="fas fa-plus"></i>New Category</a>
            </div>
            
            <?php
            /*
            ================================================================================
            == ADD Category
            ================================================================================
            */
        }elseif($do == 'add'){
        
            ?> 

                    <div class="container categories">
                    <h1 class="text-center">add category</h1>
                        <form action="?do=insert" method='POST'>
                            <div class="form-group row justify-content-center">
                                <label class="col col-sm-4 col-md-3 col-lg-2" for="category">Category:</label>
                                <input class="col col-sm-7 col-md-6 col-lg-5" type="text" name="category" id="category"  required autocomplete="off" placeholder="Category Name"/>
                            </div>
                            <div class="form-group row justify-content-center">
                                <label class="col col-sm-4 col-md-3 col-lg-2" for="description">Description:</label>
                                <input class="col col-sm-7 col-md-6 col-lg-5" type="text" name="description" id="description" placeholder="Category Description"/>
                            </div>
                            <div class="form-group row justify-content-center">
                                <label class="col col-sm-4 col-md-3 col-lg-2" for="ordering" class="col-sm-2">Ordering:</label>
                                <input class="col col-sm-7 col-md-6 col-lg-5" type="text" name="ordering" id="ordering" placeholder="Arrange Order Number"/>
                            </div>

                            <fieldset class="form-group">
                                <div class="row justify-content-center">
                                    <legend class="col-form-label col col-sm-4 col-md-3 col-lg-2">Visibility:</legend>
                                    <div class="col col-sm-7 col-md-6 col-lg-5">

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="visibility" id="visibility-yes" value="1">
                                            <label class="form-check-label" for="visibility-yes">Yes</label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="visibility" id="visibility-no" value="0" checked>
                                            <label class="form-check-label" for="visibility-no">No</label>
                                        </div>

                                    </div>
                                </div>
                            </fieldset>

                            <fieldset class="form-group">
                                <div class="row justify-content-center">
                                    <legend class="col-form-label col col-sm-4 col-md-3 col-lg-2">Comments:</legend>
                                    <div class="col col-sm-7 col-md-6 col-lg-5">

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="comments" id="comments-yes" value="1">
                                            <label class="form-check-label" for="comments-yes">Yes</label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="comments" id="comments-no" value="0" checked>
                                            <label class="form-check-label" for="comments-no">No</label>
                                        </div>

                                    </div>
                                </div>
                            </fieldset>

                            <fieldset class="form-group">
                                <div class="row justify-content-center">
                                    <legend class="col-form-label col col-sm-4 col-md-3 col-lg-2">Advertisements:</legend>
                                    <div class="col col-sm-7 col-md-6 col-lg-5">

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="ads" id="ads-yes" value="1">
                                            <label class="form-check-label" for="ads-yes">Yes</label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="ads" id="ads-no" value="0" checked>
                                            <label class="form-check-label" for="ads-no">No</label>
                                        </div>

                                    </div>
                                </div>
                            </fieldset>
                            <div class="form-group row justify-content-center">
                                <div class="col-12 col-sm-11 col-md-9 col-lg-7">    
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i>Add Categoy</button>
                                </div>
                            </div>
                            
                        </form>
                    </div>    

            <?php

            /*
            ================================================================================
            == INSERT Category
            ================================================================================
            */
        }elseif($do == 'insert'){

            echo '<div class="container"><h1 class="text-center">Insert Category</h1>';
            
            // CHECK IF THE USER CAME BY A POST REQUEST
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                
                // GET THE DATA FROM THE POST REQUEST
                $name = $_POST['category'];
                $desc = $_POST['description'];
                $ordering = $_POST['ordering'];
                $visibility = $_POST['visibility'];
                $comments = $_POST['comments'];
                $ads = $_POST['ads'];


                /*==========================================================
                =================== Form Validation =======================*/

                $errors = '';
                $var = trim($name);

                if(empty($var)){
                    $errors = 'The Name field Cannot Be Empty';
                }else{
                    if(!preg_match('/^[a-zA-Z]{3,25}$/', $var)){
                        $errors = 'The Name Field Must Be 2-25 Characters';
                    }
                }              

                /*==========================================================*/

                if($errors){

                    // THROW THE ERRORS
                    echo "<h3>Errors Encountered !!</h3></div>";
                    echo "<div >" . isset($errors) ? $errors : '' . "</div>";
                    
                }else{

                    // CHECK IF THE USER EXISTS IN DATABASE
                    

                    if(!checkItem('Name', 'categories', $name)){

                        // INSERT A NEW MEMBER WITH THE BINDING METHOD I DATABASE
                        $stmt = $db->prepare("INSERT INTO 
                                                        categories 
                                                            (Name, Description, Ordering, Visibility, Allow_Comments, Add_Ads) 
                                                        VALUES (?, ?, ?, ?, ?, ?)");
                                   
                        
                        $stmt->execute(array($name, $desc, $ordering, $visibility, $comments, $ads));
                        
                        $row = $stmt->rowCount();

                        $msg = "<div class='alert alert-success'>" . $row . " Member Inserted !!</div>";
                        redirectHome($msg, 'categories.php');

                    }else{

                        $msg = '<div class="alert alert-danger">This Name Allready Exists</div></div>';
                        redirectHome($msg, 'dashboard.php');

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

            $ID = isset($_GET['ID']) && is_numeric($_GET['ID']) ? intval($_GET['ID'])  : 0;
            $stmt = $db->prepare("SELECT * FROM categories WHERE ID = ?");
            $stmt->execute(array($ID));
            $category = $stmt->fetch();
            $rowCount = $stmt->rowCount();

            if($rowCount > 0){
                ?>
                    <div class="container categories">
                    <h1 class="text-center">Edit category</h1>
                        <form action="?do=update" method='POST'>
                            <!-- Hidden Input For Id -->
                            <input type="hidden" name="ID" value="<?php echo $ID ?>">
                            <div class="form-group row justify-content-center">
                                <label class="col col-sm-4 col-md-3 col-lg-2" for="category">Category:</label>
                                <input class="col col-sm-7 col-md-6 col-lg-5" type="text" name="category" id="category" required autocomplete="off" placeholder="Category Name" value="<?php echo $category['Name'] ?>"/>
                            </div>
                            <div class="form-group row justify-content-center">
                                <label class="col col-sm-4 col-md-3 col-lg-2" for="description">Description:</label>
                                <input class="col col-sm-7 col-md-6 col-lg-5" type="text" name="description" id="description" placeholder="Category Description" value="<?php echo  $category['Description'] ?>"/>
                            </div>
                            <div class="form-group row justify-content-center">
                                <label class="col col-sm-4 col-md-3 col-lg-2" for="ordering" class="col-sm-2">Ordering:</label>
                                <input class="col col-sm-7 col-md-6 col-lg-5" type="text" name="ordering" id="ordering" placeholder="Arrange Order Number" value="<?php echo $category['Ordering']?>"/>
                            </div>

                            <fieldset class="form-group">
                                <div class="row justify-content-center">
                                    <legend class="col-form-label col col-sm-4 col-md-3 col-lg-2">Visibility:</legend>
                                    <div class="col col-sm-7 col-md-6 col-lg-5">

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="visibility" id="visibility-yes" value="1" <?php echo $category['Visibility'] ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="visibility-yes">Yes</label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="visibility" id="visibility-no" value="0" <?php echo !$category['Visibility'] ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="visibility-no">No</label>
                                        </div>

                                    </div>
                                </div>
                            </fieldset>

                            <fieldset class="form-group">
                                <div class="row justify-content-center">
                                    <legend class="col-form-label col col-sm-4 col-md-3 col-lg-2">Comments:</legend>
                                    <div class="col col-sm-7 col-md-6 col-lg-5">

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="comments" id="comments-yes" value="1" <?php echo $category['Allow_Comments'] ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="comments-yes">Yes</label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="comments" id="comments-no" value="0" <?php echo !$category['Allow_Comments'] ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="comments-no">No</label>
                                        </div>

                                    </div>
                                </div>
                            </fieldset>

                            <fieldset class="form-group">
                                <div class="row justify-content-center">
                                    <legend class="col-form-label col col-sm-4 col-md-3 col-lg-2">Advertisements:</legend>
                                    <div class="col col-sm-7 col-md-6 col-lg-5">

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="ads" id="ads-yes" value="1" <?php echo $category['Add_Ads'] ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="ads-yes">Yes</label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="ads" id="ads-no" value="0" <?php echo !$category['Add_Ads'] ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="ads-no">No</label>
                                        </div>

                                    </div>
                                </div>
                            </fieldset>

                            <div class="form-group row justify-content-center">
                                <div class="col-12 col-sm-11 col-md-9 col-lg-7">    
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i>Save Categoy</button>
                                </div>
                            </div>
                            
                        </form>
                    </div>
                <?php

            }else{
                $msg = "<div class='container mt-4'><div class='col-6 mx-auto alert alert-danger'>there's no such ID</div>";
                redirectHome($msg);
            }

            /*
            ================================================================================
            == UPDATE Category
            ================================================================================
            */    
        }elseif($do == 'update'){

            echo '<div class="container"><h1 class="text-center">update category</h1>';

            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                
                

                if(!checkItem('Name', 'categories', $_POST['category'])){

                    $stmt = $db->prepare("UPDATE categories SET Name = ?, Description = ?, Ordering = ?, Visibility = ?, Allow_Comments = ?, Add_Ads = ? WHERE ID = ?");
                    $stmt->execute(array($_POST['category'], $_POST['description'], $_POST['ordering'], $_POST['visibility'], $_POST['comments'], $_POST['ads'], $_POST['ID']));
                    $rowCount = $stmt->rowCount();

                    if($rowCount){
                        $msg = "<div class='alert alert-success'>Category Updated Bye Bye :) :) !!</div>";
                        redirectHome($msg, 'categories.php');
                    }else{
                        $msg = "<div class='alert alert-danger'>Error Encountred :( :( !!</div>";
                        redirectHome($msg, 'categories.php');
                    }

                }else{
                    $msg = "<div class='alert alert-danger'>Name Already Exists :( :( !!</div>";
                    redirectHome($msg, 'back');
                }

                
                
            }else{
                $msg = "<div class='alert alert-danger'>Method denied :( :(</div>";
                redirectHome($msg);
            }
            
            /*
            ================================================================================
            == DELETE Category
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

?>