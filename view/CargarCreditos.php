<?php

class CargarCreditos extends TwigView {
    
    public function show($args = []) {

        echo self::getTwig()->render('creditos.html.twig', $args);
        
    }
    
}