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
        $categorias = Categoria::getInstance()->categoriasHabilitadas();
        if (UsuarioController::getInstance()->usuarioLogeado()){
            $args = array_merge($args, ['user' => UsuarioController::getInstance()->usuarioLogeado(), 'categorias' => $categorias]);
            $view = new Home();
            $view->show($args);
        }else{
            $args = array_merge($args, ['categorias' => $categorias]);
            $view = new Home();
            $view->show($args);
        }
        
    }
}