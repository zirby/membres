<?php
require 'inc/bootstrap.php';

$db = App::getDatabase();

$auth = new Auth($db);


if($auth->confirm($_GET['id'], $_GET['token'], Session::getInstance())){  
    Session::getInstance()->setFlash('success', "Votre compte à bien été validé");
    App::redirect('account.php'); 
}else{
    Session::getInstance()->setFlash('danger', "Ce token n'est pas valide");
    App::redirect('login.php');
}