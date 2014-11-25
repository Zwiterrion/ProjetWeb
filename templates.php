<?php


class Xml
{
   protected $Name;
   protected $Attributes;


   // ajouter un attribut
   public function a($name, $value) {
      $Attributes += "$name=\"$value\" ";
      return this;
   }
}


///////// Pure Genius !!!
$list = ul( class(''), id('')
	       ,li()
	       ,li( a(href('http://nyan.cat'), 'cliquez ici')
		    ,p('ceci est un paragraphe')
		    ,div("<Bonjour'\">"), strong(class('red'), 'mon chère'), ', je suis perdu')
   )
   
   ,li()
   ,li('last one')
   );
//////////
   


class XmlNode
{
   private $Children;

   public function __toString()
   {
      $cat = "";
      foreach ($Children in $c) {
	 $cat += (string) $c;
      }

      return "<$Name $Attributes>" . $cat . "</$Name>";
   }

   public function L($name) {
      $child = new XmlLeaf();
      $Children.push($child);
      return $child;
   }
   public function l($name) {
      $Children.push($child);
      return $child;
   }

   public function N($name) {
      $child = new XmlNode();
      $Children.push($child);
      return $child;
   }

   public function t($text) {
      $Children.push($text);
      return this;
   }
}

class XmlLeaf
{
   public function __toString() {
      return "<$Name $Attributes/>";
   }
}



















function ul($list)
{
   e("ul", [], function() use ($list) { 
	 concat( array_map( function($x) {

		  e("li", [], v($x));
		  
	       }, $list ));

      });
}

function e($name, $attr, $content)
{
   $attrStr = "";
   foreach($attr as $k => $v)
      $attrStr += $k . '="' . $v . '" ';

   return "<$name $attrStr>" . $content() . "</$name>";
}



function a($href, $attr, $content) {
   return e("a", ["href" => $href], $content);
}

function v($value) {
   return function() use ($value) { return $value; };
}

function concat($l) {
   $res = "";
   foreach($l as $e)
      $res += $e;

   return $res;
}