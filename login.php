<?php 

namespace fxc; // pas terrible mais c'est le seul moyen...
require_once 'fxc/xhtml5.php';
require_once 'templates.php';
require_once 'session.php';

error_reporting(E_ALL);
ini_set('display_errors', 'On');

$user = session();

echo "<!DOCTYPE html>";
echoXml( page('connexion', 'form', loginForm( isset($_GET['bad']) )) );

