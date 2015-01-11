<?php 

require_once 'Data.php';

$access = new Data();

$code =  $_GET['code'];
$param = $_GET['param'];

switch ($param) {
   case '1':
   $access->echoImageComposer($code);
   break;
   case '2':
   $access->echoImageAlbum($code);
   break;
   case '3':
   $access->echoRecord($code);
   break;
   default:
   # code...
   break;
}

$access = null;


