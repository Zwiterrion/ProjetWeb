<?php 

namespace fxc; // pas terrible mais c'est le seul moyen...
require_once 'fxc/xhtml5.php';
require_once 'templates.php';
require_once 'session.php';

error_reporting(E_ALL);
ini_set('display_errors', 'On');

$user = session();

echo "<!DOCTYPE html>";

$error = '';

if(isset($_GET['errorLogin'])) {
   $error = "le login ne doit pas dépasser 10 caractères";
}
if(isset($_GET['errorPassword'])) {
   $error .=  "les mots de passe doivent être identiques"; 
} 
if(isset($_GET['errorDejaPris'])) {
   $error .= "le login est déjà utilisé"; 
} 
if(isset($_GET['errorMissing'])) {
   $error .= "tout les champs doivent être remplis"; 
} 


echoXml( page('inscription', 'form', registerForm($error)));


