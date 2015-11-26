<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Auth
 *
 * @author christianzirbes
 */
class Auth {
    
    private $options = array(
        'restriction_msg' => "vous n'avez pas le droit d'accéder à cette page",
    );
    private $session ;
        
    public function __construct($session, $options = array()) {
        $this->options = array_merge($this->options, $options);
        $this->session = $session;
    }
   
    public function register($db, $username, $lastname, $firstname, $email, $password) {
        $password = password_hash($password, PASSWORD_BCRYPT);
        $token = Str::random(60);
        $db->query("INSERT INTO zed_users SET username = ?,lastname=?, firstname=?, email = ?, password = ?, confirmation_token = ? ", array($username, $lastname, $firstname, $email, $password, $token));
        $user_id = $db->lastInsertId();
        mail($email, 'Confirmation de votre compte', "Afin de valider votre compte merci de cliquer sur ce lien\n\nhttp://localhost/coupe_davis_2016/confirm.php?id={$user_id}&token=$token");    
    }
    public function confirm ($db, $user_id, $token){
        $user = $db->query("SELECT * FROM zed_users WHERE id = ?", array($user_id))->fetch();

        if($user && $user->confirmation_token == $token){

            $db->query("UPDATE zed_users SET confirmation_token = NULL, confirmed_at = NOW() WHERE id = ? ", array($user_id));
            $this->session->write('auth',$user);
            return true;
        }else{
            return false;
        }
    }
    public function restrict(){
        if (!$this->session->read('auth')){
            $this->session->setFlash('danger',  $this->options['restriction_msg']);
            App::redirect('login.php');
            exit();
        }
    }
    
    public function user() {
        if (!$this->session->read('auth')){
            return false;
        }
        return $this->session->read('auth');
    }
    
    public function connect($user) {
        $this->session->write('auth', $user);
    }
    
    public function connectFromCookie($db) {
        if(isset($_COOKIE['remember']) && !$this->user()){

            $remember_token = $_COOKIE['remember'];
            $parts =  explode("==", $remember_token);
            $user_id = $parts[0];
            $user = $db->query("SELECT * FROM zed_users WHERE id=?",array($user_id) )->fetch();
            if($user){
                $expected = $user->id . '==' . $remember_token . sha1($user->id . 'totoestgrand');
                if ($expected == $remember_token){
                    $this->connect($user);
                    setcookie('remember', $remember_token, time() + 60*60*24*6);
                }else{
                    setcookie('remember', null, -1);
                }
            }else{
                setcookie('remember', NULL, -1);
            }
        }
    }
    
    public function login($db, $email, $password, $remember = false){
        $user = $db->query("SELECT * FROM zed_users WHERE email = ?",array($email) )->fetch();
        //var_dump($user);
        //die();
        //return $user; 
        if($user && password_verify($password, $user->password)){
            $this->connect($user);
            if($remember){
                $this->remember($db, $user->id);
            }
            return $user;   
        }else{
            return false;
        }
    }
    public function remember($db, $user_id) {
        $remember_token = Str::random(250);
        $db->query("UPDATE zed_users SET remember_token = ? WHERE id = ?", array($remember_token, $user_id));
        setcookie('remember', $user_id . '==' . $remember_token . sha1($user_id . 'totoestgrand'), time() + 60 * 60* 24*7);
    }
    
    public function logout() {
        $this->session->delete('auth');
    }
}
 