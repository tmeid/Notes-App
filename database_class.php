<?php

class database{
    protected $connection = null;
    protected $table_name = '';
    protected $limit = 10;
    protected $offset = 0;
    public $record = [
        'title' => '',
        'content' => ''
    ];


    protected $host = '';
    protected $user = '';
    protected $pass = '';
    protected $db = '';

    public function __construct($config){
        $this->host = $config['host'];
        $this->user = $config['user'];
        $this->pass = $config['pass'];
        $this->db = $config['db'];

        $this->connect();
    }

    public function connect(){
        $this->connection =  new mysqli($this->host, $this->user, $this->pass, $this->db);
        if ($this->connection->connect_errno) {
            echo "Failed to connect to MySQL: " . $this->connection -> connect_error;
            exit();
        }
    }
    public function executeQuery($sql, $types, $data){
        $statement = $this->connection->prepare($sql);
        $statement->bind_param($types, ...$data);
        $statement->execute();

        return $statement;
    }

    public function table($tableName){
        $this->table_name = $tableName;
        // influent interface
        return $this;
    }

    public function limit($limit){
        $this->limit = $limit;
        return $this;
    }

    public function offset($offset){
        $this->offset = $offset;
        return $this;
    }
    public function get($id = ''){
        $sql = "SELECT * FROM $this->table_name";

        if($id !== ''){
            $sql .= " WHERE id = ?";
            $statement = $this->executeQuery($sql, 'i', [$id]);
            $result = $statement->get_result()->fetch_assoc();
        }else{
            $statement = $this->connection->prepare($sql);
            $statement->execute();
            $result = $statement->get_result()->fetch_all(MYSQLI_ASSOC);
        }
       
        return $result;
    }


    public function insert($data = []){
      
        // insert into $table(column1, column2, ..., column n) values (?,?,...,?);
        $keys = array_keys($data);
        $arr_values = array_values($data);
        $fields = implode(',', $keys);
        $marks = implode(',', array_fill(0, count($keys), '?'));
        $types = str_repeat('s', count($keys));
           
        $sql = "INSERT INTO $this->table_name($fields) VALUES($marks)";
   
        $statement = $this->executeQuery($sql, $types, $arr_values);
        
        return $statement->affected_rows;

    }

    public function update($id, $data = []){
        // $fields with format: $key=?, $key2=? 
        $fields = [];
        foreach($data as $key => $value){
            $fields[] = $key .'=?';
        }
        $data_types = str_repeat('s', count($data));

        $values = array_values($data);
        $values[] = $id;
  
        $fields = implode(',', $fields);
        $sql = "UPDATE $this->table_name SET $fields WHERE id = ?";

        $statement = $this->executeQuery($sql, $data_types . 'i', $values);

        return $statement->affected_rows;


    }
    public function delete($id){
        $sql = "DELETE FROM $this->table_name WHERE id = ?";
        $statement = $this->executeQuery($sql, 'i',[$id]);
        return $statement->affected_rows;

    }
}