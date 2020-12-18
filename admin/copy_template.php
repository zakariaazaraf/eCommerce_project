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

            echo '<div class="container"><h1 class="text-center">Insert member</h1>';
    
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

    