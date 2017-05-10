<?php

class FavorController {
    
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
    *   ALTA FAVOR
    */
    public function altaFavor($args = []) {
        if (UsuarioController::getInstance()->usuarioLogeado()){
            $categorias = Categoria::getInstance()->categoriasHabilitadas();
            $args = array_merge($args, ['user' => UsuarioController::getInstance()->usuarioLogeado(), 'categorias' => $categorias]);
            $view = new AltaFavor();
            $view->show($args);
        }else{
            ResourceController::getInstance()->home();
        }

    }

    /*
    *   ALTA FAVOR ACTION
    */
    public function altaFavorAction($args = []) {
        if (UsuarioController::getInstance()->usuarioLogeado()){
            if ((isset($_POST['titulo']) AND isset($_POST['descripcion'])) AND !empty($_POST['titulo']) AND !empty($_POST['descripcion'])) {
                $titulo = $_POST['titulo'];
                $descripcion = $_POST['descripcion'];
                $categoria = $_POST['categoria'];
                $localidad = $_POST['localidad'];
                $fecha = Date('Y-m-d');
                $usuarioId = UsuarioController::getInstance()->usuarioLogeado()->getId();
                $msg =  Favor::getInstance()->altaFavor($usuarioId, $titulo, $descripcion, $categoria, $localidad, $fecha);
            }else{
                $msg = Message::getMessage(5);
            }
            $this->altaFavor($msg);
        }else{
            ResourceController::getInstance()->home();
        }

    }
}