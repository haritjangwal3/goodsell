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
        $this->view->render('home/addgood');
    }
} 