<?php


define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__));

// loading configurations and helper funcations

require_once(ROOT . DS . 'config' . DS . 'config.php');
require_once(ROOT . DS . 'app' . DS . 'lib' . DS . 'helpers' . DS. 'functions.php');
require_once(ROOT . DS . 'core' . DS . 'MySQLDB.php'); // pre-build class for mysql
//require_once(ROOT . DS . 'core' . DS . 'DB.php'); // custom PDO DB class

// autoload classes funcation

function autoload($className)
{
    if(file_exists(ROOT . DS . 'core' . DS . $className . '.php')) 
    {   
        // load classes from core folder
        require_once(ROOT . DS . 'core' . DS . $className . '.php');
    }
    elseif(file_exists(ROOT . DS . 'app' . DS . 'controllers' . DS .  $className . '.php')) 
    {
        // load classes from controllers folder
        require_once(ROOT . DS . 'app' . DS . 'controllers' . DS .  $className . '.php');
    }
    elseif(file_exists(ROOT . DS . 'app' . DS . 'models' . DS .  $className . '.php'))
    {
        // load classes from models folder
        require_once(ROOT . DS . 'app' . DS . 'models' . DS .  $className . '.php');
    }
}

spl_autoload_register('autoload');
session_start();

$url = isset($_SERVER['PATH_INFO']) ? explode('/', ltrim($_SERVER['PATH_INFO'], '/')) : [];
// Add the request using "/" in the url into array form
// var_dump($url);
require_once(ROOT . DS . 'core' . DS . 'bootstrap.php');

// $db = DB::getInstance();
// $db->query('select * from users');
if(!Session::exists(CURRENT_USER_SESSION_NAME) && Cookie::exists(REMEMBER_ME_COOKIE_NAME)){
    User::loginUserFromCookie();
}
// Route the request
Router::route($url);

// get user location
