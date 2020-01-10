<?php 

class Model {
    protected $_db, $_table, $_modelName, $_softDelete = false, $_columnNames=[];
    public $id;

    public function __construct($table){
        $this->_db = DB::getInstance();
        $this->_table = $table;
        $this->_setTableColumns();
        $this->_modelName = str_replace(' ', '', ucwords(str_replace('_', '', $this->_table)));
    }
    // Model class 1
    protected function _setTableColumns(){
        $table_columns = $this->get_columns();
        foreach($table_columns as $key => $value) {
            foreach($value as $key => $val){
                if($key == "Field"){
                    $this->_columnNames[] = $val;
                    $this->{$val} = null;
                }
            }
        }
    }

    public function get_columns(){
        return $this->_db->get_columns($this->_table);
    }

    public function find($params =[]){
        $results =  [];
        $resultQuery = $this->_db->_find($this->_table, $params);
        foreach($resultQuery as $result){
            $obj = new $this->_modelName($this->_table);
            $obj->populateObjData($result);
            $results[] = $obj;
        }
        return $results;
    }

    public function findFirst($params =[]){
        $result = new $this->_modelName($this->_table);
        $resultQuery = $this->_db->findFirst($this->_table, $params);
        if($resultQuery){
            $result->populateObjData($resultQuery);
        }
        return $result;
    }

    protected function populateObjData($result){
        foreach($result as $key => $value){
            $this->$key = $value;
        }
    }

    public function findById($id) {
        return $this->findFirst(['conditions' => "id = ?", "bind" => [$id]]);
    }

    public function insert($fields){
        if (!empty($fields)){
            return $this->_db->insert($this->_table, $fields);
        }
    }

    public function update($id, $field){
        if (empty($field) || $id== '') return false;
        return $this->_db->update($this->_table, $this->id, $field);
    }

    public function delete($id=''){
        if ($id== '' && $this->id == '') return false;
        $id = ($id == '') ? $this->id : $id;
        if($this->_softDelete){
            return $this->update($id, ['deleted' => 1]);
        }
        return $this->_db->delete($this->_table, $id);
    }

    public function query($qry, $bind){
        return $this->_db->query($qry, $bind);
    }

    public function data(){
        $data = new stdClass();
        foreach($this->_columnNames as $column) {
            $data->column = $this->$column;
        }
        return $data;
    }

    public function assign($params){
        
        if(!empty($params) && !empty($this->_columnNames)) {
            foreach($params as $key => $value){
                
                if(in_array($key, $this->_columnNames)){
                    $this->$key = sanitize($value); // gives table column properties to the class model
                }
            }
            return true;
        }
        return false;
    }

    public function save(){
        $fields = [];
        foreach($this->_columnNames as $column){
            $fields[$column] = $this->$column;
        }

        // determine whether to update or insert
        if(property_exists($this, 'id') && $this->id != NULL){
            return $this->update($this->id, $fields);
        }
        else {
            return $this->insert($fields);
        }
    }
}
