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
        //dnd($_SESSION);
        $this->view->render('home/view');
        //dnd($this->GoodsModel);
    }
} 