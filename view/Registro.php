<?php

class Registro extends TwigView {
    
    public function show($args = []) {

        echo self::getTwig()->render('registro.html.twig', $args);
        
    }
    
}