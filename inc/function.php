<?php

function debug($var){
    echo '<pre>'. print_r($var, true) . '</pre>';
}

function str_random($length){
    $alphabet = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
    return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
}
/*
 * Page nécessitant une authentification
 */
function auth_needed(){
    if(session_status() == PHP_SESSION_NONE){
    session_start();
    }
    if (!isset($_SESSION['auth'])){
    $_SESSION['flash']['danger']= "vous n'avez pas le droit d'accéder à cette page";
    header('Location: login.php');
    exit();
    }
}

function reconnect_cookie(){
    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }
    if(isset($_COOKIE['remember']) && !isset($_SESSION['auth'])){
        require_once 'db.php';
        if(!isset($pdo)){
            global $pdo;
        }
        
        $remember_token = $_COOKIE['remember'];
        $parts =  explode("==", $remember_token);
        $user_id = $parts[0];
        $req = $pdo->prepare("SELECT * FROM zed_users WHERE id=?");
        $req->execute([$user_id]);
        $user = $req->fetch();
        if($user){
            $expected = $user->id . '==' . $remember_token . sha1($user->id . 'totoestgrand');
            if ($expected == $remember_token){
                session_start();
                $_SESSION['auth'] = $user;
                setcookie('remember', $remember_token, time() + 60*60*24*6);
            }else{
                setcookie('remember', null, -1);
            }
        }else{
            setcookie('remember', NULL, -1);
        }
    }
}
function doMail($dest, $subject, $message){
    $destinataire = $dest;
    // Pour les champs $expediteur / $copie / $destinataire, séparer par une virgule s'il y a plusieurs adresses
    $expediteur = '<capella@chzirbes.be>';
    $objet = $subject; // Objet du message
    $headers  = 'MIME-Version: 1.0' . "\n"; // Version MIME
    $headers .= 'Content-type: text/html; charset=ISO-8859-1'."\n"; // l'en-tete Content-type pour le format HTML
    $headers .= 'Reply-To: '.$expediteur."\n"; // Mail de reponse
    $headers .= 'From: "CAPella"<'.$expediteur.'>'."\n"; // Expediteur
    $headers .= 'Delivered-to: '.$destinataire."\n"; // Destinataire
    $message = '<div style="width: 100%; text-align: center; font-weight: bold">'.$message.'</div>';
    if (mail($destinataire, $objet, $message, $headers)) // Envoi du message
    {
        return TRUE;
    }
    else // Non envoyé
    {
        return FALSE;

    }
}