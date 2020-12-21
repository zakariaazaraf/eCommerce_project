<?php
    class Validation{

        private $data;    
        public $errors = [];

        // CONSTRUCTOR
        public function __construct($postData){
            $this->data = $postData;
        }

        // VALIDATE SIMPLE NAME
        public function validateName($field){
            $field = trim($field);
            if(!empty($field)){
                if(!preg_match('/^[a-zA-Z]+[a-zA-Z0-9\' \'][a-zA-Z0-9]{3,25}$/', $field)){
                    $err = "This Field Must Contain 5-25 Chrs !!";
                    $this->addError($err);
                }
            }else{
                $err = "This Field Cannot Be Empty !!";
                $this->addError($err);
            }       
        }

        public function addError($msg){
            array_push($this->errors, $msg);
        }


    }
?>