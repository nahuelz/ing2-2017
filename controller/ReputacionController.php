<?php

class ReputacionController {
    
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
    public function reputacion($args = []){
    	if (UsuarioController::getInstance()->usuarioLogeado()){
    		if (UsuarioController::getInstance()->usuarioLogeado()->getEsAdmin()){
    			$reputaciones = Reputacion::getInstance()->getReputaciones();
    			$args = array_merge($args, ['user' => UsuarioController::getInstance()->usuarioLogeado(), 'reputaciones' => $reputaciones]);
	    		$view = new VerReputacion();
	    		$view->show($args);
	    	}else{
	    		ResourceController::getInstance()->home();
	    	}
        }else{
        	ResourceController::getInstance()->home();
        }
    }

    /*
     * FORMULARIO ALTA REPUTACION
     */
    public function altaReputacion($args = []){
        if (UsuarioController::getInstance()->usuarioLogeado()){
            if (UsuarioController::getInstance()->usuarioLogeado()->getEsAdmin()){
                $args = array_merge($args, ['user' => UsuarioController::getInstance()->usuarioLogeado()]);
                $view = new AltaReputacion();
                $view->show($args);
            }else{
                ResourceController::getInstance()->home();
            }
        }else{
            ResourceController::getInstance()->home();
        }
    }

    /*
     * ALTA REPUTACION
     */
    public function altaReputacionAction($args = []){
        if (UsuarioController::getInstance()->usuarioLogeado()){
            if (UsuarioController::getInstance()->usuarioLogeado()->getEsAdmin()){
                if ( (isset($_POST['nombre'])) && (isset($_POST['inicio'])) && (isset($_POST['fin'])) && (!empty($_POST['nombre'])) ) {
                    $nombre = $_POST['nombre'];
                    $inicio = $_POST['inicio'];
                    $fin = $_POST['fin'];
                    $this->procesarAlta($nombre, $inicio, $fin);
                }else{
                    $this->altaReputacion(Message::getMessage(5));
                }
            }else{
                ResourceController::getInstance()->home();
            }
        }else{
            ResourceController::getInstance()->home();
        }
    }

    /*
     * BAJA REPUTACION
     */
    public function eliminarReputacion($args = []){
        if (UsuarioController::getInstance()->usuarioLogeado()){
            if (UsuarioController::getInstance()->usuarioLogeado()->getEsAdmin()){
                if ( (isset($_POST['id'])) ){
                    $id = $_POST['id'];
                    $this->procesarBaja($id);
                }else{
                    $this->altaReputacion(Message::getMessage(5));
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
        $reputacion = Reputacion::getInstance()->getReputacion($borrarId);
        $fin = $reputacion->getFin();
        $inicio = $reputacion->getInicio();
        if( (Reputacion::getInstance()->getReputacionValor($inicio-1) != null) && (Reputacion::getInstance()->getReputacionValor($fin+1) != null) ) {
            $id = Reputacion::getInstance()->getReputacionValor($inicio-1)->getId();
            Reputacion::getInstance()->modificarFin($fin, $id);
        }
        Reputacion::getInstance()->eliminar($borrarId);
        $this->reputacion(Message::getMessage(31));
    }


    private function procesarAlta($nombre, $inicio, $fin){
        $validacion = $this->validar($nombre, $inicio, $fin);
        if ($validacion == 0){
            if (!$this->incluidoEnRango($inicio, $fin)){
                if ((Reputacion::getInstance()->getReputacionValor($inicio) != null) || (Reputacion::getInstance()->getReputacionValor($fin) != null)){
                    $this->modificarRangoFin($inicio);
                    $this->modificarRangoInicio($fin);
                }else{
                    $this->modificarRango($inicio, $fin);
                }
            }else{
                $fin = Reputacion::getInstance()->getReputacionValor($fin)->getFin();
                $this->modificarRangoFin($inicio);
            }
            Reputacion::getInstance()->altaReputacion($nombre, $inicio, $fin);
            $this->reputacion(Message::getMessage(27));
        }else{
            $args = array_merge($validacion, ['nombre' => $nombre, 'inicio' => $inicio, 'fin'=> $fin]);
            $this->altaReputacion($args);
        }
    }
    private function validar($nombre, $inicio, $fin){
        if ( ($inicio < $fin) && ($inicio != $fin) ) {
            if (!Reputacion::getInstance()->existeNombre($nombre)){
                if (!$this->superponeRango($inicio, $fin)){
                    return 0;
                }else{
                    return (Message::getMessage(28));
                }
            }else{
                return (Message::getMessage(30));
            }
        }else{
            return (Message::getMessage(29));
        }
    }

    private function superponeRango($inicio, $fin){
        $reputaciones = Reputacion::getInstance()->getReputaciones();
        foreach ($reputaciones as $reputacion) {
            if ( ($reputacion->getInicio() >= $inicio) && ($reputacion->getFin() <= $fin) ){
                return true;
            }
        }
        return false;
    }

    private function incluidoEnRango($inicio, $fin){
        $idInicio = Reputacion::getInstance()->getReputacionValor($inicio);
        $idFin = Reputacion::getInstance()->getReputacionValor($fin);
        if ( ($idInicio != null) && ($idInicio == $idFin) ){
            return 1;
        }
        return 0;
    }

    private function modificarRangoFin($inicio){
        if (Reputacion::getInstance()->getReputacionValor($inicio) != null){
            $idReputacion = Reputacion::getInstance()->getReputacionValor($inicio)->getId();
            Reputacion::getInstance()->modificarFin($inicio-1, $idReputacion);
        }
    }

    private function modificarRangoInicio($fin){
        if (Reputacion::getInstance()->getReputacionValor($fin) != null){
            $idReputacion = Reputacion::getInstance()->getReputacionValor($fin)->getId();
            Reputacion::getInstance()->modificarInicio($fin+1, $idReputacion);
        }
    }

    private function modificarRango($inicio, $fin){
        $reputaciones = Reputacion::getInstance()->getReputaciones();


        $menor = -9999999;
        $idMenor = 0;
        foreach ($reputaciones as $reputacion) {
            if ($reputacion->getFin() < $inicio) {
                if ($reputacion->getFin() > $menor){
                    $menor = $reputacion->getFin();
                    $idMenor = $reputacion->getId();
                }
            }
        }
        if ($idMenor != 0){ Reputacion::getInstance()->modificarFin($inicio-1, $idMenor); }

        $mayor = 9999999;
        $idMayor = 0;
        foreach ($reputaciones as $reputacion) {
            if ($reputacion->getInicio() > $fin){
                if ($reputacion->getInicio() < $mayor){
                    $mayor = $reputacion->getInicio();
                    $idMayor = $reputacion->getId();
                }
            }
        }
        if ($idMayor != 0){ Reputacion::getInstance()->modificarInicio($fin+1, $idMayor); }


    }
}