<?php

class Good extends Model {
    public $_file_uploads =  false;
    public static $currentLoggedInUser = null;

    public function __construct($good_id = '')
    {
        $table = 'goods';
        parent::__construct($table);
        $this->_modelName = str_replace(' ', '', ucwords(rtrim($this->_table,'s')));

        if($good_id != ''){
            if(is_int($good_id)){
                $this->id = $good_id;
                $good = $this->_db->findFirst($table, ['conditions' => 'id = ?', 'bind' => [$good_id]]);
            }
            if($good) {
                foreach($good as $key=> $value){
                    $this->{$key} = $value;
                }
            }
        }
    }

    public function findByDate($username){
        //return $this->findFirst(['conditions'=>"username = ?", "bind" => [$username]]);
    }

    public function goodUpdate($goodid){
        $fields = [];
        foreach($this->_columnNames as $column){
            $fields[$column] = $this->$column;
        }
        return $this->update($this->good_id, $fields);
    }

    public function addNewGood($_post){
        if($this->assign($_post)){
            $user = currentUser();
            $imgs = rtrim($this->good_images, ", ");
            $imagesurl = explode(", ", $imgs);
            $this->views = 0;
            $this->user_id = $user->id;
            $this->post_date = date("Y/m/d");
            $result = $this->save();
            $good_images = '';
            foreach($imagesurl as $url){
                $good_images .= $user->username . '/' . $result . '/' . $url . ', ';
            }
            $this->good_images = rtrim($good_images, ", ");
            $this->good_id = intval($result);
            $this->goodUpdate($this->good_id);
            $dir = ROOT .'\app\data\\' . $user->username . '\\';
            $tempDir = ROOT .'\app\data\current_temp\\'. $user->username;
            if($result){
                $tempFiles = scandir($tempDir);
                $x = 0;
                foreach($tempFiles as $fileName){
                    if(strlen($fileName) > 3){
                        $x++;
                        $srcfile = $tempDir . '\\' . $fileName;
                        $destfile = $dir . $result . '\\' . "img" . strval($x) . '.jpg';
                        //dnd($dir . $result . '\\' . $newfileName);
                        if(file_exists($srcfile)){
                            if(!is_dir($dir . $result)){
                                mkdir($dir . $result, 0777, true);
                            }
                            copy($srcfile, $destfile); 
                        }
                    }
                }
            }
            
        }
        
    }

    public static function currentLoggedInUser(){
        if(!isset(self::$currentLoggedInUser) && Session::exists(CURRENT_USER_SESSION_NAME)) {
            $u = new User((int)Session::get(CURRENT_USER_SESSION_NAME));
            self::$currentLoggedInUser = $u; 
        }
        return  self::$currentLoggedInUser;
    }

    public function acls() {
        if(empty($this->acls)) return [];
        return json_decode($this->acls, true);
    }
}