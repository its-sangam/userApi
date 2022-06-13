<?php


include_once '../config/connect.php';
include_once '../Classes/Users.php';

$database = new Database;

$db = $database->connectDB();

$user = new User($db);

$input = json_decode(file_get_contents('php://input'));


if (!empty($input->old_password) && !empty($input->new_password) && !empty($input->confirm_password)) {
    if ($input->new_password === $input->confirm_password) {
        $user->id = $input->id;
        $user->old_password = $input->old_password;
        $user->new_password = $input->new_password;

        if ($user->changePassword()) {
            http_response_code(200);
            echo json_encode(array("message" => "Password Changed Successfully"));
        }
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "Passwords Do not match"));
    }
}
