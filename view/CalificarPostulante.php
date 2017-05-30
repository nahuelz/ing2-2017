<?php

class CalificarPostulante extends TwigView {
    
    public function show($args = []) {

        echo self::getTwig()->render('calificarPostulante.html.twig', $args);
        
    }
    
}