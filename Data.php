<?php

namespace fxc;
    use \PDO;
    
class Data {
    
    var $dbh;

    public function __construct() {
        
        $this->dbh = new PDO("sqlsrv:Server=INFO-SIMPLET;Database=Classique", "ETD", "ETD");

    }

    function getAllMusicians($letter) {
        
        $arrayMusicians = array();
        $requete = $this->dbh->prepare("Select * from Musicien where Nom_Musicien LIKE :nom  order by Nom_Musicien");
        $requete->execute(array(':nom' => $letter.'%'));
        while ($row = $requete->fetch()){
            $arrayMusicians[] = $row;
        }
        return $arrayMusicians;
    }

    function __toString() {
        return "ICI";
    }
}
    


?>
