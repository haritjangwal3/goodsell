<?php

class DB {
    private static $_instance =  null;
    private $_pdo, $_query, $__error = false, $_count = 0, $_lastInsertID = null;
    public $_results;
    
    private function __construct(){
        try{
            $this->_pdo = new PDO('mysql:host=localhost;dbname=goodsell', 'root', '');
            $this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->_pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        }
        catch(PDOException $e) {
            
            die($e->getMessage());
        }
    }

    public static function getInstance() {
        if(!isset(self::$_instance)) {
            self::$_instance = new DB();
        }
        return self::$_instance;
    }

    public function query($qry, $params = []){
        $this->__error = false;

        if($this->_query = $this->_pdo->prepare($qry)){
            $x = 1;
            if(count($params)) {
                foreach ($params as $param) {
                    $this->_query->bindValue($x, $param);  // prevent the SQL injection
                    $x++;
                }
                //dnd($this->_query);
            }
            if($this->_query->execute()) {
                $this->_results = $this->_query->fetchALL(PDO::FETCH_OBJ);
                $this->_count = $this->_query->rowCount();
                $this->_lastInsertID = $this->_pdo->lastInsertId();
            }
            else{
                $this->__error = true;
            }
        }
        return $this;
    }

    public function insert($table, $fields = []){
        $fieldString = '';
        $valueString = '';
        $values = [];
        foreach($fields as $field => $value){
            $fieldString .= '`' . $field . '`,';
            $valueString .= '?,';
            $values[] = $value;
        }
        $fieldString = rtrim($fieldString, ',');
        $valueString = rtrim($valueString, ',');

        $qry = "insert into {$table} ({$fieldString}) values ({$valueString})";
        if(!$this->query($qry, $values)->error()){
            return true;
        }
        return false;
    }

    public function error() {
        return $this->__error;
    }

    public function update($table, $id, $fields=[]) {
        $fieldString = '';
        $values = [];
        foreach($fields as $field => $value){
            $fieldString .= ' ' . $field . ' = ?,';
            $values[] = $value;
        }
        $fieldString = trim($fieldString);
        $fieldString = rtrim($fieldString, ',');
        $qry = "update {$table} set {$fieldString} where id = {$id}";
        if(!$this->query($qry, $values)->error()){
            return true;
        }
        return false;
    }

    public function delete($table, $id) {
        
        $qry = "delete from {$table} where id = {$id}";
        if(!$this->query($qry)->error()){
            return true;
        }
        return false;
    }

    public function first(){
        return (!empty($this->_results)) ? $this->_results[0] : "No data found";
    }

    public function count(){
        return $this->_count;
    }

    public function lastID(){
        return $this->_lastInsertID;
    }

    public function get_columns($table) {
        return $this->query("SHOW COLUMNS FROM {$table}")->results();
    }
    
    public function results(){
        return $this->_results;
    }

    protected function _read($table, $params = []){
        $conditionString = '';
        $bind = [];
        $order = '';
        $limit = '';

        //conditions
        if(isset($params['conditions'])){
            if(is_array($params['conditions'])){
                foreach($params['conditions'] as $condition){
                    $conditionString .= ' '. $condition . ' AND';
                }
                $conditionString = trim(rtrim($conditionString, ' AND'));
            }
            else{
                $conditionString = $params['conditions'];
            }
            if($conditionString != '') {
                $conditionString = ' where ' . $conditionString;
            }
            
        }
        //bind
        

        if(array_key_exists('bind', $params)){
            
            $bind = $params['bind'];
        }
        //order 

        if(array_key_exists('order', $params)){
            $order = ' order by ' . $params['order'];
        }
        //limit
        if(array_key_exists('limit', $params)){
            $limit = ' limit ' . $params['limit'];
        }

        $qry = "select * from {$table}{$conditionString}{$order}{$limit}";
        
        if($this->query($qry, $bind)) {
            if(!count($this->_results)) return false;
            return true;
        }
        return false;
    }

    public function find($table, $params = []){
        if($this->_read($table, $params)) {
            return $this->results();
        }
        return false;
    }

    public function findFirst($table, $params = []){
        if($this->_read($table, $params)) {
            return $this->first();
        }
        return false;
    }
}