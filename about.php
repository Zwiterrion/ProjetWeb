<?php
    
    namespace fxc;
    require_once 'fxc/xhtml5.php';
    require_once 'templates.php';
    require_once 'session.php';
    
    $user = session();

    $explication = Ul(class_('commantaire'),
    						h1("Introduction"),
    		Li("Ce site a été développé par Timothée JOURDE et Etienne ANNE, dans le cadre du module web de l'IUT informatique."),
    		Li("Ce site a été développé en PHP , HTML et CSS et utilise une base répertoriant des musiciens."),
    						h1("Fonctionnement du site"),
    		Li("Pour commencer, il faut faire une recherche depuis la page d'accueil."),
    		Li("Les résultas enfin trouvés, ils sont dispersés en 4 catégories."),
    		Li("Lors d'un clic sur une colonne, la colonne est sélectionné entrainant la mise à jour des trois autres colonnes en prenant en compte le clic."),
    						h1("Exemple"),
    		Li("Exemple : Un clic sur le compositeur Mozart, permet d'afficher Mozart comme seul compositeur dans la colonne compositeur et d'affiche ses oeuvres,a lbums et enregistrements dans les autres colonnes."),				
    						h1("Fonction de recherche"),
    		Li("La fonction de recherche du site est un peu longue c'est tout simplement parce qu'elle classe les résultats par pertinence."),
    						h1("Amazon"),
    		Li("En même temps que la recherche, une recherche sur Amazon est effectuée permettant de voir le sarticles correspodant sur Amazon."),
    		Li("Ce site a été développé en PHP , HTML et CSS et utilise une base répertoriant des musiciens."),
    		Li("Ce site a été développé en PHP , HTML et CSS et utilise une base répertoriant des musiciens."));
    		 
    
    echo "<!DOCTYPE html>";
    echoXml( page("e-Music", '', $explication, $user));
    
    
?>