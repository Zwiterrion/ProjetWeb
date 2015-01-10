-- Compositeurs
SELECT distinct Musicien.Code_Musicien as id, Prénom_Musicien as str1, Nom_Musicien as str2, '' as str3
FROM Musicien	INNER JOIN Composer on Musicien.Code_Musicien = Composer.Code_Musicien

				LEFT  JOIN Oeuvre             on Composer.Code_Oeuvre = Oeuvre.Code_Oeuvre
				LEFT  JOIN Composition_Oeuvre on Oeuvre.Code_Oeuvre = Composition_Oeuvre.Code_Oeuvre
				LEFT  JOIN Composition        on Composition_Oeuvre.Code_Composition = Composition.Code_Composition
				LEFT  JOIN Enregistrement     on Composition.Code_Composition = Enregistrement.Code_Composition
				LEFT  JOIN Composition_Disque on Enregistrement.Code_Morceau = Composition_Disque.Code_Morceau
				LEFT  JOIN Disque             on Composition_Disque.Code_Disque = Disque.Code_Disque
				LEFT  JOIN Album              on Disque.Code_Album = Album.Code_Album

WHERE 1=1
-- and Musicien.Code_Musicien      = 18
-- and Oeuvre.Code_Oeuvre          = 2331
-- and Album.Code_Album            = 
-- and Enregistrement.Code_Morceau = 
ORDER BY str1, str2, str3







-- Oeuvres
SELECT distinct Oeuvre.Code_Oeuvre as id, Titre_Oeuvre as str1, Sous_Titre as str2, '' as str3
FROM Oeuvre		LEFT  JOIN Composer           on Oeuvre.Code_Oeuvre = Composer.Code_Oeuvre
				LEFT  JOIN Musicien           on Composer.Code_Musicien = Musicien.Code_Musicien

				LEFT  JOIN Composition_Oeuvre on Oeuvre.Code_Oeuvre = Composition_Oeuvre.Code_Oeuvre
				LEFT  JOIN Composition        on Composition_Oeuvre.Code_Composition = Composition.Code_Composition
				LEFT  JOIN Enregistrement     on Composition.Code_Composition = Enregistrement.Code_Composition
				LEFT  JOIN Composition_Disque on Enregistrement.Code_Morceau = Composition_Disque.Code_Morceau
				LEFT  JOIN Disque             on Composition_Disque.Code_Disque = Disque.Code_Disque
				LEFT  JOIN Album              on Disque.Code_Album = Album.Code_Album

-- WHERE ...
ORDER BY str1, str2, str3







-- Album
SELECT distinct Album.Code_Album as id, Album.Titre_Album as str1, '' as str2, '' as str3
FROM Album		LEFT JOIN Disque             on Album.Code_Album = Disque.Code_Album
				LEFT JOIN Composition_Disque on Disque.Code_Disque = Composition_Disque.Code_Disque
				LEFT JOIN Enregistrement     on Composition_Disque.Code_Morceau = Enregistrement.Code_Morceau
				LEFT JOIN Composition        on Enregistrement.Code_Composition = Composition.Code_Composition
				LEFT JOIN Composition_Oeuvre on Composition.Code_Composition = Composition_Oeuvre.Code_Composition
				LEFT JOIN Oeuvre             on Composition_Oeuvre.Code_Oeuvre = Oeuvre.Code_Oeuvre
				LEFT JOIN Composer           on Oeuvre.Code_Oeuvre = Composer.Code_Oeuvre
				LEFT JOIN Musicien           on Composer.Code_Musicien = Musicien.Code_Musicien
-- WHERE ...
ORDER BY str1, str2, str3





-- Morceau
SELECT distinct Enregistrement.Code_Morceau as id, Album.Titre_Album as str1, '' as str2, '' as str3
FROM Enregistrement	LEFT JOIN Composition_Disque on Enregistrement.Code_Morceau = Composition_Disque.Code_Morceau
					LEFT JOIN Disque             on Composition_Disque.Code_Disque = Disque.Code_Disque
					LEFT JOIN Album              on Disque.Code_Album = Album.Code_Album

					LEFT JOIN Composition        on Enregistrement.Code_Composition = Composition.Code_Composition
					LEFT JOIN Composition_Oeuvre on Composition.Code_Composition = Composition_Oeuvre.Code_Composition
					LEFT JOIN Oeuvre             on Composition_Oeuvre.Code_Oeuvre = Oeuvre.Code_Oeuvre
					LEFT JOIN Composer           on Oeuvre.Code_Oeuvre = Composer.Code_Oeuvre
					LEFT JOIN Musicien           on Composer.Code_Musicien = Musicien.Code_Musicien
-- WHERE ...
ORDER BY str1, str2, str3
