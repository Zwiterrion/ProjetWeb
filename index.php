<?php
namespace N;
require 'fxc/fxc.php';


$list = Elem('ul', Elem('li', 'first' )
	     ,Elem('li', 'second')
	     ,Elem('li', attr('class', 'red'), '"<\'Bonjour\'>" ', Elem('strong', 'mon amis'), ', comment vas tu ?')
   );


echoXml($list);






