<?php

//namespace fxc;
use \PDO;

class Data {
  
   const COMPOSERS  = "
 SELECT distinct Musicien.Code_Musicien as id, Prénom_Musicien as str1, Nom_Musicien as str2, '' as str3
 FROM Musicien	INNER JOIN Composer on Musicien.Code_Musicien = Composer.Code_Musicien

				LEFT  JOIN Oeuvre             on Composer.Code_Oeuvre = Oeuvre.Code_Oeuvre
				LEFT  JOIN Composition_Oeuvre on Oeuvre.Code_Oeuvre = Composition_Oeuvre.Code_Oeuvre
				LEFT  JOIN Composition        on Composition_Oeuvre.Code_Composition = Composition.Code_Composition
				LEFT  JOIN Enregistrement     on Composition.Code_Composition = Enregistrement.Code_Composition
				LEFT  JOIN Composition_Disque on Enregistrement.Code_Morceau = Composition_Disque.Code_Morceau
				LEFT  JOIN Disque             on Composition_Disque.Code_Disque = Disque.Code_Disque
				LEFT  JOIN Album              on Disque.Code_Album = Album.Code_Album
";

   const WORKS = "
 SELECT distinct Oeuvre.Code_Oeuvre as id, Titre_Oeuvre as str1, Sous_Titre as str2, '' as str3
 FROM Oeuvre		LEFT  JOIN Composer           on Oeuvre.Code_Oeuvre = Composer.Code_Oeuvre
				LEFT  JOIN Musicien           on Composer.Code_Musicien = Musicien.Code_Musicien

				LEFT  JOIN Composition_Oeuvre on Oeuvre.Code_Oeuvre = Composition_Oeuvre.Code_Oeuvre
				LEFT  JOIN Composition        on Composition_Oeuvre.Code_Composition = Composition.Code_Composition
				LEFT  JOIN Enregistrement     on Composition.Code_Composition = Enregistrement.Code_Composition
				LEFT  JOIN Composition_Disque on Enregistrement.Code_Morceau = Composition_Disque.Code_Morceau
				LEFT  JOIN Disque             on Composition_Disque.Code_Disque = Disque.Code_Disque
				LEFT  JOIN Album              on Disque.Code_Album = Album.Code_Album
";

   const ALBUMS = "
 SELECT distinct Album.Code_Album as id, Album.Titre_Album as str1, '' as str2, '' as str3
 FROM Album		LEFT JOIN Disque             on Album.Code_Album = Disque.Code_Album
				LEFT JOIN Composition_Disque on Disque.Code_Disque = Composition_Disque.Code_Disque
				LEFT JOIN Enregistrement     on Composition_Disque.Code_Morceau = Enregistrement.Code_Morceau
				LEFT JOIN Composition        on Enregistrement.Code_Composition = Composition.Code_Composition
				LEFT JOIN Composition_Oeuvre on Composition.Code_Composition = Composition_Oeuvre.Code_Composition
				LEFT JOIN Oeuvre             on Composition_Oeuvre.Code_Oeuvre = Oeuvre.Code_Oeuvre
				LEFT JOIN Composer           on Oeuvre.Code_Oeuvre = Composer.Code_Oeuvre
				LEFT JOIN Musicien           on Composer.Code_Musicien = Musicien.Code_Musicien
";

   const RECORDS = "
 SELECT distinct Enregistrement.Code_Morceau as id, Album.Titre_Album as str1, '' as str2, '' as str3
 FROM Enregistrement	LEFT JOIN Composition_Disque on Enregistrement.Code_Morceau = Composition_Disque.Code_Morceau
					LEFT JOIN Disque             on Composition_Disque.Code_Disque = Disque.Code_Disque
					LEFT JOIN Album              on Disque.Code_Album = Album.Code_Album

					LEFT JOIN Composition        on Enregistrement.Code_Composition = Composition.Code_Composition
					LEFT JOIN Composition_Oeuvre on Composition.Code_Composition = Composition_Oeuvre.Code_Composition
					LEFT JOIN Oeuvre             on Composition_Oeuvre.Code_Oeuvre = Oeuvre.Code_Oeuvre
					LEFT JOIN Composer           on Oeuvre.Code_Oeuvre = Composer.Code_Oeuvre
					LEFT JOIN Musicien           on Composer.Code_Musicien = Musicien.Code_Musicien
";
  

   var $dbh;

   public function __construct() {
    
      $this->dbh = new PDO("dblib:Server=125.0.0.1:4242;Database=Classique", "ETD", "ETD");

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


   function catalog($query, $search, $filters)
   {
      //if (ctype_space($search))
	// $search = '';
	 
      $query .= "\n WHERE 1=1";
      
      foreach ($filters as $k => $v)
      {
	 $query .= "\n AND $k = ?";
      }

      if ($search == '')
	 $query .= "\n ORDER BY str1, str2, str3";
    
    $query .= ';';

      //$q = $this->dbh->prepare($query);
    $q = $this->dbh->query($query);
      //$q->execute($filters);

    
    echo $query;
    var_dump($q->fetchAll());

      $res = new SortedList();
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
	 while ($row = $q->fetch())
	    $res -> push([-1, $row]);

      $q -> closeCursor();
      return $res;
   }


}



class SortedList extends SplDoublyLinkedList
{
   var $Max = 20;

   public function addSorted($k, $v)
   {
      foreach($this as $i => $item)
      {
	 if ($item[0] < $k)
	    break;
      }

      add($i, [$k,$v]);

      if (count() > $Max)
	 pop();
   }
}
