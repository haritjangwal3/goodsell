<?php

class User extends Model {
    private $_isLoggedIn, $_sessionName, $_cookieName;
    public static $currentLoggedInUser = null;

    public function __construct($user = '')
    {
        $table = 'users';
        parent::__construct($table);
        $this->_sessionName  = CURRENT_USER_SESSION_NAME;
        $this->_cookieName = REMEMBER_ME_COOKIE_NAME;
        $this->_softDelete = true;
        $this->_modelName = str_replace(' ', '', ucwords(rtrim($this->_table,'s')));

        if($user != ''){
            if(is_int($user)){
                $u = $this->_db->findFirst('users', ['conditions' => 'id = ?', 'bind' => [$user]]);
            }
            else {
                $u = $this->_db->findFirst('users', ['conditions' => 'username = ?', 'bind' => [$user]]);
            }
            if($u) {
                foreach($u as $key=> $value){
                    $this->$key = $value;
                }
            }
        }
    }

    public function loginUserFromCookie()
    {
        $userSessions = UserSessions::getFromCookie();
        if($userSessions->user_id != ''){
            $user = new self((int)$userSessions->user_id);
            if($user){
                $user->login();
                return $user;
            }
        }
        return false;
    }

    public function findByUsername($username){
        return $this->findFirst(['conditions'=>"username = ?", "bind" => [$username]]);
    }

    public function registerNewUser($_post){
        if($this->assign($_post)){
            $this->password = password_hash($this->password, PASSWORD_DEFAULT);
            $this->deleted = 0;
            $result = $this->save();
        }
        
    }


    public function login($rememberMe = false)
    {
        // set the session
        Session::set($this->_sessionName, $this->id);
        //if remember me is set - grab the user and useragent and set cookie
        if($rememberMe){ 
            $hash = sha1(uniqid() + rand(0, 100));
            $userAgent = Session::uagent_no_version();
            Cookie::set($this->_cookieName, $hash, REMEMBER_COOKIE_EXPIRY);
            $fields = ['session'=>$hash, 'user_agent'=>$userAgent, 'user_id' =>$this->id];
            $this->_db->query("delete from user_sessions where user_id = ? and user_agent = ?", [$this->id, $userAgent]);
            $this->_db->insert('user_sessions', $fields);
        }
    }

    public function logout(){
        $userSession =  UserSessions::getFromCookie();
        if($userSession){
            $userSession->delete();
        }
        Session::delete(CURRENT_USER_SESSION_NAME);
        if(Cookie::exists(REMEMBER_ME_COOKIE_NAME)){

            Cookie::delete(REMEMBER_ME_COOKIE_NAME);
        }

        self::$currentLoggedInUser = null;
        return true;
    }

    public static function currentLoggedInUser(){
        if(!isset(self::$currentLoggedInUser) && Session::exists(CURRENT_USER_SESSION_NAME)) {
            $u = new User((int)Session::get(CURRENT_USER_SESSION_NAME));
            self::$currentLoggedInUser = $u; 
        }
        return  self::$currentLoggedInUser;
    }

    public function acls() {
        if(empty($this->acls)) return [];
        return json_decode($this->acls, true);
    }
}