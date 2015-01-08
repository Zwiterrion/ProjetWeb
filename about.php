<?php
    
    namespace fxc;
    require_once 'fxc/xhtml5.php';
    require_once 'templates.php';
    require_once 'session.php';
    
    $user = session();

    $explication = p(class_('commantaire'),"Ce site a été développé par Timothée JOURDE et Etienne ANNE, dans le cadre du module web de l'IUT informatique. Ce site a été développé en PHP , HTML et CSS et utilise une base répertoriant des musiciens.");
    
    echo "<!DOCTYPE html>";
    echoXml( page("e-Music", '', $explication, $user));
    
    
?>