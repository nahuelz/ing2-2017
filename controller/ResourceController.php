<?php

class ResourceController {
    
    private static $instance;

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }    
    private function __construct() {
        
    }

    /*
	** HOME:
	*/
    public function home($args = []) {
        if (UsuarioController::getInstance()->usuarioLogeado()){
            $args = array_merge($args, ['user' => UsuarioController::getInstance()->usuarioLogeado()]);
            $view = new Home();
            $view->show($args);
        }else{
            $view = new Home();
            $view->show($args);
        }
        
    }
}