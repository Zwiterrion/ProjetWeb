<?php

namespace fxc; // pas terrible mais c'est le seul moyen...
require_once 'fxc/xhtml5.php';

function page($title, $bodyclass, $body)
{
   $title = ($title != '') ? ' · '.$title : '';

   
   return Html(lang('fr'),
               
               Head( Meta(charset('UTF-8')),
		     Link(rel('stylesheet'),href('all.css'), type('text/css')),
                     Script(type("text/javascript"), src("all.js"), async('async')),
		     Title('symphonaute'.$title)
	       ),
               
	       Body(class_($bodyclass), $body)
   );
}



function forH($es, $f)
{
   $res = '';
   foreach($es as $k => $v)
   {
      $res = concat($res, $f($k, $v));
   }
   return $res;
}

function catalogHtml($composers, $works, $albums, $records, $filters, $cart)
{
   $args = filtersUrl($filters);

   $c = Div(class_('col'),
            Div(H2('Compositeurs'), unsetFilterButton('composer',$filters)),
            Ul( forH($composers, function($k,$e) use($args) {
      
      $id = $e->Elem->Value['id'];
      $fname = $e->Elem->Value['str1'];
      if ($fname != '')
         $fname = concat($fname, Br());
      
      return Li(
         Span(class_('img'), style_("background-image: url(\"media.php?param=1&code=$id\");")),
         A( href("?composer=$id&$args"),
            $fname,
            $e->Elem->Value['str2']
         ));
            })));
   
   $w = Div(class_('col'),
            Div(H2('Œuvres'), unsetFilterButton('work',$filters)),
            Ul( forH($works, function($k,$e) use($args) {
      
      $id = $e->Elem->Value['id'];
      return Li( A(href("?work=$id&$args"),
                   $e->Elem->Value['str1'], Br(),
	           $e->Elem->Value['str2'] ));
      
            })));
   
   $a = Div(class_('col'),
            Div(H2('Albums'), unsetFilterButton('album',$filters)),
            Ul( forH($albums, function($k,$e) use($args) {
      
      $id = $e->Elem->Value['id'];
      return Li( Span(class_('img'), style_("background-image: url(\"media.php?param=2&code=$id\");")),
                 A(href("?album=$id&$args"), $e->Elem->Value['str1']) );
      
            })));
   
   $r = Div(class_('col'),
            Div(H2('Morceaux'), unsetFilterButton('record',$filters)),
            Ul( forH($records, function($k,$e) use($args,$cart) {
      
      $id = $e->Elem->Value['id'];
      return Li( A(class_('play'), onclick('this.firstChild.play()'), Audio(id((string)$id), Source(src('media.php?param=3&code='.$id), type('audio/mpeg')))),
                 ($cart) ? cartButton($id, isset($e->Elem->Value['cartId'])) : '',
	         A(href("?record=$id&$args"), $e->Elem->Value['str1']) );
            })));

   
   return Div(class_('catalog'), $c, $w, $a, $r);
}

function amazonHtml($a)
{
   return Div(class_('amazon'),h4("à voir sur amazon"),
              A(href($a[1]), Img(src($a[2])), Span($a[0])),
              A(href($a[4]), Img(src($a[5])), Span($a[3])),
              A(href($a[7]), Img(src($a[8])), Span($a[6])) );
   
}

function cartButton($id, $checked)
{
   $checked = ($checked) ? checked('checked') : '';

   return Form(class_('cart'), Input(type('checkbox'), $checked
                                     ,onclick("onCartButton(this,$id);")));
}

function unsetFilterButton($f,$filters)
{
   if (isset($filters[$f]))
   {
      unset($filters[$f]);
      return unsetFilterButton_($filters);
   }
   else
      return '';
}

function unsetFilterButton_($filters) {
   return A(class_('unsetFilter btn'), href('?'.filtersUrl($filters)), 'retirer le filtre');
}

