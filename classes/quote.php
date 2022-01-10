<?php
require_once('database.php');
class Quote extends Database{
    public $id=0,$name="",$email="",$contact="",$company="",$webDesign=0,$cms=0,$seo=0,$smo=0,$staticWeb=0,$dynamicWeb=0,$flashWeb=0,$domainReg=0,$webHosting=0,$webMaintenance=0,$ecomm=0,$animation=0,$payment=0,$logo=0,$dashboard=0,$openSource=0,$newsLetter=0,$other=0,$query="",$remark,$postDate,$status;

    public function add(){
        $conn = $this->connect();
        $SQL = "INSERT INTO QUOTES (quote_name,quote_email,quote_contact,quote_company,webDesign,cms,seo,smo,staticWeb,dynamicWeb,flashWeb,domainReg,webHosting,webMaintenance,ecomm,animation,payment,logo,dashboard,openSource,newsLetter,other,query,post_date) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $conn->prepare($SQL);
        if(!$stmt){ 
            echo mysqli_error($conn);
            return false;
        }else{
            $stmt->bind_param("ssssssssssssssssssssssss",$this->name,$this->email,$this->contact,$this->company,$this->webDesign,$this->cms,$this->seo,$this->smo,$this->staticWeb,$this->dynamicWeb,$this->flashWeb,$this->domainReg,$this->webHosting,$this->webMaintenance,$this->ecomm,$this->animation,$this->payment,$this->logo,$this->dashboard,$this->openSource,$this->newsLetter,$this->other,$this->query,$this->postDate);
            if($stmt->execute()){
                $SQL = "SELECT * FROM QUOTES ORDER BY quote_id DESC LIMIT 1";
                $stmt = $conn->prepare($SQL);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_array();
                $this->id = $row['quote_id'];
                return true;
            }else{
                echo mysqli_error($conn);
                return false;
            }
        }
    }

    public static function getQuotes(){
        $instance = new self();
        $conn = $instance->connect();   
        $SQL = "SELECT * FROM QUOTES";
        $stmt = $conn->prepare($SQL);
        if(!$stmt){
            return false;
        }else{
            if($stmt->execute()){
                $result = $stmt->get_result();
                if($result && $result->num_rows>0){
                    $json = array();
                    while($row=$result->fetch_array()){
                        $json[]=array(
                            "id"=>$row['quote_id'],
                            "name"=>$row['quote_name'],
                            "email"=>$row['quote_email'],
                            "contact"=>$row['quote_contact'],
                            "status"=>$row['status']
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

    public static function fromID($id){
        $instance =  new self();
        $conn = $instance->connect();
        $SQL = "SELECT * FROM QUOTES WHERE quote_id=?";
        $stmt = $conn->prepare($SQL);
        if(!$stmt){
            return false;
        }else{
            $stmt->bind_param("s",$id);
            if($stmt->execute()){
                $result = $stmt->get_result();
                if($result->num_rows>0){
                    $row = $result->fetch_array();
                    // public $id=0,$name="",$email="",$contact="",$company="",$webDesign=0,$cms=0,$seo=0,$smo=0,$staticWeb=0,$dynamicWeb=0,$flashWeb=0,$domainReg=0,$webHosting=0,$webMaintenance=0,$ecomm=0,$animation=0,$payment=0,$logo=0,$dashboard=0,$openSource=0,$newsLetter=0,$other=0;
                    $instance->id = $row['quote_id'];
                    $instance->name = $row['quote_name'];
                    $instance->email = $row['quote_email'];
                    $instance->contact=$row['quote_contact'];
                    $instance->query=$row['query'];
                    $instance->remark=$row['remark'];
                    return $instance;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }
    }

    public function update(){
        $conn = $this->connect();
        $SQL = "UPDATE QUOTES SET quote_name=?,quote_email=?,quote_contact=?,quote_company=?,query=?,remark=?,status=? WHERE quote_id=?";
        $stmt = $conn->prepare($SQL);
        $stmt->bind_param("ssssssss",$this->name,$this->email,$this->contact,$this->company,$this->query,$this->remark,$this->status,$this->id);
        return $stmt->execute();
    }
}