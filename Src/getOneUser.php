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


$get_one_user = new User($db);

$uri = parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);
$uri = explode('/',$uri);

$user_id = (int) $uri[4];

if($user_id !=0){
    $user = $get_one_user->getOneUser($user_id);

    if ($user->num_rows == 1) {
    $user_details = $user->fetch_assoc();
    $user_data = array(
        'id' => $user_details['id'],
        'username' => $user_details['username'],
        'email' => $user_details['email'],
        'fullname' => $user_details['fullname'],
        'address' => $user_details['address'],
        'phone_number' => $user_details['phone_number'],
        'profile_pic' => $user_details['profile_pic']
    );

    http_response_code(200);
    echo json_encode($user_data);
} else {
    http_response_code(404);
    echo json_encode(
        array("message" => "No Users with user id " . $user_id)
    );
}
}else{
    http_response_code(400);
    echo json_encode(
        array("message" => "Invalid User Id " . $uri[4])
    );
}
