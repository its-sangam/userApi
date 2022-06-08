<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once '../config/connect.php';
include_once '../Classes/Users.php';

$database = new Database();

$db = $database->connectDB();


$get_all_users = new User($db);

$all_users = $get_all_users->getAllUsers();

$users_count = $all_users->num_rows;

echo json_encode($users_count);
if($users_count > 0){
    
    $users = array();
    $users["body"] = array();
    $users["user_count"] = $users_count;
    while ($row = $all_users->fetch_assoc()){
        extract($row);
        $new_user = array(
            "id" => $id,
            "username" => $username,
            "email" => $email,
            "fullname" => $fullname,
            "address" => $address,
            "phone_number" =>$phone_number
        );
        array_push($users["body"],$new_user);
    }
    echo json_encode($users);
}
else{
    http_response_code(404);
    echo json_encode(
        array("message" => "No record found.")
    );
}
