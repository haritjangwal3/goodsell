<?php

class View {
    protected $_head, $_siteTitle = SITE_TITLE, $_body, $_outputBuffer, $_layout = DEFAULT_LAYOUT;

    public $data = null;
    public function __construct()
    {
        
    }



    public function render($viewName){
        $viewArray = explode('/', $viewName);
        $viewString = implode(DS, $viewArray);

        if(file_exists(ROOT . DS. 'app' . DS . 'views' . DS . $viewString. '.php'))
        {
            include(ROOT . DS. 'app' . DS . 'views' . DS . $viewString. '.php');
            
            include(ROOT . DS. 'app' . DS . 'views' . DS . 'layouts'. DS . $this->_layout . '.php');
        }
        else {
            die('The view |' . $viewName . '| do not exist ');
        }
    }

    public function content($type){
        if($type == 'head'){
            return $this->_head;
        }
        elseif ($type == 'body') {
            return $this->_body;
        }

        return false;
    }

    public function start($type){
        $this->_outputBuffer = $type;
        ob_start();  // print the output
    }

    public function end(){
        if($this->_outputBuffer == 'head'){
            $this->_head = ob_get_clean();
        }
        elseif($this->_outputBuffer == 'body'){
            $this->_body = ob_get_clean();
        }
        else {
            die('You must first use the start method!');
        }
    }

    public function sitetitle(){
        return $this->_siteTitle;
    }

    public function setSiteTitle($title){
        $this->_siteTitle = $title;
    }

    public function setLayout($path){
        $this->_layout = $path;
    }
}