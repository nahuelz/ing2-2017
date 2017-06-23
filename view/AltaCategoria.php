<?php

class AltaCategoria extends TwigView {
    
    public function show($args = []) {
        echo self::getTwig()->render('altaCategoria.html.twig', $args);
        
    }
    
}