<?php

class VerDatos extends TwigView {
    
    public function show($args = []) {
        echo self::getTwig()->render('verDatos.html.twig', $args);
        
    }
    
}