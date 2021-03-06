<?php

require_once 'list.php';
require_once 'search.php';
use \PDO;

class Data {
  
   const COMPOSERS  = "
 SELECT distinct Musicien.Code_Musicien as id, Prénom_Musicien as str1, Nom_Musicien as str2, '' as str3
 FROM Musicien INNER JOIN Composer on Musicien.Code_Musicien = Composer.Code_Musicien

				LEFT  JOIN Oeuvre             on Composer.Code_Oeuvre = Oeuvre.Code_Oeuvre
				LEFT  JOIN Composition_Oeuvre on Oeuvre.Code_Oeuvre = Composition_Oeuvre.Code_Oeuvre
				LEFT  JOIN Composition        on Composition_Oeuvre.Code_Composition = Composition.Code_Composition
				LEFT  JOIN Enregistrement     on Composition.Code_Composition = Enregistrement.Code_Composition
				LEFT  JOIN Composition_Disque on Enregistrement.Code_Morceau = Composition_Disque.Code_Morceau
				LEFT  JOIN Disque             on Composition_Disque.Code_Disque = Disque.Code_Disque
				LEFT  JOIN Album              on Disque.Code_Album = Album.Code_Album

                                LEFT JOIN Achat  on Enregistrement.Code_Morceau = Achat.Code_Enregistrement
                                LEFT JOIN Abonné on Achat.Code_Abonné = Abonné.Code_Abonné
";

   const WORKS = "
 SELECT distinct Oeuvre.Code_Oeuvre as id, Titre_Oeuvre as str1, Sous_Titre as str2, '' as str3
 FROM Oeuvre	                LEFT  JOIN Composer           on Oeuvre.Code_Oeuvre = Composer.Code_Oeuvre
				LEFT  JOIN Musicien           on Composer.Code_Musicien = Musicien.Code_Musicien

				LEFT  JOIN Composition_Oeuvre on Oeuvre.Code_Oeuvre = Composition_Oeuvre.Code_Oeuvre
				LEFT  JOIN Composition        on Composition_Oeuvre.Code_Composition = Composition.Code_Composition
				LEFT  JOIN Enregistrement     on Composition.Code_Composition = Enregistrement.Code_Composition
				LEFT  JOIN Composition_Disque on Enregistrement.Code_Morceau = Composition_Disque.Code_Morceau
				LEFT  JOIN Disque             on Composition_Disque.Code_Disque = Disque.Code_Disque
				LEFT  JOIN Album              on Disque.Code_Album = Album.Code_Album

                                LEFT JOIN Achat  on Enregistrement.Code_Morceau = Achat.Code_Enregistrement
                                LEFT JOIN Abonné on Achat.Code_Abonné = Abonné.Code_Abonné
";

   const ALBUMS = "
 SELECT distinct Album.Code_Album as id, Album.Titre_Album as str1, '' as str2, '' as str3
 FROM Album                     LEFT JOIN Disque             on Album.Code_Album = Disque.Code_Album
				LEFT JOIN Composition_Disque on Disque.Code_Disque = Composition_Disque.Code_Disque
				LEFT JOIN Enregistrement     on Composition_Disque.Code_Morceau = Enregistrement.Code_Morceau
				LEFT JOIN Composition        on Enregistrement.Code_Composition = Composition.Code_Composition
				LEFT JOIN Composition_Oeuvre on Composition.Code_Composition = Composition_Oeuvre.Code_Composition
				LEFT JOIN Oeuvre             on Composition_Oeuvre.Code_Oeuvre = Oeuvre.Code_Oeuvre
				LEFT JOIN Composer           on Oeuvre.Code_Oeuvre = Composer.Code_Oeuvre
				LEFT JOIN Musicien           on Composer.Code_Musicien = Musicien.Code_Musicien

                                LEFT JOIN Achat  on Enregistrement.Code_Morceau = Achat.Code_Enregistrement
                                LEFT JOIN Abonné on Achat.Code_Abonné = Abonné.Code_Abonné

";

