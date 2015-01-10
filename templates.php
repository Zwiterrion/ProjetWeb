<?php

namespace fxc; // pas terrible mais c'est le seul moyen...
require_once 'fxc/xhtml5.php';
require_once 'amazon/samples/Search/SimpleSearch.php';

function page($title, $section, $body, $user)
{

   $mLogin;

   if(isset($user['login'])) {
      $mLogin = A(class_('log'),href('logout.php'), 'Deconnexion [ ' . $user['login'] . ' ]' );
   }
   else {
      $mLogin = A(class_('log'),href('login.php'), 'Connexion');
   }
        
   return Html(lang('fr')
                    
	       ,Head(Meta(charset('UTF-8')),
		     link(rel('stylesheet'),href('index.css'), type('text/css'))
                          
		     ,Title($title)
		  )
                    
	       ,Body( header( nav( Ul( li(A(href('index.php'), 'e-Music')), ' '
				       ,li(A(href('catalog.php'), 'Catalogue')), ' '
				       ,li(A(href('about.php'), 'A propos')), ' '))
                                  
			      ,$mLogin
                                  
			 )
                          
                          
		      ,$body
		      ,Footer()
		  )
      );
}
    
    

function forH($es, $f)
{
   $res = '';
   foreach($es as $e)
   {
      $res = concat($res, $f($e));
   }
   return $res;
}

function catalogHtml($composers, $works, $albums, $records, $filters)
{
   $args = filtersUrl($filters);

   $c = Div(class_('col'), H2('Compositeurs'), unsetFilterButton('composer',$filters), Ul( forH($composers, function($e) use($args) {

      $id = $e->Elem->Value['id'];

      $fname = $e->Elem->Value['str1'];
      if ($fname != '')
         $fname = concat($fname, Br());

      return Li(
         Span(class_('img'), style_("background-image: url(\"media.php?param=1&code=$id\");"))
         ,A(href("?composer=$id&$args")
            ,$fname
            ,$e->Elem->Value['str2']
      ));
   })));
   
   $w = Div(class_('col'), H2('Œuvres'), unsetFilterButton('work',$filters), Ul( forH($works, function($e) use($args) {

      $id = $e->Elem->Value['id'];
      return Li(A(href("?work=$id&$args")
         ,$e->Elem->Value['str1'], Br()
	 ,$e->Elem->Value['str2']
      ));
   })));
   
   $a = Div(class_('col'), H2('Albums'), unsetFilterButton('album',$filters), Ul( forH($albums, function($e) use($args) {

      $id = $e->Elem->Value['id'];
      return Li(
         Span(class_('img'), style_("background-image: url(\"media.php?param=2&code=$id\");"))
         ,A(href("?album=$id&$args"), $e->Elem->Value['str1'])
         
         );
   })));
   
   $r = Div(class_('col'), H2('Morceaux'), unsetFilterButton('record',$filters), Ul( forH($records, function($e) use($args) {

      $id = $e->Elem->Value['id'];
      return Li(
         A(onclick('this.firstChild.play()'), Audio(id((string)$id), Source(src('media.php?param=3&code='.$id), type('audio/mpeg'))), 'lire')
	 ,A(href("?record=$id&$args"), $e->Elem->Value['str1'])
      );
   })));

   
   $amazon = search_amazon('mozart');

   $list = div(class_('Amazon_div'),h1("Amazon"),
         Ul(Li(class_('Amazon'),Img(src($amazon[2]))),Li(class_('Amazon'),A(href($amazon[1]),$amazon[0])),
               Li(class_('Amazon'),Img(src($amazon[5]))),Li(class_('Amazon'),A(href($amazon[4]),$amazon[3])),
                  Li(class_('Amazon'),Img(src($amazon[8]))),Li(class_('Amazon'),A(href($amazon[7]),$amazon[6]))));


   return Div(class_('catalog'), searchBar('',$args), $c, $w, $a, $r, $list);
}

function unsetFilterButton($f,$filters)
{
   if (isset($filters[$f]))
   {
      unset($filters[$f]);
      return A(class_('unsetFilter'), href('?'.filtersUrl($filters)), 'retirer le filtre');
   }
   else
      return '';
}

function searchBar($c, $args)
{
   return Form( class_('catalog_search_bar '.$c),method('GET'),action("?$args"),
                Div( Input(class_('catalog_search_text'), type('text'), name('search'), placeholder('Mouzhart, Bitehovent, Figaroute...') ),
                     Input(class_('catalog_search_button'), type('submit'), value(' '))
             ));
}

