<?php

namespace fxc; // pas terrible mais c'est le seul moyen...
require_once 'fxc/xhtml5.php';

//
// demo phpfxc !
//

$p1 = P('ceci est un ', Strong('paragraphe'), ' composé de mots, lesquels sont composés de lettres. trop bien.');

$list = Ul( Li(A('faire les courses'))
	    ,Li('donner à manger à ', Em(class_('uneclasse'), 'popol'))
	    ,Li('...')
   );

$doc = Html( lang('fr')
	     ,Head( Meta(charset('UTF-8')) )
	     
	     
	     ,Body( Header('je suis un ', A(href('http://nyan.cat'), 'header'))
		    
		    ,H1('Un paragraphe'), $p1
		    ,H2('Une liste'), $list
		    
		    ,Footer('je suis un pied... de page !!! trop bien.')
		)
   );





echoXml($doc);







