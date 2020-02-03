<?php 
header('Content-Type: application/json');
$uploaded = array();
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__));
$coreRoot = str_replace('core','',ROOT);

// loading configurations and helper funcations

//require_once(ROOT . DS . 'config' . DS . 'config.php');

$result = "No File to upload";

if(!empty($_FILES['file']['name'])){
    $name =  $_FILES['file']['name'];
    $tmp_name = $_FILES['file']['tmp_name'];
    $username = $_POST['username'];
    $dir = $coreRoot .'app\data\current_temp\\'. $username. DS;
    if(!file_exists($dir)){
        mkdir($dir, 0777, true);
    }
    $uploadLocation = $dir . $name;
    if(move_uploaded_file($tmp_name, $uploadLocation)){
        $result = $name . ' Uploaded!!';
    }
}

echo json_encode($result);






// class Upload {
//     public $images = [];
//     public $username, $good_id;

//     public function __construct($username, $good_id,  $images = []){
//         $this->username = $username;
//         $this->good_id = $good_id;
//         $this->initialize();
//     }

//     private function initialize(){
//         $target_dir = SROOT . "app/data/temp";
//         $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
//         $uploadOk = 1;
//         $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
//         // Check if image file is a actual image or fake image
//         if(isset($_POST["submit"])) {
//             $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
//             if($check !== false) {
//                 echo "File is an image - " . $check["mime"] . ".";
//                 $uploadOk = 1;
//             } else {
//                 echo "File is not an image.";
//                 $uploadOk = 0;
//     }
// }
//     }

//     protected function createDirectory(){
//         //
//     }

//     protected function _setGoodImages(){
//         //
//     }

//     public function getGoodImages(){
//         //
//     }

//     public function changeOrder(){
//         // User can set image display order
//     }
   
// }
