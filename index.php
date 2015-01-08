<?php

namespace fxc;
require_once 'fxc/xhtml5.php';
require_once 'templates.php';
require_once 'session.php';

error_reporting(E_ALL);
ini_set('display_errors', 'On');

$user = session();

$spotlight = div(id('barre'),form(class_('big_search'),method('GET'),action('catalog.php'),
    div(input(type('text'),name('search'),class_('search'),placeholder('Que voulez-vous ')),
      input(type('button'),class_('search_button')))));

echo "<!DOCTYPE html>";
echoXml( page("e-Music", '', $spotlight, $user));


?>


