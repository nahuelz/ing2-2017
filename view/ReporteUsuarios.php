<?php

class ReporteUsuarios extends TwigView {
    
    public function show($args = []) {

        echo self::getTwig()->render('usuariosConMasPuntos.html.twig', $args);
        
    }
    
}