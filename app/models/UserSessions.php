<?php

class UserSessions extends Model {
    public function __construct()
    {
        $table = 'user_sessions';
        parent::__construct($table);
    }

    public static function getFromCookie(){
        if(Cookie::exists(REMEMBER_ME_COOKIE_NAME)){
            $userSession = new self();
            $user_session =  $userSession->findFirst([
                'conditions' => "user_agent = ? and session = ?", 
                'bind' => [Session::uagent_no_version(), Cookie::get(REMEMBER_ME_COOKIE_NAME)]
            ]);
        }
        if(!$user_session) return false;
        return $user_session;

    }
}