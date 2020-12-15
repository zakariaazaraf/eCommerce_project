<?php


    /*==============================================
    ==============  Title Function  ================*/
    function getTitle(){

        global $titlePage;

        echo isset($titlePage) ? $titlePage : "Default";

    }


    /*=========================================================
    ==============  ErrorRedirection Function  ================*/

    function ErrorRedirect($errorMsg, $seconds = 3){
        echo "<div class='container'> <div class='alert alert-danger'>$errorMsg</div>";
        echo "<div class='alert alert-success'>You'll Be Redirected To Home Page After $seconds Seconds</div></div>";

        header("refresh:$seconds;url=index.php");
        exit();
    }

    /*=========================================================
      === @name : checkItem
      === @desc : Check After Insert A New Item, If Exists
      === @version: v1.0
      ========================================================= */

      function checkItem($select, $from, $value){
            global $db;
            $stetment = $db->prepare("SELECT $select FROM $from WHERE $select = ?"); 
            $stetment->execute(array($value));
            return $stetment->rowCount();
      }