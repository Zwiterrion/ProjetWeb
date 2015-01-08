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
        $error = "Le login ne doit pas dépasser 10 caractères";
    }
    if(isset($_GET['errorPassword'])) {
       $error .=  "Les mots de passe doivent être identiques"; 
    } 
    if(isset($_GET['errorDejaPris'])) {
       $error .= "Le login est déjà utilisé"; 
    } 

    if($error != '')
      $error = p(class_('error'), $error);
    
    $formLogin = form(action('checkConnexion.php'),method('POST'),class_('inscription'),div(
      h1('Inscription'),
      $error,
      input(class_('inscrip_item'),name('email'),type('text'),class_(''),placeholder('Nom')),
      input(class_('inscrip_item'),name('pseudo'),type('text'),class_(''),placeholder('Login (< 10 caractères)')),
      input(class_('inscrip_item'),name('password'),type('password'),class_(''),placeholder('Mot de passe')),
      input(class_('inscrip_item'),name('password_verif'),type('password'),class_(''),placeholder('Retapez votre mot de passe')),

      input(class_('connexion_item'),type('submit'),value("Connexion"))));

      echoXml( page("e-Music", '', $formLogin, $user));


    ?>