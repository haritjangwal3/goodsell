<?php

class Goods extends Model {
    private $_currentLocation, $_itemsPerView;
    public static $_goods;

    public function __construct($overRidetable = '')
    {
        //parent::__construct($overRidetable);
        $table = 'goods'; //
        $this->_isCollection = true;
        parent::__construct($table);
        // if(class_exists('User')){
        //     $user = new User((int)Session::get(CURRENT_USER_SESSION_NAME));
        //     $this->id = $user->id;
        // }

        $qry = "SELECT goods.* , users.username FROM ". $table. " INNER JOIN users ON goods.user_id = users.id";
        $goodsResult = $this->_db->query($qry);
        if($goodsResult->_results) {
            foreach($goodsResult->_results as $key=> $value){
                self::$_goods[$value->good_id] = $value;
            }
        }
    }

    public function findByCategory($category){
        return $this->findFirst(['conditions'=>"category = ?", "bind" => [$category]]);
    }

    public static function getAllGoods(){
        if(count(self::$_goods) == 0){
            return false;
        }
        return self::$_goods;
    }
}