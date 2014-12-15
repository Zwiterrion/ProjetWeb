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
                    
                    ,Body( header( nav( Ul( li(A(href('index.php'), 'e-Music')), ' '
                                           ,li(A(href('catalogue.php'), 'Catalogue')), ' '
                                           ,li(A(href('connexion.php'), 'Connexion')), ' '
                                           ,li(A(href('about.php'), 'About')), ' '))
                                  
                                  
                                  
                                  )
                          
                          
                          
                          
                          
                          ,$body
                          ,Footer()
                          )
                    );
    }
    
    
    
