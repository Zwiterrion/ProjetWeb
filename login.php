<?php 
	
    namespace fxc; // pas terrible mais c'est le seul moyen...
    require_once 'fxc/xhtml5.php';
    require_once 'templates.php';
    require_once 'session.php';
    
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');
    
    $user = session();
    
    echo "<!DOCTYPE html>";
   
    $formLogin = form(action('checkLogin.php'),method('POST'),class_('inscription'),div(
                      h1('Se connecter'),
                      //A(class_('pas_inscrit'),href('inscrption.php'), 'Pas encore inscrit ?'),
                      input(class_('inscrip_item'),name('pseudo'),type('text'),class_(''),placeholder('Nom utilisateur')),
                      input(class_('inscrip_item'),name('password'),type('password'),class_(''),placeholder('Mot de passe')),
                      input(class_('connexion_item'),type('submit'),value("Connexion")),
                      A(class_('connexion_item'),href('inscription.php'), 'Inscription')));

    echoXml( page("e-Music", '', $formLogin, $user));



?>