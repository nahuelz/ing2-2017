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
                $nombreImagen = '';
                $usuarioId = UsuarioController::getInstance()->usuarioLogeado()->getId();
                if ( (isset($_FILES['imagen'])) && ($_FILES['imagen']['size'] > 0) )  {
                    if ($this->validarImagen()){
                        $imagen = $this->procesarImagen();
                        $nombreImagen = $_FILES['imagen']['name'];
                        $msg =  Favor::getInstance()->altaFavor($usuarioId, $titulo, $descripcion, $categoria, $localidad, $fecha, $nombreImagen);
                    }else{
                        $msg = Message::getMessage(11);
                    }
                }else{
                    $msg =  Favor::getInstance()->altaFavor($usuarioId, $titulo, $descripcion, $categoria, $localidad, $fecha, $nombreImagen);
                }
            }else{
                $msg = Message::getMessage(5);
            }
            $this->altaFavor($msg);
        }else{
            ResourceController::getInstance()->home();
        }
    }
    
    public function validarImagen(){
        if (isset($_FILES['imagen']) && $_FILES['imagen']['size'] > 0){
            if ($_FILES['imagen']['size'] < 65000){
                if ( (strpos($_FILES['imagen']['type'], "jpeg")) || (strpos($_FILES['imagen']['type'], "jpg")) || (strpos($_FILES['imagen']['type'], "png")) ){
                    return true;
                }
            }
        }
        return false;
    }

    public function procesarImagen(){
        $nombreImagen = $_FILES['imagen']['name'];
        $nombreTmp = $_FILES['imagen']['tmp_name'];
        move_uploaded_file($nombreTmp, './imagenes/'.$nombreImagen);

    }

    /*
    *   VER DETALLE
    */
    public function verDetalle($args = []) {
        if (UsuarioController::getInstance()->usuarioLogeado()){
            if (isset($_GET['id'])){
                $idFavor = $_GET['id'];
                $favor = Favor::getInstance()->verFavor($idFavor);
                $args = array_merge($args, ['user' => UsuarioController::getInstance()->usuarioLogeado(), 'favor' => $favor[0]]);
                $view = new DetalleFavor();
                $view->show($args);
            }
        }else{
            ResourceController::getInstance()->home();
        }

    }
    
}