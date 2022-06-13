<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: multipart/form-data; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once '../config/connect.php';
include_once '../Classes/Users.php';

$database = new Database();

$db = $database->connectDB();


$new_user = new User($db);

$profile_pic = $_FILES['profile_pic']['name'];
$file_size = $_FILES['profile_pic']['size'];
$file_temp_name = $_FILES['profile_pic']['tmp_name'];
$file_type = $_FILES['profile_pic']['type'];

if(!empty($_POST["username"])&& !empty($_POST["email"])&& !empty($_POST["password"])&& !empty($_POST["fullname"])&& !empty($profile_pic)){

    $new_user->username = $_POST['username'];
    $new_user->email = $_POST['email'];
    $new_user->password = $_POST['password'];
    $new_user->fullname = $_POST['fullname'];
    $new_user->profile_pic = $profile_pic;
    $new_user->file_size = $file_size;
    $new_user->file_temp_name = $file_temp_name;
    $new_user->file_type = $file_type;
    if(!empty($_POST['address'])){
        $new_user->address = $_POST['address'];
    }
    if(!empty($_POST['phone_number'])){
       $new_user->phone_number = $_POST['phone_number'];
    }

    if($new_user->createUser()){
        http_response_code(201);
        echo json_encode(array("message"=>"User Registered Successfully!"));
    }else{
        http_response_code(503);
        echo json_encode(array("message"=>"Registration Error"));
    }
}else{
    http_response_code(400);
    echo json_encode(array("message"=>"Incomplete Credentials"));
}

