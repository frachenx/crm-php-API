<?php
require_once('database.php');

class User extends Database{
    public $id, $address="", $email="",$altEmail="", $gender="", $contact="", $name="", $password="",$createdDate;

    public function __construct(){ 
    }

    public static function login($email,$password){
        $instance =  new self();
        $conn = $instance->connect();
        $SQL = "SELECT * FROM USERS WHERE user_email=?";
        $stmt = $conn->prepare($SQL);
        if(!$stmt){
            return false;
        }else{
            $stmt->bind_param("s",$email);
            if($stmt->execute()){
                $result = $stmt->get_result();
                if($result == null || $result->num_rows==0){
                   return false; 
                }else{
                    $row = $result->fetch_array();
                    if($row==null){
                        return false;
                    }else{
                        if(password_verify($password,$row['user_password'])){
                            return $row['user_id'];
                        }else{
                            return false;
                        }
                    }
                }
            }else{
                return false;
            }
        }

    }

    public function register(){
        $conn = $this->connect();
        $SQL = "INSERT INTO USERS (user_address,user_email,user_alt_email,user_gender,user_contact,user_name,user_password,user_created_date) VALUES(?,?,?,?,?,?,?,?)";
        $stmt = $conn->prepare($SQL);
        if(!$stmt){
            return false;
        }else{
            $date =  date('Y-m-d h:i:s');
            $stmt->bind_param("ssssssss",$this->address,$this->email,$this->altEmail,$this->gender,$this->contact,$this->name,$this->password,$date);
            if($stmt->execute()){
                $SQL = "SELECT user_id FROM USERS ORDER BY user_id DESC LIMIT 1";
                $stmt = $conn->prepare($SQL);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_array();
                $this->id = $row['user_id'];
                return true;
            }else{
                return false;
            }
        }
    }

    public static function fromID($id){
        $instance = new self();
        $SQL = "SELECT * FROM USERS WHERE user_id=?";
        $conn = $instance->connect();

        $stmt = $conn->prepare($SQL);
        if(!$stmt){
            return false;
        }else{
            $stmt->bind_param("s",$id);
            if($stmt->execute()){
                $result = $stmt->get_result();
                if($result==null){
                    return false;
                }else{
                    if($result->num_rows ==0 ){
                        return false;
                    }else{
                        $row = $result->fetch_array();
                        if($row==null){
                            return false;
                        }else{
                            // public $id, $address="", $email="",$altEmail="", $gender="", $contact="", $name="", $password="";
                            $instance->id = $row['user_id'];
                            $instance->address = $row['user_address'];
                            $instance->email = $row['user_email'];
                            $instance->altEmail = $row['user_alt_email'];
                            $instance->gender = $row['user_gender'];
                            $instance->contact = $row['user_contact'];
                            $instance->name = $row['user_name'];
                            $instance->password = $row['user_password'];
                            $instance->createdDate = $row['user_created_date'];
                            return $instance;
                        }
                    }
                }
            }else{
                return false;
            }
        }
    }

    public function changePassword($password){
        $conn = $this->connect();
        $SQL = "UPDATE USERS SET user_password=? WHERE user_id=?";
        $stmt = $conn->prepare($SQL);
        if(!$stmt){
            return false;
        }else{
            $stmt->bind_param("ss",$password,$this->id);
            return $stmt->execute();
        }
    }

    public function update(){
        $conn =  $this->connect();
        $SQL="UPDATE USERS SET user_address=?, user_email=?,user_alt_email=?,user_gender=?,user_contact=?,user_name=? WHERE user_id=?";
        $stmt = $conn->prepare($SQL);
        if(!$stmt){
            return false;
        }else{
            $stmt->bind_param("sssssss",$this->address,$this->email,$this->altEmail,$this->gender,$this->contact,$this->name,$this->id);
            return $stmt->execute();
        }
    }

    public static function getUsers(){
        $instance = new self();
        $conn = $instance->connect();
        $SQL = "SELECT * FROM USERS ";
        $stmt = $conn->prepare($SQL);
        if(!$stmt){
            return false;
        }else{
            if($stmt->execute()){
                $result = $stmt->get_result();
                if($result && $result->num_rows>0){
                    $json =array();
                    while($row=$result->fetch_array()){
                        $json[]=array(
                            "id"=>$row['user_id'],
                            "name"=>$row['user_name'],
                            "email"=>$row['user_email'],
                            "contact"=>$row['user_contact'],
                            "createdDate"=>$row['user_created_date'],
                        );
                    }
                    return $json;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }
    }

    public static function deleteFromID($id){
        $instance = new self();
        $SQL = "DELETE FROM USERS WHERE user_id=?";
        $conn = $instance->connect();
        $stmt = $conn->prepare($SQL);
        if($stmt){
            $stmt->bind_param("s",$id);
            if($stmt->execute()){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
}
