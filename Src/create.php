<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once '../config/connect.php';
include_once '../Classes/Users.php';

$database = new Database();

$db = $database->connectDB();


$new_user = new User($db);

$data = json_decode(file_get_contents("php://input"));


if(!empty($data->username) && !empty($data->email) &&
!empty($data->password) && !empty($data->fullname)){

    $new_user->username = $data->username;
    $new_user->email = $data->email;
    $new_user->password = $data->password;
    $new_user->fullname = $data->fullname;
    if(!empty($data->address)){
        $new_user->address = $data->address;
    }
    if(!empty($user->phone_number)){
       $new_user->phone_number = $data->phone_number;
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

