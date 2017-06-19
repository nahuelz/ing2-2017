<?php

class ModificarCategoria extends TwigView {
    
    public function show($args = []) {

        echo self::getTwig()->render('ModificarCategoria.html.twig', $args);
        
    }
    
}