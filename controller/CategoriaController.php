<?php

class CategoriaController {
    
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
     * VER REPUTACIONES
     */
    public function categorias($args = []){
    	if (UsuarioController::getInstance()->usuarioLogeado()){
    		if (UsuarioController::getInstance()->usuarioLogeado()->getEsAdmin()){
    			$categorias = Categoria::getInstance()->categoriasHabilitadas();
    			$args = array_merge($args, ['user' => UsuarioController::getInstance()->usuarioLogeado(), 'categorias' => $categorias]);
	    		$view = new VerCategorias();
	    		$view->show($args);
	    	}else{
	    		ResourceController::getInstance()->home();
	    	}
        }else{
        	ResourceController::getInstance()->home();
        }
    }

    /*
     * FORMULARIO ALTA CATEGORIA
     */
    public function altaCategoria($args = []){
        if (UsuarioController::getInstance()->usuarioLogeado()){
            if (UsuarioController::getInstance()->usuarioLogeado()->getEsAdmin()){
                $args = array_merge($args, ['user' => UsuarioController::getInstance()->usuarioLogeado()]);
                $view = new AltaCategoria();
                $view->show($args);
            }else{
                ResourceController::getInstance()->home();
            }
        }else{
            ResourceController::getInstance()->home();
        }
    }

    /*
     * ALTA CATEGORIA
     */
    public function altaCategoriaAction($args = []){
        if(UsuarioController::getInstance()->usuarioLogeado()){
            if (UsuarioController::getInstance()->usuarioLogeado()->getEsAdmin()){

                if (isset($_POST['nombreCategoria']) &&  !empty($_POST['nombreCategoria'])) {

                    $nombreCategoria = $_POST['nombreCategoria'];  

                    if(!Categoria::getInstance()->existeCategoria($nombreCategoria)){      

                        Categoria::getInstance()->agregarCategoria($nombreCategoria);
                        $this->categorias(Message::getMessage(33));

                    }else{

                        $categoria=Categoria::getInstance()->getCategoriaPorNombre($nombreCategoria);
                        $estaHabilitada=$categoria->estaHabilitada();    
                         
                        if($estaHabilitada=="0"){

                            Categoria::getInstance()->habilitarCategoria($categoria->getId());
                            $this->categorias(Message::getMessage(33));

                        }else{
                        $mensaje=Message::getMessage(34);
                        $args=array_merge($args, $mensaje, ['nombrecategoria'=>$nombreCategoria]);
                        $this->altaCategoria($args);
                    }
                    }
                }else{

                     $this->categorias($args);
                }

            }
        }else{
            ResourceController::getInstance()->home();
        }
    }

     /*
     * EDITAR CATEGORIA
     */
    public function modificarCategoria($args = []){
        if(UsuarioController::getInstance()->usuarioLogeado()){
            if (UsuarioController::getInstance()->usuarioLogeado()->getEsAdmin()){
                if (isset($_POST['idCategoria']) && !empty($_POST['idCategoria'])){
                    $idCategoria = $_POST['idCategoria'];
                    $nombrecategoria = Categoria::getInstance()->getCategoria($idCategoria); 
                    $nombrecategoria = $nombrecategoria->getNombre();              
                    $args = array_merge($args, ['user' => UsuarioController::getInstance()->usuarioLogeado(),'idCategoria' => $idCategoria, 'nombrecategoria'=>$nombrecategoria]);
                    $view = new ModificarCategoria();
                    $view->show($args);
                }else{
                     $this->categorias($args);
                }

            }
        }else{
            ResourceController::getInstance()->home();
        }
    }

    public function modificarCategoriaAction($args = []){
        if(UsuarioController::getInstance()->usuarioLogeado()){
            if (UsuarioController::getInstance()->usuarioLogeado()->getEsAdmin()){
                if (isset($_POST['idCategoria']) && isset($_POST['nombreCategoria']) && !empty($_POST['idCategoria']) && !empty($_POST['nombreCategoria'])) {
                    $idCategoria = $_POST['idCategoria'];
                    $nombreCategoria = $_POST['nombreCategoria'];

                    if(!Categoria::getInstance()->existeCategoria($nombreCategoria)){
                        Categoria::getInstance()->modificarCategoria($idCategoria,$nombreCategoria);
                        $this->categorias(Message::getMessage(32));
                    }else{
                        $mensaje=Message::getMessage(36);
                        
                        $args=array_merge($args, $mensaje, ['nombrecategoria'=>$nombreCategoria]);
                        $this->modificarCategoria($args);
                    }            
                    
                }else{
                     $this->categorias($args);
                }

            }
        }else{
            ResourceController::getInstance()->home();
        }
    }
    /*
     * BAJA CATEGORIA
     */
    public function eliminarCategoria($args = []){
        if(UsuarioController::getInstance()->usuarioLogeado()){
            if (UsuarioController::getInstance()->usuarioLogeado()){
                if (UsuarioController::getInstance()->usuarioLogeado()->getEsAdmin()){
                    if ( (isset($_POST['idCategoria'])) ){
                        $id = $_POST['idCategoria'];
                        $this->procesarBaja($id);
                        $this->categorias(Message::getMessage(35));
                    }else{
                        $this->categorias();
                    }
                }else{
                    ResourceController::getInstance()->home();
                }
            }else{
                ResourceController::getInstance()->home();
            }
        }else{
            ResourceController::getInstance()->home();
        }
    }




    // -------------PRIVATE FUNCTIONS-------------------------//
    private function procesarBaja($borrarId){
        $idCategoria=$borrarId;
        if (Categoria::getInstance()->tieneFavores($idCategoria)) {
            Categoria::getInstance()->deshabilitarCategoria($idCategoria); 
        }
        $this->categorias(Message::getMessage(39));
    }

}