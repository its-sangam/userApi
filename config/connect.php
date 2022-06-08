<?php

class Database{

private $server = "localhost";
private $username ="root";
private $password = "";
private $database = "firstapi";

public $conn;


public function connectDB(){

    $this->conn = null;
    
    $this->conn = new mysqli($this->server,$this->username,$this->password,$this->database);

    if($this->conn->connect_error){
        die ("Connection Error!". $this->conn->error);
    }
        return $this->conn;

}


}