function ctrlBar($filters, $cart, $user)
{
   $mLogin;
   if(isset($user['login'])) {
      $mLogin = A(class_('log'),href('logout.php'), 'déconnexion (' . $user['login'] . ')' );
   }
   else {
      $mLogin = A(class_('log'),href('login.php'), 'connexion');
   }


   $value = (isset($filters['search'])) ? $filters['search'] : '';
   $cart  = ($cart) ? A(class_('cart'), href('?cart'), 'voir le panier · ') : '';

   $filtersH = forH($filters, function($k, $v) {
      return ($k!='search') ? Input(type('hidden'), name($k), value($v)) : '';
   });

   return Div( class_('ctrlBar'),
               H1(A(href('index.php'), 'symphonaute')),
               
               Form(method('GET'),action(''), $filtersH,
                    Input(class_('searchText'), type('text'), name('search'), value($value), placeholder('mouzhart · bytehôvent · boulérot') ),
                    Input(class_('searchButton'), type('submit'), value(' ')) ),
               
               unsetFilterButton('search', $filters),
               Span(class_('stretch'), ''),
               Span( $cart, $mLogin, ' · ', A(class_('about'), href('about.php'), 'à propos') )
   );
}


function loginForm($bad) 
{
   return form( action('checkLogin.php'),method('POST'),
                h1('connexion'),
                ($bad) ? Strong(class_('error'), 'nom ou mot de passe incorrect') : '',
                //A(class_('pas_inscrit'),href('inscrption.php'), 'Pas encore inscrit ?'),
                input(name('pseudo'),type('text'),placeholder('nom utilisateur')),
                input(name('password'),type('password'),placeholder('mot de passe')),
                input(type('submit'),value("connexion")),
                A(href('inscription.php'), 'inscription') );
}


function registerForm($error) {
   return form( action('checkConnexion.php'),method('POST'),
                h1('inscription'),
                ($error != '') ? Strong(class_('error'), $error) : '',
                input(name('email')         , type('text')    , placeholder('nom')),
                input(name('pseudo')        , type('text')    , placeholder('login < 10 caractères')),
                input(name('password')      , type('password'), placeholder('mot de passe')),
                input(name('password_verif'), type('password'), placeholder('retapez le mot de passe')),

                input(type('submit'), value("inscription")) );
}


function about() {
   return Div( H2("Introduction"),
    	       P("Symphonaute a été réalisé par Timothée Jourde et Etienne Anne, dans le cadre du projet web de S3 à l'IUT Informatique de Bordeaux. Il est écrit en PHP, HTML, CSS et utilise une base de données (sous SQLServer) répertoriant compositeurs, œuvres, albums et morceaux. Tout est fait maison, from scratch, excepté l'API Amazon."),

    	       H2("Fonctionnement"),
    	       P("Pour commencer, l'utilisateur est invité à faire une recherche depuis la page d'accueil, il peut saisir le nom approximatif d'un compositeur, d'une œuvre, d'un album..."),
    	       P("Les résultas sont dispersés en 4 catégories. On peut ensuite filtrer les résultats en séléctionnant un compositeur, une œuvre, un album, ou un morceaux."),
               P("Un clic dans la colonne compositeurs par exemple, disons Mozart, permet d'afficher ses oeuvres, albums et enregistrements dans les autres colonnes ; Mozart sera alors le seul compositeur dans la colonne compositeurs. On peut également cumuler plusieurs critères (compositeur + album, Œuvre + recherche, etc.)."),
               P("Notons que l'on peut écouter des éxtraits des morceaux en cliquant sur le haut-parleur."),

	       H2("Panier"),
               P("L'utilisateur peut créer un compte pour constituer un panier : une fois connecté, il suffit de cocher la case du morceaux à ajouter. On peut ensuite afficher le panier."),

    	       H2("Fonction de recherche"),
    	       P("Le site dispose d'une fonction de recherche en texte libre, avec donc une bonne tolérance aux erreurs de syntaxes. La recherche est en contre partie un peu longue"),

    	       H2("Amazon"),
    	       P("Des albums disponibles sur Amazon correspondants au compositeur séléctionné sont également proposés.") );
}
