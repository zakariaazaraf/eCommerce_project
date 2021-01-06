<?php 
    // START THE SESSION 
    session_start();

    $titlePage = "Profil";

    include 'init.php';

    if($sessionUser){

        // FETCH THE DATA RELATED TO THIS USER
        $stat = $db->prepare("SELECT * FROM users WHERE UserName = ?");
        $stat->bindParam(1, $sessionUser);
        $stat->execute();
        $userInfo = $stat->fetch();

        ?>

        <h1 class='text-center'>Create New Advertisement </h1>
            
                <div class="advertisements-card mb-3">
                    <div class='container'>
                        <div class='card bg-dark'>
                            <h3 class='card-header'>Create Advertise</h3>
                            <div class='container'>
                                <div class="row justify-content-center">

                                    <div class="col-10 col-sm-10 col-md-4">
                                        <div class="card">
                                            <img class='card-img-top img-fluid' src='./layout/images/item1.jpg' alt=''/>
                                            <div class='card-body'>
                                                <h4 class='card-title'>Title</h4>
                                                <p class='card-text'>Desc</p>
                                                <p class='card-text'><small class='text-muted'>Made By</small></p>
                                                <span class='price'>$20</sapn>
                                            </div>
                                        </div>
                                         
                                    </div> 

                                    <form class="ads-form col-10 col-sm-10 col-md-8" action="?do=insert" method='POST'>
                                        <div class="form-group row ">
                                            <label class="col col-md-4" for="item">Item:</label>
                                            <input class="col col-md-7" type="text" name="item" id="item"  required placeholder="Item Name"/>
                                        </div>
                                        <div class="form-group row ">
                                            <label class="col col-md-4" for="description">Description:</label>
                                            <textarea class="col col-md-7" name="description" id="description"  rows="4" placeholder="Write Item Description"></textarea>
                                            <!-- <input class="col" type="text" name="description" id="description" placeholder="Item Description"/> -->
                                        </div>
                                        <div class="form-group row ">
                                            <label class="col col-md-4" for="price">Price:</label>
                                            <input class="col col-md-7" type="text" name="price" id="price" placeholder="Item Price"/>
                                        </div>
                                        <div class="form-group row ">
                                            <label class="col col-md-4" for="made">Made In:</label>
                                            <input class="col col-md-7" type="text" name="made" id="made" placeholder="Made Country"/>
                                        </div>
                                        <div class="form-group row ">
                                            <label class="col col-md-4" for="status">Status:</label>
                                            <select class="custom-select col col-md-7" name="status" id="status" required>
                                                <option value="new">new</option>
                                                <option value="like new">like new</option>
                                                <option value="used">used</option>
                                            </select>        
                                        </div>
                                       

                                        <div class="form-group row ">
                                            <label class="col col-md-4" for="category">Category:</label>
                                            <select class="custom-select col col-md-7" name="category" id="category" required>
                                                
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
                                        
                                        <div class="form-group row ">
                                            <div class="col">    
                                                <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i>Add Item</button>
                                            </div>
                                        </div>                           
                                    </form>
                                                                                
                                </div>
                            </div>

                        </div>  
                    </div>
                </div>
              

        <?php

    }else{
        header('Location: login.php');
        exit();
    }

    include $template . 'footer.php';
   
?>



