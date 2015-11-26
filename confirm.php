<?php
require 'inc/bootstrap.php';

$db = App::getDatabase();




if($auth->confirm($db, $_GET['id'], $_GET['token'], Session::getInstance())){  
    App::getAuth()->setFlash('success', "Votre compte à bien été validé");
    App::redirect('account.php'); 
}else{
    App::getAuth()->setFlash('danger', "Ce token n'est pas valide");
    App::redirect('login.php');
}