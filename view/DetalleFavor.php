<?php

class DetalleFavor extends TwigView {
    
    public function show($args = []) {

        echo self::getTwig()->render('detalleFavor.html.twig', $args);
        
    }
    
}