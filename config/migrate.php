<?php

require_once 'connect.php';

$db = new Database();

$conn = $db->connectDB();



$CREATE_USERS = "CREATE TABLE USERS(id INT PRIMARY KEY AUTO_INCREMENT, username VARCHAR(50) NOT NULL, email VARCHAR(50) NOT NULL, password VARCHAR(100) NOT NULL, fullname VARCHAR(100) NOT NULL, phone_number VARCHAR(20), address VARCHAR(100))";

if($conn->query($CREATE_USERS)===true){
    echo "Table Users Created Successfully";
}else{
    echo "Error Creating Table Users:" . $conn->error;
}



?>