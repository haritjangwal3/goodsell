<?php

class Goods extends Model {
    private $_currentLocation, $_itemsPerView;
    public static $_goods, $_categories;

    public static $currentLoggedInUser = null;

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
        $this->populateGoods();
        $this->populateSubCategories();
    }

    public function populateGoods(){
        $qry = "SELECT goods.* , users.username 
        FROM ". $this->_table. " INNER JOIN users ON goods.user_id = users.id"; // to get username with goods 
        $goodsResult = $this->_db->query($qry);
        if($goodsResult->_results) {
            foreach($goodsResult->_results as $key=> $value){
                self::$_goods[$value->good_id] = $value;
            }
        }
    }

    public function populateSubCategories(){
        $qry = "SELECT sub_category.sub_category_id, sub_category_name , category.category_id , category.category_name  
        FROM sub_category 
        INNER JOIN category 
        ON sub_category.category_id = category.category_id";
        $categoryResult = $this->_db->query($qry);
        if($categoryResult->_results) {
            foreach($categoryResult->_results as $key=> $value){
                self::$_categories[$value->sub_category_id] = $value;
            }
        }
    }

    public function findByCategory($category){
        return $this->findFirst(['conditions'=>"category = ?", "bind" => [$category]]);
    }

    public static function getCategories(){
        $qry = "SELECT sub_category.sub_category_id, sub_category_name , category.category_name  
        FROM sub_category 
        INNER JOIN category 
        ON sub_category.category_id = category.category_id";
        $categoryResult = self::$_db->qry($qry);
        if($categoryResult->_results) {
            foreach($categoryResult->_results as $key=> $value){
                self::$_categories[$value->category_id] = $value;
            }
        }
        return self::$_categories;
    }

    public static function getAllGoods(){
        if(count(self::$_goods) == 0){
            return false;
        }
        return self::$_goods;
    }

    public static function getAllCategories(){
        if(count(self::$_categories) == 0){
            return false;
        }
        return self::$_categories;
    }


    
    public function addGoods($_post){
        if($this->assign($_post)){
            $result = $this->save();
        }
        
    }
}