<?php

namespace fxc; // pas terrible mais c'est le seul moyen...
require_once 'fxc/xhtml5.php';


function page($title, $section, $body)
{
   return Html(lang('fr')
    
	       ,Head(Meta(charset('UTF-8')),
		     link(rel('stylesheet'),href('index.css'), type('text/css'))
            
		     ,Title($title)
		  )
      
	       ,Body( Header( Nav( Ul( Li(A(href('index.php'), 'e-Music')), ' '
				       ,Li(A(href('catalogue.php'), 'Catalogue')), ' '
				       ,Li(A(href('connexion.php'), 'Connexion')), ' '
				       ,Li(A(href('about.php'), 'About')), ' '))
				
				
				
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

function catalogHtml($composers, $works, $albums, $records)
{
   $c = Table( forH($composers, function($e) {
	    return Tr( Td(Img(src(''))), Td($e->Elem->Value['str1']), Td($e->Elem->Value['str2']) );
	 }));

   $w = Table( forH($works, function($e) {
	    return Tr( Td(Img(src(''))), Td($e->Elem->Value['str1']), Td($e->Elem->Value['str2']) );
	 }));
  
   $a = Table( forH($albums, function($e) {
	    return Tr( Td(Img(src(''))), Td($e->Elem->Value['str1']) );
	 }));
  
   $r = Table( forH($records, function($e) {
	    return Tr( Td($e->Elem->Value['str1']) );
	 }));

  
   return Div(class_('catalog'), $c, $w, $a, $r );
}
