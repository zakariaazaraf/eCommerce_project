<?php


    /*==============================================
    ==============  Title Function  ================*/
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

        $url = $url ? $url = isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '' ? $_SERVER['HTTP_REFERER'] : 'index.php' : 'index.php';
       /*  if(!$url){
            $url = 'index.php';
        }else{

            $url = isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '' ? $_SERVER['HTTP_REFERER'] : 'index.php';
        } */

        echo $msg;
        echo "<div class='alert alert-success'>You'll Be Redirected To $url Page After $seconds Seconds</div></div>";

        header("refresh:$seconds;url=$url");
        exit();
    }

    /*
      =========================================================
      === @name : checkItem
      === @desc : Check After Insert A New Item, If Exists
      === @version: v1.0
      ========================================================= 
    */

      function checkItem($select, $from, $value){
            global $db;
            $stetment = $db->prepare("SELECT $select FROM $from WHERE $select = ?"); 
            $stetment->execute(array($value));
            return $stetment->rowCount();
      }