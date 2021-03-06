<?php

class Controller extends Application {
    protected $_controller, $_action;
    public $view;

    public function __construct($controller, $action)
    {
        parent::__construct();
        $this->controller = $controller;
        $this->action = $action;
        $this->view = new View();
        //$this->db = new MySQL(HOST, DBUSER, DBPASS, DBNAME);
        //require_once(ROOT . DS . 'core' . DS .'Router.php');
    }

    protected function load_model($model){
        if(class_exists($model)){
            $this->{$model.'Model'} = new $model(strtolower($model));
        }
    }
}