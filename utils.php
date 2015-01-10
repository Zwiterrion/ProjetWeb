<?php

function optGET($k,$else) {
   return (isset($_GET[$k])) ? $_GET[$k] : $else;
}

function optPOST($k,$else) {
   return (isset($_POST[$k])) ? $_POST[$k] : $else;
}


function reqGET($k) {
   if (isset($_GET[$k]))
      return $_GET[$k];
   else
   {
      echo "\n\n\"$k\" requis (reqGET), je décède.\n";
      die;
   }
}

function reqPOST($k) {
   if (isset($_POST[$k]))
      return $_POST[$k];
   else
   {
      echo "\n\n\"$k\" requis (reqPOST), je décède.\n";
      die;
   }
}

function filtersUrl($filters)
{
   $res = '';
   foreach($filters as $k => $v)
   {
      $res .= "$k=$v&";
   }
   return substr($res,0,-1);
}
