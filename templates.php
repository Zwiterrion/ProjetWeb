<?php

namespace fxc; // pas terrible mais c'est le seul moyen...
require_once 'fxc/xhtml5.php';

function page($title, $bodyclass, $body)
{
   $title = ($title != '') ? ' · '.$title : '';

        
   return Html(lang('fr'),
                    
               Head( Meta(charset('UTF-8')),
		     Link(rel('stylesheet'),href('index.css'), type('text/css')),
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
      return Li( A(onclick('this.firstChild.play()'), Audio(id((string)$id), Source(src('media.php?param=3&code='.$id), type('audio/mpeg'))), 'lire'),
                 ($cart) ? cartButton($id, isset($e->Elem->Value['cart'])) : '',
	         A(href("?record=$id&$args"), $e->Elem->Value['str1']) );
   })));

   
   return Div(class_('catalog'), $c, $w, $a, $r);
}

function amazonHtml($a)
{
   return Div(class_('Amazon_div'),h1("Amazon"),
              Ul(Li(class_('Amazon'),Img(src($a[2]))),Li(class_('Amazon'),A(href($a[1]),$a[0])),
                 Li(class_('Amazon'),Img(src($a[5]))),Li(class_('Amazon'),A(href($a[4]),$a[3])),
                 Li(class_('Amazon'),Img(src($a[8]))),Li(class_('Amazon'),A(href($a[7]),$a[6]))));
   
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

