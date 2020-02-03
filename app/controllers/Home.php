<?php 

class Home extends Controller {
    
    public function __construct($controller, $action){
        parent::__construct($controller, $action);
        $this->load_model('Goods');
    }
    public function indexAction(){
        //dnd($_SESSION);
        $this->view->render('home/index');
        //dnd($this->GoodsModel);
    }
    public function viewAction($good_id){
        $goods =  $this->GoodsModel->getAllGoods();
        if(array_key_exists($good_id, $goods)){
            $good = $goods[$good_id];
            $this->view->data = $good;
            $this->view->render('home/view');
        }
        else{
            $this->view->render('home/notfound');
        }
        
        //dnd($this->GoodsModel);
    }

    public function addgoodAction() {
        $validation = new Validate();
        $posted_values = [
            'good_title' => '',
            'good_des'=> '',
            'good_quality'=> '',
            'price'=> '',
            'category' => ''];
        if($_POST){
            $posted_values = posted_values($_POST); // so that user don't loss entred value
            $validation->check(
                $_POST,
                [
                    'good_title' => ['display' => "Title", 'required' => true, 'min' => 5, 'max' => 20],
                    'good_des' =>  ['display' => "Description", 'required' => true],
                    'good_quality' =>  ['display' => "Quality",'required' => true,'max' => 20],
                    'price' =>  ['display' => "Price", 'required' => true]
                ]
            );
        }
        if($validation->passed()){
            
            $newGood = new Good();
            $newGood->addNewGood($_POST);
            Router::redirect('');
        }
        /// NOT GOOD CODE START
        $mainCateg = [];
        $categories = Goods::getAllCategories();
        foreach($categories as $key => $val){
            $mainCateg[$val->category_id] = $val->category_name;
        }
        $mainCateg = array_unique($mainCateg);
        /// NOT GOOD CODE END
        $this->view->categories = Goods::getAllCategories();
        $this->view->main_Categories = $mainCateg;
        $this->view->post = $posted_values;
        $this->view->displayErrors = $validation->displayErrors();
        $this->view->currentUser = currentUser();
        $this->view->render('home/addgood');
    }
} 