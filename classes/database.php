<?php
class Database{
    public function connect(){
        $conn = mysqli_connect("localhost","root","","crm2");
        return $conn;
    }
}