<?php
    
namespace fxc;
require_once 'fxc/xhtml5.php';
require_once 'templates.php';
require_once 'Data.php';

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


$body = catalogHtml($composers, $works, $albums, $records);
    
echo "<!DOCTYPE html>";
echoXml( page("e-Music", '', $body));
    
    












