<?php

class DeshabilitarCuenta extends TwigView {
    
    public function show($args = []) {

        echo self::getTwig()->render('deshabilitarCuenta.html.twig', $args);
        
    }
    
}