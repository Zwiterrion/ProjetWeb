<?php

namespace fxc; // pas terrible mais c'est le seul moyen...
require_once 'fxc/xhtml5.php';

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

function catalogHtml($composers, $works, $albums, $records)
{
   $c = div(Table( forH($composers, function($e) {
	    return Tr( Td(Img(src(''))), Td($e[1]['str1']), Td($e[1]['str2']) );
	 })));
  
   $w = div(Table( forH($works, function($e) {
	    return Tr( Td(Img(src(''))), Td($e[1]['str1']), Td($e[1]['str2']) );
	 })));
  
   $a = div(Table( forH($albums, function($e) {
	    return Tr( Td(Img(src(''))), Td($e[1]['str1']) );
	 })));
  
   $r = div(Table( forH($records, function($e) {
	    return Tr( Td($e[1]['str1']) );
	 })));

  
   return Div(class_('catalog'), $c, $w, $a, $r );
}

