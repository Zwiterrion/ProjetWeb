<?php


// pompé des sources de BlazeHtml <3
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

   $header = <<<EOS
// $name.php
// Combinateurs pour le dialecte xml $name
//
// Code php généré par phpfxc, dévellopé spécialement pour le projet.
// Voir fxc/fxc.php et fxc/generate.php
//

      

      EOS;

   fwrite($file, $header);

   fwrite($file, "// Elements\n");
   foreach($desc['elements'] as $e)
      fwrite($file, element($e) . "\n");

   fwrite($file, "\n\n// Empty Elements\n");
   foreach($desc['emptyElements'] as $e)
      fwrite($file, emptyElement($e) . "\n");

   fwrite($file, "\n\n// Attributes\n");
   foreach($desc['attributes'] as $e)
      fwrite($file, attributes($e) . "\n");

   fclose($file);
}




function element($name_)
{
   $name = elemName($names_);
   return 'function '. $name .'() { $p=func_get_args(); array_shift($p); return Element('. $name .', $args); }';
}

function emptyElement($name_)
{
   $name = elemName($names_);
   return 'function '. $name .'() { $p=func_get_args(); array_shift($p); return EmptyElement('. $name .', $args); }';
}

function attribute($name_)
{
   $name = attrName($name_);
   return 'function '. $name .'($v) { return attr('. $name .', $v); }';
}

function elemName($name)
{
   $az = array_map( function ($c)
		    {
		       if ($c < 'A' and $c > 'z')
			  return ' ';
		       else
			  return $c;
		    }
		    , str_split($name));

   return str_replace(' ', '', ucwords($az) );
}
function attrName($name)
{
   $res = elemName($name);
   $res[0] = strtolower($res[0]);
   return $res;
}

