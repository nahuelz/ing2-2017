<?php

class FavoresPostulados extends TwigView {
    
    public function show($args = []) {

        echo self::getTwig()->render('favoresPostulados.html.twig', $args);
        
    }
    
}