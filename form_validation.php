<?php
    class Validation{

        private $data;    
        public $errors = [];

        // CONSTRUCTOR
        public function __construct($postData){
            $this->data = $postData;
        }

        // VALIDATE SIMPLE NAME
        public function validateName($field, $name){
            $field = trim($field);
            
            if(!empty($field)){
                if(!preg_match('/^([a-zA-Z]+([a-zA-Z0-9\' \']?)([a-zA-Z0-9]?)){3,25}$/', $field)){
                    $err = "This <strong>$name</strong> Field Must Contain Only Between 5-25 Chrs !!";
                    $this->addError($err);
                }
            }else{
                $err = "This <strong>$name</strong>Field Cannot Be Empty !!";
                $this->addError($err);
            }
            
        
        }

        public function validateString($field, $name){
            $field = trim($field);
            
            if(!empty($field)){
                if(!preg_match('/^[a-zA-Z0-9@_!\' \'\.+-]{5,80}$/', $field)){
                    $err = "This <strong>$name</strong> Field Must Contain Only 5-80 Characters and {@ _-+!}!!";
                    $this->addError($err);
                }
            }else{
                $err = "This <strong>$name</strong> Field Cannot Be Empty !!";
                $this->addError($err);
            }
        }

        public function validateEmail($field, $name){
            $field = trim($field);
            if(empty($field)){
                $err = "The <strong>".$name."</strong> Souldn't Be Empty";
                $this->addError($err);
            }else{
                if(!filter_var($field, FILTER_VALIDATE_EMAIL)){
                    $err = "The <strong>".$name."</strong> Aren't Valid";
                    $this->addError($err);
                }
            }
        }

        public function validatePassword($field, $name){
            $field = trim($field);
            $field = filter_var($field, FILTER_SANITIZE_STRING);
            if(empty($field)){
                $err = "This <strong>$name</strong> Field Cannot Be Empty !!";
                $this->addError($err);
            }
        }

        public function matchPassword($pass1, $pass2){
            $pass1 = trim($pass1);
            $pass2 = trim($pass2);
            if($pass1 && $pass2){
                $hashedPass1 = sha1($pass1);
                $hashedPass2 = sha1($pass2);
                if($hashedPass1 !== $hashedPass2){
                    $err = "This <strong>Passwords</strong> Doesn't Match";
                    $this->addError($err);
                }
            }else{
                $err = "This <strong>Password</strong> Cannot Be Empty !!";
                $this->addError($err);
            }
        }

        public function addError($msg){
            array_push($this->errors, $msg);
        }


    }
?>