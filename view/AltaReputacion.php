<?php

class AltaReputacion extends TwigView {
    
    public function show($args = []) {

        echo self::getTwig()->render('altaReputacion.html.twig', $args);
        
    }
    
}