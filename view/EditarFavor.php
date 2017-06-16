<?php

class EditarFavor extends TwigView {
    
    public function show($args = []) {

        echo self::getTwig()->render('editarFavor.html.twig', $args);
        
    }
    
}