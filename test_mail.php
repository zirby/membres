<?php

$destinataire = 'zirby.zirby@gmail.com';
// Pour les champs $expediteur / $copie / $destinataire, séparer par une virgule s'il y a plusieurs adresses
$expediteur = 'zirby.zirby@gmail.com';
$copie = 'christian.zirbes@icloud.com';
$copie_cachee = 'ffagnoul@yahoo.fr';
$objet = 'Test'; // Objet du message
$headers  = 'MIME-Version: 1.0' . "\n"; // Version MIME
$headers .= 'Content-type: text/html; charset=ISO-8859-1'."\n"; // l'en-tete Content-type pour le format HTML
$headers .= 'Reply-To: '.$expediteur."\n"; // Mail de reponse
$headers .= 'From: "Nom_de_expediteur"<'.$expediteur.'>'."\n"; // Expediteur
$headers .= 'Delivered-to: '.$destinataire."\n"; // Destinataire
$headers .= 'Cc: '.$copie."\n"; // Copie Cc
$headers .= 'Bcc: '.$copie_cachee."\n\n"; // Copie cachée Bcc        
$message = '<div style="width: 100%; text-align: center; font-weight: bold">Un Bonjour de ZED !</div>';
if (mail($destinataire, $objet, $message, $headers)) // Envoi du message
{
    echo 'Votre message a bien été envoyé ';
}
else // Non envoyé
{
    echo "Votre message n'a pas pu être envoyé";
}