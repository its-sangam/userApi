<?php

header("Access-Control-Allow-Origin:  *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Content-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: COntent-Type, Access-Control-Allow-Headers,Authorization, X-Requested-With");


include_once '../config/connect.php';
include_once '../Classes/Users.php';


$database = new Database();


$db = $database->connectDB();



$user_to_delete = new User($db);

$uri = parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);
$uri = explode('/',$uri);

$user_id = (int) $uri[4];

if($user_id != 0){

    $user_to_delete->id = $user_id;

    if($user_to_delete->deleteUser()){
        http_response_code(201);
        echo json_encode(array("Message"=>"User with id " . $user_id . " deleted successfully"));
    }else{
        http_response_code(503);
        echo json_encode(array("Message"=>"Deletion Failed"));
    }
}else{
    http_response_code(400);
    echo json_encode(array("Message"=>"Invalid User Id"));
}


?>