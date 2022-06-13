<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: multipart/form-data');
header('Access-Control-Allow-methods: POST');
header('Access-Contol-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');



include_once '../config/connect.php';
include_once '../Classes/Users.php';

$database =new Database();
$db = $database->connectDB();

$new_profile = new User($db);

$profile_pic = $_FILES['profile_pic']['name'];
$pp_temp_name = $_FILES['profile_pic']['tmp_name'];
$pp_size = $_FILES['profile_pic']['size'];
$pp_type = $_FILES['profile_pic']['type'];

if(!empty($_POST['id']) && !empty($profile_pic)){
    
    $new_profile->id = $_POST["id"];
    $new_profile->profile_pic = $profile_pic;
    $new_profile->pp_temp_name = $pp_temp_name;
    $new_profile->pp_size = $pp_size;
    $new_profile->pp_type = $pp_type;

    if($new_profile->changeProfile()){
        http_response_code(201);
        echo json_encode(array("message"=>"Profile Picture Updated Successfully"));
    }else{
        http_response_code(501);
        echo json_encode(array("message"=>"Something wrong happened"));
    }
}else{
    http_response_code(400);
    echo json_encode(array("message"=>"All fields Required"));
}



?>