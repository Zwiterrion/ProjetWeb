<?php
    
    namespace fxc; // pas terrible mais c'est le seul moyen...
    require_once 'fxc/xhtml5.php';
    require_once 'templates.php';
    
    require('Data.php');
    
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');
    
    echo "<!DOCTYPE html>";
    
    
    echoXml( page("e-Music", '', ''));
    
    
    $d = new Data();
    $arrayM = $d->getAllMusicians('A');
    
    
    foreach ($arrayM as $value) {
        echo '<li>'.$value['Nom_Musicien'].'<li>';
    }
    
    
    ?>










