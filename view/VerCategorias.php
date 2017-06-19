<?php

class VerCategorias extends TwigView {
    
    public function show($args = []) {

        echo self::getTwig()->render('categoria.html.twig', $args);
        
    }
    
}