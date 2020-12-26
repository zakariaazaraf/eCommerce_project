<?php
    /*
      ==============================================
      == MANGE COMMENTS PAGE
      == APPROVE COMMENT | DELETE | EDIT
      ==============================================
    */

    session_start();

    $titlePage = 'Comments';

    // CHECK IF THE USERS HAS THE PERMESSION OT ACCESS THIS PAGE
    if(isset($_SESSION['username'])){
        // INCLUDE INIT 
        include 'init.php';

        if(isset($_GET['do'])){
            $do = $_GET['do'];
        }else{
            $do = 'Manage';
        }

        // THE HTTP_REFERER OF THIS PAGE
        $httpReferer = 'http://localhost/eCommerce/admin/comments.php';

        // CALL THE VALIDATION CLASS
        require('fields_validation.php');

        /*
            ===================================================================
            ================== Swiching between Sections ======================
        */
        switch($do){

            /*
            ================================================================================
            == Manage SECTION
            ================================================================================
            */
            case 'Manage':
                
                /*
                 *==================================================================================
                 *====================== BRING THE COMMENTS FROM THE DATABASE =========================
                 **/

                $stmt = $db->prepare("SELECT comments.*, items.Name, users.UserName 
                                        FROM 
                                            comments 
                                        inner join 
                                            items 
                                        on 
                                            comments.Item_Id = items.Item_ID
                                        inner join 
                                            users
                                        on
                                            comments.User_Id = users.UserId");
                $stmt->execute();
                $comments = $stmt->fetchAll();

                /*================================================================================*/
                ?>

                    <h1 class="text-center">manage comments</h1>
                    <div class="container">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered text-center">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Comment</th>
                                        <th>Item Name</th>
                                        <th>User</th>
                                        <th>Added Date</th>
                                        <th>Control</th>
                                    </tr>
                                </thead>
                                <tbod>

                                    <!-- START A PHP CODE WHISH BRIGN USERS FROM DB -->
                                    <?php
                                        foreach($comments as $comment){

                                            echo "<tr>";
                                                echo "<th>" . $comment['Comment_Id'] . "</th>";
                                                echo "<td>" . $comment['Comment'] . "</td>";
                                                echo "<td>" . $comment['Name'] . "</td>";
                                                echo "<td>" . $comment['UserName'] . "</td>";
                                                echo "<td>" . $comment['Comment_Date'] . "</td>";
                                                echo "<td>";
                                                    echo "<a href='?do=Edit&commentid=" . $comment['Comment_Id'] . "' class='btn btn-success' role='button'><i class='fas fa-edit'></i>Edit</a>";
                                                    echo "<a href='?do=Delete&commentid=" . $comment['Comment_Id'] . "' class='btn btn-danger confirm' role='button'><i class='fas fa-trash'></i>Delete</a>";
                                                    echo !$comment['Status'] ? "<a href='?do=Approve&commentid=" . $comment['Comment_Id'] . "' class='btn btn-info' role='button'><i class='fas fa-pen-fancy'></i>Approve</a>" : '';
                                                echo "</td>";
                                            echo "</tr>";

                                        }
                                    ?>
                                    <!-- END A PHP CODE WHISH BRIGN USERS FROM DB -->
                                    
                                </tbody>
                            </table>
                        </div>                        
                    </div>
                
                <?php
                break;
                /*
                ================================================================================
                == Approve SECTION
                ================================================================================
                */
            case 'Approve':
                
                if(isset($_SERVER['HTTP_REFERER']) && $httpReferer == $_SERVER['HTTP_REFERER']){

                    echo "<div class='container'><h1 class='text-center'>Approve Page</h1>";
                    
                    $comment_id = isset($_GET['commentid']) && is_numeric($_GET['commentid']) ? intval($_GET['commentid']) : 0;

                    if(checkItem('Comment_Id', 'comments', $comment_id)){

                        $statement = $db->prepare("UPDATE comments SET Status = 1 WHERE Comment_Id = ?");
                        $statement->bindParam(1, $comment_id);
                        $statement->execute();
                        $record = $statement->rowCount();

                        if($record){
                            $msg = "<div class='alert alert-success'>".$record." Approved</div>";
                            redirectHome($msg, 'comments.php');
                        }else{
                            $msg = "<div class='alert alert-danger'>".$record." Approved</div>";
                            redirectHome($msg, 'comments.php');
                        }

                        
                    }else{
                        $msg = "<div class='alert alert-danger'>This Id ".$comment_id." Doesn't Exists</div>";
                        redirectHome($msg);
                    }

                }else{
                    $msg = "<div class='alert alert-danger'>You Can't Browse This Page Directly</div>";
                    redirectHome($msg);
                }
                break;
                
                /*
                ================================================================================
                == Edit SECTION
                ================================================================================
                */
            case 'Edit':

                if(isset($_SERVER['HTTP_REFERER']) && $httpReferer == $_SERVER['HTTP_REFERER']){

                    $comment_id = isset($_GET['commentid']) && is_numeric($_GET['commentid']) ? intval($_GET['commentid']) : 0;

                    if(checkItem('Comment_Id', 'comments', $comment_id)){

                        $statement = $db->prepare("SELECT Comment, Status FROM Comments WHERE Comment_Id = ?");
                        $statement->bindParam(1, $comment_id);
                        $statement->execute();
                        $comment = $statement->fetch();

                        ?>
                            <div class="container categories">
                            <h1 class="text-center">Edit Comment</h1>
                                <form action="?do=Update" method='POST'>
                                    <!-- Hidden Input For Id -->
                                    <input type="hidden" name="commentid" value="<?php echo $comment_id ?>">

                                    <div class="form-group row justify-content-center">
                                        <label class="col col-sm-4 col-md-3 col-lg-2" for="comment">Comment:</label>
                                        <textarea class="col col-sm-7 col-md-6 col-lg-5" name="comment" id="comment"  rows="4" placeholder="Comment Content" required><?php echo $comment['Comment']?></textarea>
                                       
                                    </div>

                                    <div class="form-group row justify-content-center">
                                        <label class="col col-sm-4 col-md-3 col-lg-2" for="status">Status:</label>
                                        <select class="custom-select col col-sm-7 col-md-6 col-lg-5" name="status" id="status" required>
                                            <option value="0" <?php echo $comment['Status'] ? '': 'selected'?>>Not Approved</option>
                                            <option value="1" <?php echo !$comment['Status'] ? '': 'selected'?>>Approved</option>
                                        </select>        
                                    </div>

                                    <div class="form-group row justify-content-center">
                                        <div class="col-12 col-sm-11 col-md-9 col-lg-7">    
                                            <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i>Save Comment</button>
                                        </div>
                                    </div>
                                    
                                </form>
                            </div>
                        <?php

                    }else{
                        /* $msg = "<div class='alert alert-danger'>This Id ".$comment_id." Doesn't Exists</div>";
                        redirectHome($msg); */
                        echo "<div class='alert alert-danger'>This Id ".$comment_id." Doesn't Exists</div>";
                    }
                    
                }else{
                    
                    $msg = "<div class='alert alert-danger'>You Can't Browse This Page Directly</div>";
                    redirectHome($msg);
                }
                
                break;
                /*
                ================================================================================
                == Delete SECTION
                ================================================================================
                */
            case 'Delete':

                
                if(isset($_SERVER['HTTP_REFERER']) && $httpReferer == $_SERVER['HTTP_REFERER']){

                    echo '<div class="container"><h1 class="text-center">Delete Page</h1>';

                    $comment_id = isset($_GET['commentid']) && is_numeric($_GET['commentid']) ? intval($_GET['commentid']) : 0;

                    if(checkItem('Comment_Id', 'comments', $comment_id)){

                        $statement = $db->prepare("DELETE FROM comments WHERE Comment_Id = ?");
                        $statement->bindParam(1, $comment_id);
                        $statement->execute();
                        $record = $statement->rowCount();

                        if($record){
                            $msg = "<div class='alert alert-success'>".$record." Deleted</div>";
                            redirectHome($msg, 'comments.php');
                        }else{
                            $msg = "<div class='alert alert-danger'>".$record." Deleted</div>";
                            redirectHome($msg, 'comments.php');
                        }

                    }else{
                        $msg = "<div class='alert alert-danger'>This Id ".$comment_id." Doesn't Exists</div>";
                        redirectHome($msg);     
                    }
                    
                }else{
                    
                    $msg = "<div class='alert alert-danger'>You Can't Browse This Page Directly</div>";
                    redirectHome($msg);
                }
                break;

            case 'Update':
                echo '<div class="container my-3">';
                $comment = $_POST['comment'];
                $status = $_POST['status'];
                $comment_id = $_POST['commentid'];

                if($_SERVER['REQUEST_METHOD'] == 'POST'){

                    // INSTANTIATE AN OBJECT FROM CLASS VALIDATION
                    $validate = new Validation($_POST);
                    $validate->validateString($comment, 'Comment Content');

                    $errors = $validate->errors;

                    if(!$errors){
                        $statement = $db->prepare("UPDATE comments SET Comment = ?, Status = ? WHERE Comment_Id = ?");
                        $statement->bindParam(1, $comment);
                        $statement->bindParam(2, $status);
                        $statement->bindParam(3, $comment_id);
                        $statement->execute();
                        $record = $statement->rowCount();

                        if($record){
                            $msg = "<div class='alert alert-success'>".$record." Row Updated ! :)</div>";
                            redirectHome($msg, 'comments.php');
                            
                        }else{
                            $msg = "<div class='alert alert-danger'>".$record." Row Updated ! :(</div>";
                            redirectHome($msg, 'comments.php');          
                        }

                    }else{
                        $msg = "<div class='alert alert-danger'>We Encounter This Issues ! :(</div>";
                        throughErrors($errors);
                        redirectHome($msg, 'back');
                        
                    }             

                }else{
                    $msg = "<div class='alert alert-danger'>You Can't Browse This Page Directly</div>";
                    redirectHome($msg);
                }

                break;

            default: echo '<div class="alert alert-danger">This Doesn\'t Exisst</div>';
        }

        // INCLUDE FOOTER
        include $template . 'footer.php';

    }else{
        header('location: index.php');
        exit();
    }
?>