<?php

require_once 'fxc/xhtml5.php';
require_once 'templates.php';
require_once 'Data.php';
require_once 'session.php';
require_once 'utils.php';
require_once 'amazon/samples/Search/SimpleSearch.php';

$user = session();

function addF(&$filtersdb, &$filters, $field, $arg) {
   if (isset($_GET[$arg]))
   {
      $v = (int) $_GET[$arg];
      $filtersdb[$field] = $v;
      $filters[$arg] = $v;
   }
}

$filters   = [];
$filtersdb = [];
addF($filtersdb, $filters, 'Musicien.Code_Musicien'     , 'composer');
addF($filtersdb, $filters, 'Oeuvre.Code_Oeuvre'         , 'work'    );
addF($filtersdb, $filters, 'Album.Code_Album'           , 'album'   );
addF($filtersdb, $filters, 'Enregistrement.Code_Morceau', 'record'  );

$search = optGET('search','');
if ($search != '')
   $filters['search'] = $search;


$cart = false;
if ($user != [])
{
   if (isset($_GET['cart']))
      $filtersdb['Abonné.Code_Abonné'] = (int) $_SESSION["Code_Abonne"];
   else
      $cart = true;
}


$body      = '';
$bodyclass = '';
if ($filters == [] && ! isset($_GET['cart']))
{
   $body = '';
   $bodyclass = 'welcome';
}
else
{
   $userId = (isset($_SESSION['Code_Abonne'])) ? (int) $_SESSION['Code_Abonne'] : false;

   $data = new \Data();
   $composers = $data -> catalog(\Data::COMPOSERS       , $search, $filtersdb);
   $works     = $data -> catalog(\Data::WORKS           , $search, $filtersdb);
   $albums    = $data -> catalog(\Data::ALBUMS          , $search, $filtersdb);
   $records   = $data -> catalog(\Data::RECORDS($userId), $search, $filtersdb);
   $data = null;

   $catalog = \fxc\catalogHtml($composers, $works, $albums, $records, $filters, $user != []);

   $as = ($composers->count() > 0) ? $composers->First->Elem->Value['str2'] : 'symphonique';
   $amazon = fxc\amazonHtml( search_amazon($as) );

   $body = fxc\concat($catalog, $amazon);
}


$body = fxc\concat(fxc\ctrlBar($filters, $cart, $user), $body);

echo "<!DOCTYPE html>";
fxc\echoXml( fxc\page('', $bodyclass, $body));


