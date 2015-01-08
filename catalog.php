<?php
  
    namespace fxc;
    require_once 'fxc/xhtml5.php';
    require_once 'templates.php';
    require_once 'session.php';

    $user = session();

    error_reporting(E_ALL);
    ini_set('display_errors', 'On');    

    echo "<!DOCTYPE html>";
    echoXml( page("e-Music", '', '', $user));   
    










