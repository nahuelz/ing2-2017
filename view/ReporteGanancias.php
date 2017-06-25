<?php

class ReporteGanancias extends TwigView {
    
    public function show($args = []) {
    	
        echo self::getTwig()->render('reporteGanancias.html.twig', $args);
        
    }
    
}