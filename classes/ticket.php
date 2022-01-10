<?php
require_once('database.php');

class Ticket extends Database {
    public $id,$title="",$task,$prio,$description,$adminRemark="",$adminRemarkDate="",$attachment="",$postDate,$status="",$email="";

    public function add(){
        $conn = $this->connect();
        $SQL = "INSERT INTO TICKETS (ticket_title,ticket_task,ticket_priority,ticket_description,ticket_admin_remark,ticket_admin_remark_date,ticket_attachment,ticket_post_date,ticket_status,ticket_email) VALUES (?,?,?,?,?,?,?,?,?,?)";
        $stmt = $conn->prepare($SQL);
        if(!$stmt){ 
            // echo mysqli_error($conn);
            return false;
        }else{
            $this->postDate = date('Y-m-d H:i:s');
            // echo $this->postDate;
            $stmt->bind_param("ssssssssss",$this->title,$this->task,$this->prio,$this->description,$this->adminRemark,$this->adminRemarkDate,$this->attachment,$this->postDate,$this->status,$this->email);
            if($stmt->execute()){
                $SQL = "SELECT * FROM TICKETS ORDER BY ticket_id DESC LIMIT 1";
                $stmt = $conn->prepare($SQL);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_array();
                $this->id = $row['ticket_id'];
                return true;
            }else{
                // echo mysqli_error($conn);
                return false;
            }
        }

    }

    public static function getTickets($email){
        $SQL = "SELECT * FROM TICKETS WHERE ticket_email=?";
        $instance =  new self();
        $conn = $instance->connect();
        $stmt= $conn->prepare($SQL);
        if(!$stmt){
            return false;
        }else{
            $stmt->bind_param("s",$email);
            if($stmt->execute()){
                $result = $stmt->get_result();
                if(!$result){
                    return false;
                }else{
                    $i=1;
                    $json=array();
                    while($row=$result->fetch_array()){
                        $json[]=array(
                            "id"=>$row['ticket_id'],
                            "title" =>$row['ticket_title'],
                            "description" =>$row['ticket_description'],
                            "postDate" =>$row['ticket_post_date']
                        );
                    }
                    return $json;
                }
            }else{
                return false;
            }
        }
    }

    public static function getAllTickets(){
        $SQL = "SELECT * FROM TICKETS";
        $instance =  new self();
        $conn = $instance->connect();
        $stmt= $conn->prepare($SQL);
        if(!$stmt){
            return false;
        }else{
            if($stmt->execute()){
                $result = $stmt->get_result();
                if(!$result){
                    return false;
                }else{
                    $json = array();
                    while($row=$result->fetch_array()){
                        $json[]=array(
                            "id"=>$row['ticket_id'],
                            "title"=>$row['ticket_title'],
                            "description"=>$row['ticket_description'],
                            "postDate"=>$row['ticket_post_date'],
                            "status"=>$row['ticket_status']
                        );
                    }
                    return $json;
                }
            }else{
                return false;
            }
        }
    }

    public static function fromID($id){
        $instance = new self();
        $conn = $instance->connect();
        $SQL = "SELECT * FROM TICKETS WHERE ticket_id=?";
        $stmt = $conn->prepare($SQL);
        if(!$stmt){
            return false;
        }else{
            $stmt->bind_param("s",$id);
            if($stmt->execute()){
                $result = $stmt->get_result();
                if(!$result || $result->num_rows<=0){
                    return false;
                }else{
                    $row=$result->fetch_array();
                    $instance->id = $row['ticket_id'];
                    $instance->title = $row['ticket_title'];
                    $instance->task = $row['ticket_task'];
                    $instance->prio = $row['ticket_priority'];
                    $instance->description = $row['ticket_description'];
                    $instance->adminRemark = $row['ticket_admin_remark'];
                    $instance->adminRemarkDate = $row['ticket_admin_remark_date'];
                    $instance->attachment = $row['ticket_attachment'];
                    $instance->postDate = $row['ticket_post_date'];
                    $instance->status = $row['ticket_status'];
                    $instance->email = $row['ticket_email'];
                    return $instance;
                }
            }else{
                return false;
            }
        }
    }

    public function addRemark(){
        $conn = $this->connect();
        $SQL = "UPDATE TICKETS SET ticket_admin_remark=?,ticket_admin_remark_date=?,ticket_status=? WHERE ticket_id=?";
        $stmt = $conn->prepare($SQL);
        if(!$stmt){
            return false;
        }else{
            $this->adminRemarkDate = date('YYYY-m-d h:i:s');
            $this->status = 'CLOSED';
            $stmt->bind_param("ssss",$this->adminRemark,$this->adminRemarkDate,$this->status,$this->id);
            if($stmt->execute()){
                return true;
            }else{
                return false;
            }
        }
    }
}