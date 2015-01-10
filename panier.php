<?php 

require_once 'fxc/xhtml5.php';
require_once 'templates.php';
require_once 'Data.php';
require_once 'session.php';
require_once 'utils.php';

$idEnregistrement = reqGET('id');

session();

$data = new Data();

if(isset($_GET['delete'])) {

   $data->delete($idEnregistrement, $_SESSION["Code_Abonne"]);
}
else {

   $data->add($idEnregistrement, $_SESSION["Code_Abonne"]);
}

