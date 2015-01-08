<?php

use \PDO;

class Data {

    var $dbh;

    public function __construct() {
        $this->dbh = new PDO("sqlsrv:Server=INFO-SIMPLET;Database=Classique_Web", "ETD", "ETD");
    }

    public function delete($id, $codeAbonne) {

        $stmt = $this->dbh->prepare("DELETE FROM Abonné WHERE Code_Enregistrement = ? AND 'Code_Abonné' = ? ");
        $stmt->execute([$id,$codeAbonne]);
        $stmt->closeCursor();

    }

    public function add($id, $codeAbonne) {

        $stmt = $this->dbh->prepare("INSERT INTO Abonné(Code_Enregistrement, Code_Abonné) VALUES (?,?) ");
        $stmt->execute([$id,$codeAbonne]);
        $stmt->closeCursor();
    }

    public function insertIntoBase($login, $pass, $nom) {

        $stmt = $this->dbh->prepare('SELECT * FROM Abonné WHERE Login = :pseudo');        
        $stmt->bindParam(':pseudo', $login);
        $stmt->execute();

        $requeteCount = $stmt->rowCount();
        
        if($requeteCount == 0){


            $stmt = $this->dbh->prepare("INSERT INTO Abonné(Nom_Abonné,Login,Password) VALUES (?,?,?)");
            $stmt->execute([$nom,$login,$pass]);
            $this->dbh = null;      

            return true;   
        }
        else  
        {
            return false;
        }
    }

    public function checkIntoBase($login,$pass) {

        $stmt = $this->dbh->prepare('SELECT * FROM Abonné WHERE Login = :pseudo AND Password = :pass');
        $stmt->execute(array(':pseudo' => $login, 
            ':pass' => $pass));
        $result = $stmt->rowCount();

        if($result == 0) 
        {
            return false;
        }
        else  
        {
            $row = $stmt->fetch();
            return $row['Code_Abonné'];
        }

    }

    function getAllMusicians($letter) {

        $arrayMusicians = array();
        $requete = $this->dbh->prepare("Select * from Musicien where Nom_Musicien LIKE :nom  order by Nom_Musicien");
        $requete->execute(array(':nom' => $letter.'%'));
        while ($row = $requete->fetch()){
            $arrayMusicians[] = $row;
        }
        $requete->closeCursor();
        return $arrayMusicians;
    }

    public function echoImageComposer($code) {

        $stmt = $this->dbh->prepare("SELECT Photo FROM Musicien WHERE Code_Musicien=?");
        $stmt->execute(array($code));
        $stmt->bindColumn(1, $lob, PDO::PARAM_LOB);
        $stmt->fetch(PDO::FETCH_BOUND);

        $image = pack("H*", $lob);
        header("Content-Type: image/jpeg");
        echo $image;
    }
     public function echoImageAlbum($code) {

        $stmt = $this->dbh->prepare("SELECT Pochette FROM Album WHERE Code_Album=?");
        $stmt->execute(array($code));
        $stmt->bindColumn(1, $lob, PDO::PARAM_LOB);
        $stmt->fetch(PDO::FETCH_BOUND);

        $image = pack("H*", $lob);
        header("Content-Type: image/jpeg");
        echo $image;
    }
     public function echoRecord($code) {

        $stmt = $this->dbh->prepare("SELECT Extrait FROM Enregistrement WHERE Code_Morceau=?");
        $stmt->execute(array($code));
        $stmt->bindColumn(1, $lob, PDO::PARAM_LOB);
        $stmt->fetch(PDO::FETCH_BOUND);

        $image = pack("H*", $lob);
        header("Content-Type: audio/mpeg");
        echo $image;
    }
}
















