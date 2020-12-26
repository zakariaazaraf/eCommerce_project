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


        /*
        ================================================================================
        == Manage SECTION
        ================================================================================
        */
        switch($do){
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
                    <!-- <a href='comments.php?do=add' class="btn btn-primary"><i class="fas fa-plus"></i>New Member</a> -->
                </div>
                
                <?php
                break;
            
            case 'Approve':
                echo "<h2 class='text-center'>Approve Page</h2>";

                echo isset($_SERVER['HTTP_REFERER']) ? 'Came from Referer' : 'Undefined Referer'; //FROM WHERE THE BROWSER CAME FROM

                echo '<br />Request Methos ' . $_SERVER['REQUEST_METHOD'];

                echo '<pre>';
                print_r($_GET);
                echo '</pre>';
                break;

            case 'Edit':
                // EDIT SECTION CODE
                echo '<h1 class="text-center">Edit Page</h1>';
                echo '<pre>';
                print_r($_GET);
                echo '</pre>';
                $comment_id = isset($_GET['commentid']) && is_numeric($_GET['commentid']) ? intval($_GET['commentid']) : 0;
                echo 'Comment Id: ' . $comment_id;
                echo '<br />'. $_SERVER['REQUEST_URI'];
                echo '<br />' . $_SERVER['HTTP_REFERER'];
                break;

            case 'Delete':
                // DELETE SECTION CODE
                echo '<h1 class="text-center">Delete Page</h1>';
                echo '<pre>';
                print_r($_GET);
                echo '</pre>';
                $comment_id = isset($_GET['commentid']) && is_numeric($_GET['commentid']) ? intval($_GET['commentid']) : 0;
                echo 'Comment Id: ' . $comment_id;
                echo '<br />'. $_SERVER['REQUEST_URI'];
                echo '<br />' . $_SERVER['HTTP_REFERER'];
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