<?php

class VerPostulantes extends TwigView {
    
    public function show($args = []) {

        echo self::getTwig()->render('VerPostulantes.html.twig', $args);
        
    }
    
}