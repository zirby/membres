<?php

session_start();
unset($_SESSION['auth']);

unset($_SESSION['priceTot']);
unset($_SESSION['placeNb']);
unset($_SESSION['placeBloc']);
unset($_SESSION['placeZone']);



//setcookie('remember', NULL, -1);
$_SESSION['flash']['success'] = "Vous êtes maintenant déconnecté";
header('Location: index.php');
