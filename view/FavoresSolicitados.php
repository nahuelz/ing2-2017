<?php

class FavoresSolicitados extends TwigView {
    
    public function show($args = []) {

        echo self::getTwig()->render('favoresSolicitados.html.twig', $args);
        
    }
    
}