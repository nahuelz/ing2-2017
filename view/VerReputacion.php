<?php

class VerReputacion extends TwigView {
    
    public function show($args = []) {

        echo self::getTwig()->render('reputacion.html.twig', $args);
        
    }
    
}