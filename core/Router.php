<?php

class Router 
{
    public static function route($url){
        // controller
        //dnd($url);
        $controller = (isset($url[0]) && $url[0] != '') ? ucwords($url[0]): DEFAULT_CONTROLLER ;
        $controller_name = $controller;
        array_shift($url);

        // action
        $action = (isset($url[0]) && $url[0] != '') ? $url[0] . 'Action' : 'indexAction' ;
        $action_name = $action;  
        array_shift($url);
        
        //acl check
        $grantAccess = self::hasAccess($controller_name, $action_name);

        if(!$grantAccess){
            $controller_name = $controller = ACCESS_RESTRICTED;
            $action_name = "indexAction";
        }

        //params
        $queryParams = $url;

        $dispatch = new $controller($controller_name, $action_name);
        //dnd($controller);
        if(method_exists($controller, $action_name)){
            call_user_func_array([$dispatch, $action_name], $queryParams);
        }
        else 
        {
            die( $action_name . ' does not exist in the controller "' . $controller_name .'"');
        }
    }

    public static function redirect($location){
        if(!headers_sent()){
            header('Location: '. SROOT .$location);
            exit();
        }
        else {
            echo "<script type='text/javascript'>
            window.location.href='" . SROOT.$location. "'
            </script>";
            echo '<noscript>';
            echo '<meta http-equiv="refresh" content="0;url='.$location.'"';
            echo '</noscript>';exit;
        }
    }

    public static function hasAccess($controller_name, $action_name='index'){
        $controller_name = strtolower($controller_name);
        $acl_file = file_get_contents(ROOT . DS . 'app' . DS . 'acl.json');
        $acl = json_decode($acl_file, true);
        $current_user_acls = ["guest"];
        $grantAccess = false;
        if (strpos($action_name, 'Action') !== false){
            $action_name = str_replace("Action","", $action_name);
        }
        if(Session::exists(CURRENT_USER_SESSION_NAME)){
            $current_user_acls[] = "loggedIn";
            foreach(currentUser()->acls() as $a){
                $current_user_acls[] = $a; // add other ACL's from the user table in DB.
            }
        }

        foreach($current_user_acls as $level){
            if(array_key_exists($level, $acl) && array_key_exists($controller_name, $acl[$level])){
                if(in_array($action_name, $acl[$level][$controller_name]) || in_array("*", $acl[$level][$controller_name])){
                    $grantAccess = true;
                break;
                }
            }
        }
        
        // check for denied
        foreach($current_user_acls as $level){
            if(isset($acl[$level]['denied'])){
                $denied = $acl[$level]['denied'];
                if(!empty($denied) ) {
                    if(array_key_exists($controller_name, $denied)){
                        if(in_array($action_name, $denied[$controller_name])){
                            $grantAccess = false;
                            break;
                        }
                    }
                    
                  }
            };
        }
        return $grantAccess;
    }

    public static function getMenu($filename){
        $menuArray = [];
        $menu_acl_file = file_get_contents(ROOT . DS . 'app' . DS . 'menu_acl.json');
        $acl_menu = json_decode($menu_acl_file, true);
        foreach($acl_menu as $main_key => $sub_key){
            if(is_array($sub_key)){
                $sub = [];
                foreach($sub_key as $key => $v){
                    if($key == 'seperator' && !empty($sub)){
                        $sub[$key] = '';
                        continue;
                    }
                    if($finalkeySub = self::getLink($v)){
                        $sub[$key] = $finalkeySub;
                    }
                }
                if(!empty($sub)){
                    $menuArray[$main_key] = $sub;
                }
            }
            else {
                if($finalkey = self::getLink($sub_key)){
                    $menuArray[$main_key] = $finalkey;
                }
            }
        }
        
        return $menuArray;
    }

    private static function getLink($link){
        //echo $link . '<br/>';
        //check if the link is external --- using regular expression (RE) buildin function
        if(preg_match('/https?:\/\//', $link) == 1) {
            
            return $link;
        }
        else {
            $uAry = explode('/', $link);
            $controller_name = ucwords($uAry[0]);
            $action_name = (isset($uAry[1])) ? $uAry[1] : '';
            $result = self::hasAccess($controller_name, $action_name);
            //echo_p($link, $result);
            if(self::hasAccess($controller_name, $action_name)){
                return SROOT . $link;
            }
            return false;
        }
    }
}