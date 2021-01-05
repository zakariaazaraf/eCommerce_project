<?php


    /*
     *******************************************************************
     ********************** FRONTEND FUNCTIONS *************************
     **/

    /*
      =========================================================
      === @name : getCategories
      === @desc : get the categories And Return Them As Array
                  Add The Limit Categories
      === @version: v2.0
      ========================================================= 
    */

    function getCategories($limit = 4){
      global $db;
      $statement = $db->prepare("select * FROM categories ORDER BY Cat_Id LIMIT $limit");
      $statement->execute();
      $categories = $statement->fetchAll();
      return $categories;
    }

    /*
      =========================================================
      === @name : getItems
      === @desc : get the items relaited to a categoryby passing the categori ID
      === @version: v1.0
      ========================================================= 
    */

    function getItems($where, $value){
      global $db;
      $statement = $db->prepare("SELECT * FROM Items WHERE $where = ? ORDER BY Item_Id DESC");
      $statement->bindParam(1, $value);
      $statement->execute();
      $items = $statement->fetchAll();
      return $items;
    }

    /*
      =========================================================
      === @name : checkUserStatus
      === @desc : Check If The User Has The Ability To User All Functionalty
      === @version: v1.0
      ========================================================= 
    */

    function checkUserStatus($user){
      global $db;
      $stat = $db->prepare("SELECT UserId FROM users WHERE UserName = ? AND RegStatus = 0");
      $stat->bindParam(1, $user);
      $stat->execute();
      return $stat->rowCount();
    }

    /*
     *******************************************************************
     ********************** FRONTEND FUNCTIONS *************************
     **/

    function getTitle(){

        global $titlePage;

        echo isset($titlePage) ? $titlePage : "Default";

    }


    /*
      =========================================================
      === @name : redirectHome
      === @desc : Check After Insert A New Item, If Exists
      === @version: v2.0
      ========================================================= 
    */

    function redirectHome($msg, $url = null, $seconds = 3){

        
       /*  if(!$url){
            $url = 'index.php';
        }else{

            $url = isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '' ? $_SERVER['HTTP_REFERER'] : 'index.php';
        } */

        if($url === 'back'){
          $url = $_SERVER['HTTP_REFERER'];
        }else{
          $url = $url ?  $url : 'index.php';
        }

        echo $msg;
        echo "<div class='alert alert-success'>You'll Be Redirected To $url Page After $seconds Seconds</div></div>";

        header("refresh:$seconds;url=$url");
        exit();
    }

    /*
      =========================================================
      === @name : checkItem
      === @desc : Check After Insert A New Item, If Exists + Give Him Possibility To Override On Update
      === @version: v2.0
      ========================================================= 
    */

      function checkItem($select, $from, $value, $update = false, $ID = 1){
            global $db;
            // IF THE USER WANT TO UPDATE THE COLUMN, WE SHOULDN'T DENIED THE POSSIBLITY OF OVERRIDE THE CURRENT COLUMN
            if($update !== false){ 
              $stetment = $db->prepare("SELECT $select FROM $from WHERE $select = ? AND $update != ?"); 
              $stetment->execute(array($value, $ID));
              return $stetment->rowCount();
            }
            $stetment = $db->prepare("SELECT $select FROM $from WHERE $select = ?"); 
            $stetment->execute(array($value));
            return $stetment->rowCount();
      }

    /*
      =========================================================
      === @name : countColumns
      === @desc : Get The Columns's Number From Passed Table
      === @version: v1.0
      ========================================================= 
    */

    function countColumns($column, $table){
      global $db;
      $stem = $db->prepare("SELECT COUNT($column) FROM $table");
      $stem->execute();
      return $stem->fetchColumn();
    }

    /*
      =========================================================
      === @name : getLatest
      === @desc : Get The last records iserted, it could be {users, categories, comment, ...}
      === @version: v1.0
      ========================================================= 
    */

    function getLatest($select, $table, $orderBy, $limit = 5){
      global $db;
      $stetment = $db->prepare("SELECT $select FROM $table ORDER BY $orderBy DESC LIMIT $limit");
      $stetment->execute();
      return $stetment->fetchAll();
    }

    /*
      =========================================================
      === @name : ThroughErrors
      === @desc : Pass An Array Of Errors And Print Them
      === @version: v1.0
      ========================================================= 
    */

    function throughErrors($errors){
        foreach($errors as $error){
          echo "<div class='alert alert-danger'>".$error."</div>";
        }
    }