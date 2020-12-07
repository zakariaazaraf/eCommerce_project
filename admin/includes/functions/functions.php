<?php


    /********************************************************** 
    ****************** Title Functions ************************
    ************************************************************/

    function getTitle(){
        global $titlePage;
        if(isset($titlePage)){
            echo $titlePage;
        }else{
            echo 'Default';
        }
    }