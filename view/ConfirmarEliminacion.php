<?php

class ConfirmarEliminacion extends TwigView {
    
    public function show($args = []) {

        echo self::getTwig()->render('confirmarEliminacion.html.twig', $args);
        
    }
    
}