<?php

class AltaFavor extends TwigView {
    
    public function show($args = []) {

        echo self::getTwig()->render('altaFavor.html.twig', $args);
        
    }
    
}