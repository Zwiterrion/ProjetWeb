<?php 

require_once 'fxc/xhtml5.php';
require_once 'templates.php';
require_once 'Data.php';
require_once 'session.php';    

$user = session();

if($_POST['password'] != '' && $_POST['pseudo'] != '') {
   
   $password = $_POST['password'];
   $login = $_POST['pseudo'];
   
   $accessBase = new Data();
   $result = $accessBase->checkIntoBase($login, $password);

   if($result === false) {
      header('Location: login.php?bad');
      exit();    
   }
   else {

      $_SESSION['NAME_USER'] = $login;
      $_SESSION['PASSWORD'] = $password;
      $_SESSION['Code_Abonne'] = (int) $result;

      header('Location: index.php');
      exit(); 
   }
}

echo "<!DOCTYPE html>";
echoXml( page("e-Music", '', '', $user));



