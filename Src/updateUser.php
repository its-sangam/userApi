<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers,Authorization,X-Requested-With");

include_once '../config/connect.php';
include_once '../Classes/Users.php';

$database = new Database();

$db = $database->connectDB();


$user_to_update = new User($db);

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id)) {
    if (!empty($data->username) && !empty($data->email) && !empty($data->password) && !empty($data->fullname)) {
        $user_to_update->id = $data->id;
        $user_to_update->username = $data->username;
        $user_to_update->email = $data->email;
        $user_to_update->password = $data->password;
        $user_to_update->fullname = $data->fullname;
        if (!empty($data->address)) {
            $user_to_update->address = $data->address;
        }
        if (!empty($user->phone_number)) {
            $user_to_update->phone_number = $data->phone_number;
        }

        if($user_to_update->updateUser()){
            http_response_code(201);
            echo json_encode(array("message"=>"User with id " . $data->id . " updated successfully!!"));
        }else{
            http_response_code(503);
            echo json_encode(array("message"=>"Unable to Update User"));
        }
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "Incomplete Credentials"));
    }
} else {
    http_response_code(404);
    echo json_encode(array("message" => "User with id " . $data->id . " not found"));
}
