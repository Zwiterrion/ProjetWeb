<?php
    
    namespace fxc; // pas terrible mais c'est le seul moyen...
    require_once 'fxc/xhtml5.php';
    require_once 'templates.php';

    require('Data.php');
    
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');
    
    echo "<!DOCTYPE html>";
    


$test = concat("kikoo", p("tamere"));
    
    echoXml( page("e-Music", '', $test));
    

    $d = new Data();
    $arrayM = $d->getAllMusicians('A');
    
    foreach ($arrayM as $value) {
        echo $value['Nom_Musicien'];
    }
    
?>


