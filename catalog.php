<?php

require_once 'fxc/xhtml5.php';
require_once 'templates.php';
require_once 'Data.php';
require_once 'session.php';
require_once 'utils.php';

$user = session();

function addF(&$filters, $field, $arg) {
   if (isset($_GET[$arg]))
      $filters[$field] = (int) $_GET[$arg];
}

$filters = [];
addF($filters, 'Musicien.Code_Musicien'     , 'composer');
addF($filters, 'Oeuvre.Code_Oeuvre'         , 'work'    );
addF($filters, 'Album.Code_Album'           , 'album'   );
addF($filters, 'Enregistrement.Code_Morceau', 'record'  );

$search = optGET('search','');
$data = new \Data();
$composers = $data -> catalog(\Data::COMPOSERS, $search, $filters);
$works     = $data -> catalog(\Data::WORKS    , $search, $filters);
$albums    = $data -> catalog(\Data::ALBUMS   , $search, $filters);
$records   = $data -> catalog(\Data::RECORDS  , $search, $filters);
$data = null;


$body = fxc\catalogHtml($composers, $works, $albums, $records);

echo "<!DOCTYPE html>";
fxc\echoXml( fxc\page("e-Music", '', $body, $user));















