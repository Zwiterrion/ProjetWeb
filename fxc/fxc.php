<?php

namespace fxc;

const PARENT_EMPTY     = 0;
const PARENT_NONEMPTY  = 1;

const STATE_ATTRIBUTES = 0;
const STATE_CONTENT    = 1;


interface Writer {
   public function write($str);
}

class Echoer implements Writer {
   public function write($str) {
      echo $str;
   }
}

function echoXml($elem) {
   $state = STATE_CONTENT;
   $elem( (new Echoer()), $state, PARENT_NONEMPTY );
}


function concat()
{
   $args = func_get_args();

   return function($out, &$state, $parent) use($args)
   {
      if ($parent === PARENT_EMPTY)
	 return;
	 
      foreach($args as $arg)
      {
	 if ($arg instanceof \Closure)
	 {
	    $arg( $out, $state, PARENT_NONEMPTY );
	 }
	 else
	 {
	    if ($state === STATE_ATTRIBUTES)
	    {
	       $state = STATE_CONTENT;
	       $out->write('>');
	    }
	    
	    $out->write( htmlspecialchars((string) $arg) );
	 }
      }
   };
}


function Elem($name) {
   $args = func_get_args();
   array_shift($args);
   return Element($name, $args);
}
function Element($name, $args)
{
   return function($out, &$state, $parent) use($args, $name)
   {
      if ($parent === PARENT_EMPTY)
	 return;
	 
      if ($state === STATE_ATTRIBUTES)
      {
	 $state = STATE_CONTENT;
	 $out->write('>');
      }
      
      $out->write("<$name");
      $state2 = STATE_ATTRIBUTES;

      foreach($args as $arg)
      {
	 if ($arg instanceof \Closure)
	 {
	    $arg( $out, $state2, PARENT_NONEMPTY );
	 }
	 else
	 {
	    if ($state2 === STATE_ATTRIBUTES)
	    {
	       $state2 = STATE_CONTENT;
	       $out->write('>');
	    }
	    
	    $out->write( htmlspecialchars((string) $arg) );
	 }
      }
      
      if ($state2 === STATE_ATTRIBUTES)
	 $out->write('>');

      $out->write("</$name>");
   };
}

function Empty_($name) {
   $args = func_get_args();
   array_shift($args);
   return EmptyElement($name, $args);
}
function EmptyElement($name, $args)
{
   return function($out, &$state, $parent) use($args, $name)
   {
      if ($parent === PARENT_EMPTY)
	 return;
	 
      if ($state === STATE_ATTRIBUTES)
      {
	 $state = STATE_CONTENT;
	 $out->write('>');
      }
      
      $out->write("<$name");
      $state2 = STATE_ATTRIBUTES;

      foreach($args as $arg)
      {
	 if ($arg instanceof \Closure)
	 {
	    $arg( $out, $state2, PARENT_EMPTY );
	 }
      }
      
      $out->write(' />');
   };
}


function PreEscaped($str)
{
   return function($out, $state, $parent) use($str)
   {
      if ($parent === PARENT_EMPTY)
	 return;
	 
      if ($state === STATE_ATTRIBUTES)
      {
	 $state = STATE_CONTENT;
	 $out->write('>');
      }
      
      $out->write($str);
   };
}

function attr($name, $value)
{
   return function($out, $state, $parent) use($name, $value)
   {
      if ($state !== STATE_ATTRIBUTES)
	 return;

      $out->write(' '.$name.'="'.htmlspecialchars((string) $value).'"');
   };
}




