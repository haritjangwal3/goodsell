<?php
    define('DEFAULT_CONTROLLER', 'Home'); // default controller if the url is not set.  
    
    define('DEBUG', true);
    // define('DEFAULT_CONTROLLER', 'Index'); // default controller if the controller is not defined.
    define('DEFAULT_LAYOUT', 'default'); // if no layout is set in the controller use this layout.

    define('SITE_TITLE', 'goodsell'); // Use if the Site title is not set.
    define('SROOT', '/goodsell/'); // set this to '/' for the live server.
    
    $path = str_replace("index.php", '',$_SERVER['SCRIPT_FILENAME']);
    define('PROOT', $path);
    

    define('HOST', 'localhost'); // for the live server
    define('DBUSER', 'root'); 
    define('DBPASS','');
    define('DBNAME', 'goodsell');
    define('CURRENT_USER_SESSION_NAME', 'kwDHuHNUjnWEaweWjhBUg'); // SESSION NAME for logged in user
    
    define('REMEMBER_ME_COOKIE_NAME', 'iVe4Awe4eN3dC42UbXjN4'); // cookie for loggd in user with remember me.
    define('REMEMBER_COOKIE_EXPIRY', 2592000); // 30 days in sec for cookie to 5tg
    define('ACCESS_RESTRICTED', 'Restricted'); // Controller redirect for restricted page -  ACL
    define('MENU_BRAND', 'Goodsell');