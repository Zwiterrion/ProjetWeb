<?php

require_once 'fxc/xhtml5.php';
require_once 'templates.php';
require_once 'Data.php';
require_once 'session.php';

$user = session();

function addF(&$filters, $field, $arg) {
 if (isset($_GET[$arg]))
  $filters[$field] = $_GET[$arg];
}

$filters = [];
addF($filters, 'Musicien.Code_Musicien'     , 'composer');
addF($filters, 'Oeuvre.Code_Oeuvre'         , 'work'    );
addF($filters, 'Album.Code_Album'           , 'album'   );
addF($filters, 'Enregistrement.Code_Morceau', 'record'  );

$data = new \Data();
$composers = $data -> catalog(\Data::COMPOSERS, $_GET['search'], $filters);
$works     = $data -> catalog(\Data::WORKS    , $_GET['search'], $filters);
$albums    = $data -> catalog(\Data::ALBUMS   , $_GET['search'], $filters);
$records   = $data -> catalog(\Data::RECORDS  , $_GET['search'], $filters);
$data = null;



$body = fxc\catalogHtml($composers, $works, $albums, $records);

echo "<!DOCTYPE html>";
fxc\echoXml( fxc\page("e-Music", '', $body, $user));















