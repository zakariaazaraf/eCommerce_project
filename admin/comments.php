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
                echo "<h2>Manage Page !! :)</h2>";
                /*
                ==================================================================================
                ====================== BRING THE USERS FROM THE DATABASE =========================*/

                $stmt = $db->prepare("SELECT * FROM comments ");
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
                                    <th>Item</th>
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
                                            echo "<th>" . $comment['UserId'] . "</th>";
                                            echo "<td>" . $comment['UserName'] . "</td>";
                                            echo "<td>" . $comment['Email'] . "</td>";
                                            echo "<td>" . $comment['FullName'] . "</td>";
                                            echo "<td>" . $comment['Date'] . "</td>";
                                            echo "<td>";
                                                /* echo "<a href='?do=edit&commentid=" . $comment['Comment_Id'] . "' class='btn btn-success' role='button'><i class='fas fa-edit'></i>Edit</a>";
                                                echo "<a href='?do=delete&commentid=" . $comment['Comment_Id'] . "' class='btn btn-danger confirm' role='button'><i class='fas fa-trash'></i>Delete</a>"; */
                                                echo !$comment['Status'] ? "<a href='?do=Approve&commentid=" . $comment['Comment_Id'] . "' class='btn btn-info' role='button'><i class='fas fa-pen-fancy'></i>Approve</a>" : '';
                                            echo "</td>";
                                        echo "</tr>";

                                    }
                                ?>
                                <!-- END A PHP CODE WHISH BRIGN USERS FROM DB -->
                                
                            </tbody>
                        </table>
                    </div>
                    <a href='comments.php?do=add' class="btn btn-primary"><i class="fas fa-plus"></i>New Member</a>
                </div>
                
                <?php
                break;
            
            case 'Approve':
                // CODE 
                echo "<h2>Approve Page</h2>";
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