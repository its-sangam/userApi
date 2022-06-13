<?php

class User
{

    private $table_name = "user_profile";
    private $conn;
    private $upload_path = '../assets/profile_pics/';



    public function __construct($db)
    {
        $this->conn = $db;
    }



    public function createUser()
    {
        if ($this->validateUser()) {


            $query = "INSERT INTO " . $this->table_name . "(username, email,password,fullname,phone_number,address,profile_pic) VALUES (?,?,?,?,?,?,?)";

            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("sssssss", $this->username, $this->email, $this->password, $this->fullname, $this->phone_number, $this->address, $this->profile_pic);
            $this->username = htmlspecialchars(strip_tags($this->username));
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->password = hash("md4", htmlspecialchars(strip_tags($this->password)));
            $this->fullname = htmlspecialchars(strip_tags($this->fullname));
            $this->address = htmlspecialchars(strip_tags($this->address));
            $this->phone_number = htmlspecialchars(strip_tags($this->phone_number));
            $this->profile_pic = htmlspecialchars(strip_tags($this->profile_pic));



            if ($stmt->execute()) {
                move_uploaded_file($this->file_temp_name, $this->upload_path . $this->profile_pic);
                return true;
            }
        }

        return false;
    }

    public function getAllUsers()
    {

        $query = "SELECT id,username,email,fullname,address,phone_number,profile_pic FROM " . $this->table_name . "";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $all_users = $stmt->get_result();
        return $all_users;
    }

    public function getOneUser($id)
    {

        $query = "SELECT id,username,email,fullname,address,phone_number, profile_pic FROM " . $this->table_name . " WHERE id=" . $id . "";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $one_user = $stmt->get_result();
        return $one_user;
    }

    public function updateUser()
    {
        $query_check = "SELECT id FROM " . $this->table_name . " WHERE id = ?";

        $stmt_check = $this->conn->prepare($query_check);

        $stmt_check->bind_param("i", $this->id);

        $this->id = htmlspecialchars(strip_tags($this->id));
        if ($stmt_check->execute()) {
            if ($stmt_check->get_result()->num_rows == 1) {
                // if ($this->validateUser()) {
                $query = "UPDATE " . $this->table_name . " SET username = ? , email = ?, fullname = ?, phone_number = ? , address = ? WHERE id = ?";

                $stmt = $this->conn->prepare($query);


                $stmt->bind_param("sssssi", $this->username, $this->email, $this->fullname, $this->phone_number, $this->address, $this->id);

                $this->username = htmlspecialchars(strip_tags($this->username));
                $this->email = htmlspecialchars(strip_tags($this->email));
                $this->fullname = htmlspecialchars(strip_tags($this->fullname));
                $this->address = htmlspecialchars(strip_tags($this->address));
                $this->phone_number = htmlspecialchars(strip_tags($this->phone_number));

                if ($stmt->execute()) {
                    return true;
                }

                return false;
                // }
            }
        } else {
            return false;
        }
    }


    public function deleteUser()
    {
        $query_check = "SELECT id,profile_pic FROM " . $this->table_name . " WHERE id = ?";

        $stmt_check = $this->conn->prepare($query_check);

        $stmt_check->bind_param("i", $this->id);

        $this->id = htmlspecialchars(strip_tags($this->id));

        if ($stmt_check->execute()) {
            $get_profile_pic = $stmt_check->get_result()->fetch_assoc();

            $query = "DELETE from " . $this->table_name . " WHERE id = ?";

            $stmt = $this->conn->prepare($query);

            $stmt->bind_param("i", $this->id);

            $this->id = htmlspecialchars(strip_tags($this->id));

            if ($stmt->execute()) {
                unlink($this->upload_path . $get_profile_pic['profile_pic']);
                return true;
            }

            return false;
        } else {
            return false;
        }
    }


    public function validateUser()
    {
        $errorCount = 0;

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $errorCount++;
        }

        if (!preg_match('/^[0-9]{10}+$/', $this->phone_number)) {
            $errorCount++;
        }

        if (($this->file_type != 'jpeg' || $this->file_type != 'jpg' || $this->file_type != 'png') && ($this->file_size > 5000000)) {
            $errorCount++;
        }

        if ($errorCount == 0) {
            return true;
        }

        return false;
    }

    public function changePassword()
    {
        $query_check_old_password = "SELECT password from " . $this->table_name . " WHERE id = ?";

        $stmt = $this->conn->prepare($query_check_old_password);

        $stmt->bind_param("i", $this->id);

        $this->id = htmlspecialchars(strip_tags($this->id));

        if ($stmt->execute()) {
            $get_old_password = $stmt->get_result();
            $old_password_from_db = $get_old_password->fetch_assoc();
            $this->old_password = hash("md4", htmlspecialchars(strip_tags($this->old_password)));
            if ($this->old_password == $old_password_from_db['password']) {
                $sql_update_password = "UPDATE " . $this->table_name . " SET password = ? WHERE id = ?";

                $stmt_change_password = $this->conn->prepare($sql_update_password);

                echo $this->conn->error;

                $stmt_change_password->bind_param('si', $this->new_password, $this->id,);

                $this->new_password = hash("md4", htmlspecialchars(strip_tags($this->new_password)));
                $this->id = htmlspecialchars(strip_tags($this->id));

                if ($stmt_change_password->execute()) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


    public function changeProfile()
    {
        $sql_get_old_profile_pic = "SELECT profile_pic FROM " . $this->table_name . " WHERE id=? ";
        $sql_update_profile_pic = "UPDATE " . $this->table_name . " SET profile_pic = ? WHERE id=? ";

        $stmt_get_pp = $this->conn->prepare($sql_get_old_profile_pic);
        $stmt = $this->conn->prepare($sql_update_profile_pic);

        $stmt_get_pp->bind_param('i', $this->id);
        $this->id = htmlspecialchars(strip_tags($this->id));

        if ($stmt_get_pp->execute()) {
            $get_old_pp = $stmt_get_pp->get_result()->fetch_assoc();
            $old_pp = $get_old_pp['profile_pic'];
            $stmt->bind_param('si', $this->profile_pic, $this->id);
            $this->profile_pic = htmlspecialchars(strip_tags($this->profile_pic));
            if ($stmt->execute()) {
                if (!file_exists($this->upload_path . $this->profile_pic)) {
                    unlink($this->upload_path . $old_pp);
                    move_uploaded_file($this->pp_temp_name, $this->upload_path . $this->profile_pic);
                } else {
                    move_uploaded_file($this->pp_temp_name, $this->upload_path . $this->profile_pic);
                }
                return true;
            } else {
                return false;
            }
        }
    }
}
