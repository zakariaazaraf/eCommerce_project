<?php 

class Image {
    
    private $data;
    public $errors = [];

    public function validateImage($image, $name){

        $validTypes = array('peng', 'png', 'jpg', 'gif');
        $sizeAllowed = 1024 * 1024 * 2; // 2 MB

        if(file_exists($image['tmp_name'])){ // VERIFY THE EXISTENT OF THE PAGE

            $imageName = $image['name'];
            $explodeType = explode(".", $image['name']);
            $type = end($explodeType);
            $size = $image['size'];

            /* // GET THE IMAGE DIMENSIONS
            echo "<pre>";
            print_r(@getimagesize($image['tmp_name']));
            echo "<Pre>"; */
            

            if(in_array($type, $validTypes)){ // VERIFY THE IMAGE TYPE

                if(!($size < $sizeAllowed)){ // VERIFY THE IMAGE SIZE WHICH IS 2 MB
                    $msg = "The <strong>$name</strong> Is Much More Then 2 Mb";
                    $this->addError($msg);
                    echo $msg;
                }

            }else{
                $msg = "The <strong>$name</strong> Types Denied, Try ";
                foreach($validTypes as $valid){ $msg .= "<strong>$valid</strong> "; }
                echo $msg .= 'Types';
                $this->addError($msg);
                
            }

        }else{
            $msg = "The <strong>$name</strong> Can't Be Empty";
            $this->addError($msg);
            echo $msg;
        }
    
    }

    private function addError($msg){
        array_push($this->errors, $msg);
    }
}

?>