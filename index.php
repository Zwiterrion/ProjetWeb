<?php
    
    namespace fxc; // pas terrible mais c'est le seul moyen...
    require_once 'fxc/xhtml5.php';
    require_once 'templates.php';
    
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');
    
    echo "<!DOCTYPE html>";
    
    $spotlight = form(class_('big_search'),div(
                      input(type('text'),class_('search'),placeholder('Que voulez-vous ')),
                      input(type('button'),class_('search_button'))));
    

    echoXml( page("e-Music", '', $spotlight));
    
    
?>


