<?php


// liste des balises/attributs pompé des sources de BlazeHtml <3
$dialects = 
   [ 'xhtml5' => [ 'elements' =>  ['a', 'abbr', 'address', 'article', 'aside', 'audio', 'b'
				   , 'bdo', 'blockquote', 'body', 'button', 'canvas', 'caption', 'cite'
				   , 'code', 'colgroup', 'command', 'datalist', 'dd', 'del', 'details'
				   , 'dfn', 'div', 'dl', 'dt', 'em', 'fieldset', 'figcaption', 'figure'
				   , 'footer', 'form', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'head', 'header'
				   , 'hgroup', 'html', 'i', 'iframe', 'ins', 'kbd', 'label'
				   , 'legend', 'li', 'map', 'mark', 'menu', 'meter', 'nav', 'noscript'
				   , 'object', 'ol', 'optgroup', 'option', 'output', 'p', 'pre', 'progress'
				   , 'q', 'rp', 'rt', 'ruby', 'samp', 'script', 'section', 'select'
				   , 'small', 'span', 'strong', 'style', 'sub', 'summary', 'sup'
				   , 'table', 'tbody', 'td', 'textarea', 'tfoot', 'th', 'thead', 'time'
				   , 'title', 'tr', 'ul', 'var', 'video']


		   ,'emptyElements' => ['area', 'base', 'br', 'col', 'embed', 'hr', 'img', 'input', 'keygen'
					, 'link', 'menuitem', 'meta', 'param', 'source', 'track', 'wbr']

		   ,'attributes' => ['accept', 'accept-charset', 'accesskey', 'action', 'alt', 'async'
				     , 'autocomplete', 'autofocus', 'autoplay', 'challenge', 'charset'
				     , 'checked', 'cite', 'class', 'cols', 'colspan', 'content'
				     , 'contenteditable', 'contextmenu', 'controls', 'coords', 'data'
				     , 'datetime', 'defer', 'dir', 'disabled', 'draggable', 'enctype', 'for'
				     , 'form', 'formaction', 'formenctype', 'formmethod', 'formnovalidate'
				     , 'formtarget', 'headers', 'height', 'hidden', 'high', 'href'
				     , 'hreflang', 'http-equiv', 'icon', 'id', 'ismap', 'item', 'itemprop'
				     , 'keytype', 'label', 'lang', 'list', 'loop', 'low', 'manifest', 'max'
				     , 'maxlength', 'media', 'method', 'min', 'multiple', 'name'
				     , 'novalidate', 'onbeforeonload', 'onbeforeprint', 'onblur', 'oncanplay'
				     , 'oncanplaythrough', 'onchange', 'oncontextmenu', 'onclick'
				     , 'ondblclick', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave'
				     , 'ondragover', 'ondragstart', 'ondrop', 'ondurationchange', 'onemptied'
				     , 'onended', 'onerror', 'onfocus', 'onformchange', 'onforminput'
				     , 'onhaschange', 'oninput', 'oninvalid', 'onkeydown', 'onkeyup'
				     , 'onload', 'onloadeddata', 'onloadedmetadata', 'onloadstart'
				     , 'onmessage', 'onmousedown', 'onmousemove', 'onmouseout', 'onmouseover'
				     , 'onmouseup', 'onmousewheel', 'ononline', 'onpagehide', 'onpageshow'
				     , 'onpause', 'onplay', 'onplaying', 'onprogress', 'onpropstate'
				     , 'onratechange', 'onreadystatechange', 'onredo', 'onresize', 'onscroll'
				     , 'onseeked', 'onseeking', 'onselect', 'onstalled', 'onstorage'
				     , 'onsubmit', 'onsuspend', 'ontimeupdate', 'onundo', 'onunload'
				     , 'onvolumechange', 'onwaiting', 'open', 'optimum', 'pattern', 'ping'
				     , 'placeholder', 'preload', 'pubdate', 'radiogroup', 'readonly', 'rel'
				     , 'required', 'reversed', 'rows', 'rowspan', 'sandbox', 'scope'
				     , 'scoped', 'seamless', 'selected', 'shape', 'size', 'sizes', 'span'
				     , 'spellcheck', 'src', 'srcdoc', 'start', 'step', 'style', 'subject'
				     , 'summary', 'tabindex', 'target', 'title', 'type', 'usemap', 'value'
				     , 'width', 'wrap', 'xmlns']
	 ]
      ];



foreach ($dialects as $name => $desc)
{
   $file = fopen("$name.php", 'w') or die("Unable to open file!");

   $header = <<<END
<?php
// $name.php
// combinateurs phpfxc pour le dialecte xml $name
//
// code php généré par phpfxc, dévellopé spécialement pour le projet
// voir fxc/fxc.php et fxc/generate.php
//
//

namespace fxc\$name;      
require_once 'fxc.php';


END;

   fwrite($file, $header);

   fwrite($file, "// Elements\n");
   foreach($desc['elements'] as $e)
      fwrite($file, element($e) . "\n");

   fwrite($file, "\n\n// Empty Elements\n");
   foreach($desc['emptyElements'] as $e)
      fwrite($file, emptyElement($e) . "\n");

   fwrite($file, "\n\n// Attributes\n");
   foreach($desc['attributes'] as $e)
      fwrite($file, attribute($e, $desc) . "\n");
   
   fclose($file);
}




function element($name)
{
   $name_ = elemName($name);
   return "function $name_() { return Element('$name', func_get_args()); }";
}

function emptyElement($name)
{
   $name_ = elemName($name);
   return "function $name_() { return EmptyElement('$name', func_get_args()); }";
}

function attribute($name, $desc)
{
   $name_ = attrName($name, $desc);
   return "function $name_(\$v) { return attr('$name', \$v); }";
}


function elemName($name)
{

   $reserved = ['__halt_compiler', 'abstract', 'and', 'array', 'as', 'break'
		, 'callable', 'case', 'catch', 'class', 'clone'
		, 'const', 'continue', 'declare', 'default', 'die'
		, 'do', 'echo', 'else', 'elseif', 'empty'
		, 'enddeclare', 'endfor', 'endforeach', 'endif', 'endswitch'
		, 'endwhile', 'eval', 'exit', 'extends', 'final'
		, 'for', 'foreach', 'function', 'global', 'goto'
		, 'if', 'implements', 'include', 'include_once', 'instanceof'
		, 'insteadof', 'interface', 'isset', 'list', 'namespace'
		, 'new', 'or', 'print', 'private', 'protected'
		, 'public', 'require', 'require_once', 'return', 'static'
		, 'switch', 'throw', 'trait', 'try', 'unset'
		, 'use', 'var', 'while', 'xor'];



   $az = array_map( function ($c)
		    {
		       if (($c >= 'A' and $c <= 'z') or ($c >= '0' and $c <= '9'))
			  return $c;
		       else
			  return ' ';
		    }
		    , str_split($name));

   $res = str_replace(' ', '', ucwords(implode($az)) );

   if (in_array(strtolower($res), $reserved))
      return $res.'_';
   else
      return $res;
}
function attrName($name, $desc)
{
   $res = elemName($name);
   $res[0] = strtolower($res[0]);

   if (in_array(strtolower($res), $desc['elements']) or in_array(strtolower($res), $desc['emptyElements']))
      return $res.'_';
   else
      return $res;
}




