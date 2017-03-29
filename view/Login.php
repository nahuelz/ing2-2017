<?php

class Login extends TwigView {
    
    public function show($args = []) {

        echo self::getTwig()->render('login.html.twig', $args);
        
    }
    
}