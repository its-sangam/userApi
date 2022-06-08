<?php

class User
{

    private $tablename="users";
    private $conn;


    public function __construct($db){
        $this->conn = $db;
    }


    public function createUser(){
        
        $query = "INSERT INTO ". $this->tablename ."(username, email,password,fullname,phone_number,address) VALUES (?,?,?,?,?,?)";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssss",$this->username,$this->email,$this->password,$this->fullname,$this->phone_number,$this->address);
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->fullname = htmlspecialchars(strip_tags($this->fullname));
        $this->address = htmlspecialchars(strip_tags($this->address));
        $this->phone_number = htmlspecialchars(strip_tags($this->phone_number));


        if($stmt->execute()){
            return true;
        }

        return false;



    }
    public function getAllUsers(){
        
        $query = "SELECT id,username,email,fullname,address,phone_number FROM " . $this->tablename . "";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $all_users = $stmt->get_result();
        return $all_users;


    }

    public function getOneUser($id){
        
        $query = "SELECT id,username,email,fullname,address,phone_number FROM " . $this->tablename . " WHERE id=".$id."";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $one_user = $stmt->get_result();
        return $one_user;
        


    }

    public function updateUser(){
        $query = "UPDATE " . $this->tablename . " SET username = ? , email = ?, password = ?, fullname = ?, phone_number = ? , address = ? WHERE id = ?";

        $stmt = $this->conn->prepare($query);
        
        
        $stmt->bind_param("ssssssi",$this->username,$this->email, $this->password,$this->fullname,$this->phone_number,$this->address,$this->id);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = hash("md4",htmlspecialchars(strip_tags($this->password)));
        $this->fullname = htmlspecialchars(strip_tags($this->fullname));
        $this->address = htmlspecialchars(strip_tags($this->address));
        $this->phone_number = htmlspecialchars(strip_tags($this->phone_number));

        if($stmt->execute()){
            return true;
        }

        return false;


    }


    public function deleteUser(){
        
        $query = "DELETE from " . $this->tablename . " WHERE id = ?";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("i",$this->id);

        $this->id = htmlspecialchars(strip_tags($this->id));

        if($stmt->execute()){
            return true;
        }

        return false;

    }
}