   public static function RECORDS($userId) {
      $sub    = '';
      $select = '';

      if ($userId != false)
      {
         $userId = (int) $userId;
         $select = ", cart.cartId";
         $sub    = "
      LEFT JOIN ( SELECT Achat.Code_Enregistrement as cartId
                  FROM Achat INNER JOIN Abonné ON Abonné.Code_Abonné = Achat.Code_Abonné
                  WHERE Abonné.Code_Abonné = $userId ) as cart
           ON Enregistrement.Code_Morceau = cart.cartId
";
      }
      

      return "
 SELECT distinct Enregistrement.Code_Morceau as id, Enregistrement.Titre as str1, '' as str2, '' as str3 $select
 FROM Enregistrement                    LEFT JOIN Composition_Disque on Enregistrement.Code_Morceau = Composition_Disque.Code_Morceau
					LEFT JOIN Disque             on Composition_Disque.Code_Disque = Disque.Code_Disque
					LEFT JOIN Album              on Disque.Code_Album = Album.Code_Album

					LEFT JOIN Composition        on Enregistrement.Code_Composition = Composition.Code_Composition
					LEFT JOIN Composition_Oeuvre on Composition.Code_Composition = Composition_Oeuvre.Code_Composition
					LEFT JOIN Oeuvre             on Composition_Oeuvre.Code_Oeuvre = Oeuvre.Code_Oeuvre
					LEFT JOIN Composer           on Oeuvre.Code_Oeuvre = Composer.Code_Oeuvre
					LEFT JOIN Musicien           on Composer.Code_Musicien = Musicien.Code_Musicien

                                        LEFT JOIN Achat  on Enregistrement.Code_Morceau = Achat.Code_Enregistrement
                                        LEFT JOIN Abonné on Achat.Code_Abonné = Abonné.Code_Abonné
                                        $sub
";}
  
   var $dbh;

   public function __construct() {
      $this->dbh = new PDO("sqlsrv:Server=INFO-SIMPLET;Database=Classique_Web", "ETD", "ETD");
      //$this->dbh = new PDO("dblib:host=info-simplet;dbname=Classique_Web", "ETD", "ETD");
   }

   public function delete($id, $codeAbonne) {

      $stmt = $this->dbh->prepare("DELETE FROM Achat WHERE Code_Enregistrement = ? AND Code_Abonné = ? ");
      $stmt->execute([$id,$codeAbonne]);
      $stmt->closeCursor();
   }

   public function add($id, $codeAbonne) {

      $stmt = $this->dbh->prepare("INSERT INTO Achat(Code_Enregistrement, Code_Abonné) VALUES (?,?) ");
      $stmt->execute([$id,$codeAbonne]);
      //echo "\n($id, $codeAbonne)\n";
      $stmt->closeCursor();
   }

   public function insertIntoBase($login, $pass, $nom) {

      $stmt = $this->dbh->prepare('SELECT * FROM Abonné WHERE Login = :pseudo');        
      $stmt->bindParam(':pseudo', $login);
      $stmt->execute();

      $requeteCount = $stmt->rowCount();
      $stmt -> closeCursor();
        
      if($requeteCount == 0){

	 $stmt = $this->dbh->prepare("INSERT INTO Abonné(Nom_Abonné,Login,Password) VALUES (?,?,?)");
	 $stmt->execute([$nom,$login,$pass]);
         $stmt->closeCursor();

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
         $stmt->closeCursor();
	 return false;
      }
      else  
      {
	 $row = $stmt->fetch();
         $stmt->closeCursor();
	 return $row[0];
      }
   }

   public function echoImageComposer($code) {

      $stmt = $this->dbh->prepare("SELECT Photo FROM Musicien WHERE Code_Musicien=?");
      $stmt->execute(array($code));
      $stmt->bindColumn(1, $lob, PDO::PARAM_LOB);
      $stmt->fetch(PDO::FETCH_BOUND);

      $image = pack("H*", $lob);
      header("Content-Type: image/jpeg");
      echo $image;
      $stmt->closeCursor();
      $stmt = null;
   }
   public function echoImageAlbum($code) {

      $stmt = $this->dbh->prepare("SELECT Pochette FROM Album WHERE Code_Album=?");
      $stmt->execute(array($code));
      $stmt->bindColumn(1, $lob, PDO::PARAM_LOB);
      $stmt->fetch(PDO::FETCH_BOUND);

      $image = pack("H*", $lob);
      header("Content-Type: image/jpeg");
      echo $image;
      $stmt->closeCursor();
      $stmt = null;
   }
   public function echoRecord($code) {

      $stmt = $this->dbh->prepare("SELECT Extrait FROM Enregistrement WHERE Code_Morceau=?");
      $stmt->execute(array($code));
      $stmt->bindColumn(1, $lob, PDO::PARAM_LOB);
      $stmt->fetch(PDO::FETCH_BOUND);

      $image = pack("H*", $lob);
      header("Content-Type: audio/mpeg");
      echo $image;
      $stmt->closeCursor();
      $stmt = null;
   }

   public function catalog($query, $search, $filters)
   {
      if (ctype_space($search))
	 $search = '';

      $query .= "\n WHERE 1=1";

      foreach ($filters as $k => $v)
      {
	 $query .= "\n AND $k = ?";
      }
      
      if ($search == '')
	 $query .= "\n ORDER BY str1, str2, str3";
      
      
      //echo "\n<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<\n\n$query\n\n>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>\n";
      
      $q = $this->dbh->prepare($query);
      $q->execute(array_values($filters));
      
      $res = new SortedList();

      if (count($filters) == 0)
         $res->Max = 15;
      else
         $res->Max = 50;

      if ($search != '')
	 while ($row = $q->fetch())
	 {
	    $score = max( fit($search, $row['str1'])
			  ,fit($search, $row['str2'])
			  ,fit($search, $row['str3'])
	       );
	    
	    $res -> addSorted($score, $row);
	 }
      else
	 while (($row = $q->fetch()) && $res->count() <= $res->Max)
	    $res -> push(new KeyValue(-1, $row));
      
      $q->closeCursor();
      return $res;
   }
}
