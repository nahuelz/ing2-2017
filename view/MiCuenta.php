<?php

class MiCuenta extends TwigView {
    
    public function show($args = []) {

        echo self::getTwig()->render('miCuenta.html.twig', $args);
        
    }
    
}