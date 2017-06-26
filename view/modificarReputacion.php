<?php

class ModificarReputacion extends TwigView {
    
    public function show($args = []) {

        echo self::getTwig()->render('modificarReputacion.html.twig', $args);
        
    }
    
}