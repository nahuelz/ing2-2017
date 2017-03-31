<?php

class Creditos extends TwigView {
    
    public function show($args = []) {

        echo self::getTwig()->render('creditos.html.twig', $args);
        
    }
    
}