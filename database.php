<?php

class database{

    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $db_name = "oops";

    private $conn = false;
    private $mysqli = "";
    private $result = array();

    public function __construct(){
        if(!$this->conn){
            $this->mysqli = new mysqli($this->host, $this->user, $this->pass, $this->db_name);

            if($this->mysqli->connect_error){
                array_push($this->result, $this->mysqli->connect_error);
                return false;
            }
            else{
                $this->conn = true;
                return true;
            }
        }
        else{
            return false;
        }
    }

    public function get_result(){
        $val = array_values($this->result);
        $this->result = array();
        return $val;
    }

    public function insert($table, array $params){
        if($this->table_exists($table)){
            $table_attributes = implode(",", array_keys($params));
            $inserted_values = implode("','", $params);

            $sql = "INSERT INTO $table($table_attributes) VALUES ('$inserted_values')";
            if($this->mysqli->query($sql)){
                array_push($this->result, "Data has been inserted successfully");
            }
            else{
                array_push($this->result, $this->mysqli->error);
            }
        }
        else{
            array_push($this->result, $table . " is not an existing table in the database named " . $this->db_name);
        }
    }

    public function update($table, array $params, $where = null){
        if($this->table_exists($table)){
            $args = array();
            foreach($params as $key => $value){
                $args[] = "$key = '$value'";
            }

            $where != NULL ? $sql = "UPDATE $table SET " . implode(", ", $args) . " WHERE $where" : $sql = "UPDATE $table SET" . implode(", ", $args);
            
            if($this->mysqli->query($sql)){
                array_push($this->result, "Data has been updated successfully");
            }
            else{
                array_push($this->result, $this->mysqli->error);
            }
        }
        else{
            array_push($this->result, $table . " is not an existing table in the database named " . $this->db_name);
        }
    }

    public function delete($table, $where = null){
        if($this->table_exists($table)){
            $where != NULL ? $sql = "DELETE FROM $table WHERE $where" : $sql = "DELETE FROM $table";

            if($this->mysqli->query($sql)){
                array_push($this->result, "Data has been deleted successfully");
            }
            else{
                array_push($this->result, $this->mysqli->error);
            }
        }
        else{
            array_push($this->result, $table . " is not an existing table in the database named " . $this->db_name);
        }
    }

    public function select($table, $row = "*", $join = null, $where = null, $order = null, $limit = null){
        if($this->table_exists($table)){
            $sql = "SELECT $row FROM $table";
            if($join != NULL){
                $sql .= " JOIN $join";
            }
            if($where != NULL){
                $sql .= " WHERE $where";
            }
            if($order != NULL){
                $sql .= " ORDER BY $order";
            }
            if($limit != NULL){
                $sql .= " LIMIT 0, $limit";
            }

            $query = $this->mysqli->query($sql);

            if($query){
                print_r($query->fetch_all(MYSQLI_ASSOC));
            }
            else{
                array_push($this->result, $this->mysqli->error);
            }
        }
        else{
            array_push($this->result, $table . " is not an existing table in the database named " . $this->db_name);
        }
    }

    private function table_exists($table){
        $sql = "SHOW TABLES FROM $this->db_name LIKE '$table'";
        $query = $this->mysqli->query($sql);
        if($query->num_rows == 1){
            return true;
        }
        else{
            return false;
        }
    }

    public function __destruct(){
        if($this->conn){
            if($this->mysqli->close()){
                $this->conn = false;
                return true;
            }
        }
        else{
            return false;
        }
    }
}


?>