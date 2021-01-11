<?php 

class Image{
    private $data;
    public $errors = [];

    public function validateImage($image, $name){

        $validTypes = array('peng', 'png', 'jpg', 'gif');
        $sizeAllowed = 1024 * 1024 * 2; // 2 MB

        echo "<pre>";
        print_r($image);
        echo "</pre>";

        if(isset($image)){

            $imageName = $image['name'];
            $explodeType = explode(".", $image['name']);
            $type = end($explodeType);
            $size = $image['size'];

            echo '<br />Name : ' . $imageName;
            echo '<br />Type : ' . $type;
            echo '<br />Size : ' . $size;
            echo '<br />Tmp_namp: '. $image['tmp_name'] . '<br />';

            // GET THE IMAGE DIMENSIONS
            echo "<pre>";
            print_r(@getimagesize($image['tmp_name']));
            echo "<Pre>";
            

            if(in_array($type, $validTypes)){

                if(!($size < $sizeAllowed)){
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