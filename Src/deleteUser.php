<?php

header("Access-Control-Allow-Origin:  *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Content-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: COntent-Type, Access-Control-Allow-Headers,Authorization, X-Requested-With");


include_once '../config/connect.php';
include_once '../Classes/Users.php';


$database = new Database();


$db = $database->connectDB();



$user_to_delete = new User($db);

$data = json_decode(file_get_contents("php://input"));

if(!empty($data->id)){
    $user_to_delete->id = $data->id;

    if($user_to_delete->deleteUser()){
        http_response_code(201);
        echo json_encode(array("Message"=>"User with id " . $data->id . " deleted successfully"));
    }else{
        http_response_code(503);
        echo json_encode(array("Message"=>"Deletion Failed"));
    }
}else{
    http_response_code(400);
    echo json_encode(array("Message"=>"Invalid User Id"));
}


?>