<?php

class App{
    
    static $db = null;


    static function getDatabase(){
        if(!self::$db){
            self::$db = new Database('root', 'root', 'membres');
        }
        return self::$db;
    }
    
    static function getAuth(){
        return new Auth(Session::getInstance(), array('restriction_msg'=>"Lol, tu es bloqué"));
    }


    static function redirect($page){
        header("location: $page");
        exit();
    }
    
}
