-- Compositeurs
SELECT distinct Musicien.Code_Musicien as idCompositeur, Oeuvre.Code_Oeuvre as idOeuvre, Album.Code_Album as idAlbum, Enregistrement.Code_Morceau as idMorceaux
,Prénom_Musicien, Nom_Musicien
FROM Musicien	INNER JOIN Composer on Musicien.Code_Musicien = Composer.Code_Musicien

				LEFT  JOIN Oeuvre             on Composer.Code_Oeuvre = Oeuvre.Code_Oeuvre
				LEFT  JOIN Composition_Oeuvre on Oeuvre.Code_Oeuvre = Composition_Oeuvre.Code_Oeuvre
				LEFT  JOIN Composition        on Composition_Oeuvre.Code_Composition = Composition.Code_Composition
				LEFT  JOIN Enregistrement     on Composition.Code_Composition = Enregistrement.Code_Composition
				LEFT  JOIN Composition_Disque on Enregistrement.Code_Morceau = Composition_Disque.Code_Morceau
				LEFT  JOIN Disque             on Composition_Disque.Code_Disque = Disque.Code_Disque
				LEFT  JOIN Album              on Disque.Code_Album = Album.Code_Album

-- WHERE 1=1
-- and idCompositeur = 
-- and idOeuvre      = 
-- and idAlbum       = 
-- and idMorceaux    = 
ORDER BY Prénom_Musicien, Nom_Musicien







-- Oeuvres
SELECT Musicien.Code_Musicien as idCompositeur, distinct Oeuvre.Code_Oeuvre as idOeuvre, Album.Code_Album as idAlbum, Enregistrement.Code_Morceau as idMorceaux
,Titre_Oeuvre, Sous_Titre
FROM Oeuvre		LEFT  JOIN Composer           on Oeuvre.Code_Oeuvre = Composer.Code_Oeuvre
				LEFT  JOIN Musicien           on Composer.Code_Musicien = Musicien.Code_Musicien

				LEFT  JOIN Composition_Oeuvre on Oeuvre.Code_Oeuvre = Composition_Oeuvre.Code_Oeuvre
				LEFT  JOIN Composition        on Composition_Oeuvre.Code_Composition = Composition.Code_Composition
				LEFT  JOIN Enregistrement     on Composition.Code_Composition = Enregistrement.Code_Composition
				LEFT  JOIN Composition_Disque on Enregistrement.Code_Morceau = Composition_Disque.Code_Morceau
				LEFT  JOIN Disque             on Composition_Disque.Code_Disque = Disque.Code_Disque
				LEFT  JOIN Album              on Disque.Code_Album = Album.Code_Album

-- WHERE ...
ORDER BY Titre_Oeuvre, Sous_Titre







-- Album
SELECT Musicien.Code_Musicien as idCompositeur, Oeuvre.Code_Oeuvre as idOeuvre, distinct Album.Code_Album as idAlbum, Enregistrement.Code_Morceau as idMorceaux
,Album.Titre_Album
FROM Album		LEFT JOIN Disque             on Album.Code_Album = Disque.Code_Album
				LEFT JOIN Composition_Disque on Disque.Code_Disque = Composition_Disque.Code_Disque
				LEFT JOIN Enregistrement     on Composition_Disque.Code_Morceau = Enregistrement.Code_Morceau
				LEFT JOIN Composition        on Enregistrement.Code_Composition = Composition.Code_Composition
				LEFT JOIN Composition_Oeuvre on Composition.Code_Composition = Composition_Oeuvre.Code_Composition
				LEFT JOIN Oeuvre             on Composition_Oeuvre.Code_Oeuvre = Oeuvre.Code_Oeuvre
				LEFT JOIN Composer           on Oeuvre.Code_Oeuvre = Composer.Code_Oeuvre
				LEFT JOIN Musicien           on Composer.Code_Musicien = Musicien.Code_Musicien
-- WHERE ...
ORDER BY Album.Titre_Album
