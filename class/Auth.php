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
    
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
        
    }
   
    public function register($username, $lastname, $firstname, $email, $password) {
        $password = password_hash($password, PASSWORD_BCRYPT);
        $token = Str::random(60);
        $this->db->query("INSERT INTO zed_users SET username = ?,lastname=?, firstname=?, email = ?, password = ?, confirmation_token = ? ", array($username, $lastname, $firstname, $email, $password, $token));
        $user_id = $this->db->lastInsertId();
        mail($email, 'Confirmation de votre compte', "Afin de valider votre compte merci de cliquer sur ce lien\n\nhttp://localhost/coupe_davis_2016/confirm.php?id={$user_id}&token=$token");    
    }
    public function confirm ($user_id, $token, $session){
        $user = $this->db->query("SELECT * FROM zed_users WHERE id = ?", $user_id)->fetch();

        if($user && $user->confirmation_token == $token){

            $this->db->query("UPDATE zed_users SET confirmation_token = NULL, confirmed_at = NOW() WHERE id = ? ", $user_id);
            $session->write('auth',$user);
            return true;
        }else{
            return false;
        }

    }
}
