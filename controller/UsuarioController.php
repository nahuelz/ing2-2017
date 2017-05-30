<?php

class UsuarioController {
    
    private static $instance;

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }    
    private function __construct() {
    }

    public function usuarioLogeado() {
        $session = Session::getInstance();
        return ($session->usuario);
    }

 	/*
    ** LOGIN:
    */
    public function login($args = []) {
        if (!$this->usuarioLogeado()){
            $view = new Login();
            $view->show($args);
        }else{
            ResourceController::getInstance()->home();
        }
        
    }

    /*
    **	LOGIN ACTION
    */
    public function loginAction() {
        if (!$this->usuarioLogeado()){
            if ((isset($_POST['email']) AND isset($_POST['password'])) AND !empty($_POST['email']) AND !empty($_POST['password'])) {
                $email = $_POST['email'];
                $pass = $_POST['password'];
                if (Usuario::getInstance()->logear($email, $pass)){
                    ResourceController::getInstance()->home();
                }else{
                    $this->login(Message::getMessage(1));
                }
            } else {
                $this->login(Message::getMessage(5));
            }
        }else{
            ResourceController::getInstance()->home();
        }
    }

    /*
    **	REGISTRO
    */
    public function registro(){
        if (!$this->usuarioLogeado()){
            $view = new Registro();
            $view->show();
        }else{
            ResourceController::getInstance()->home($args);
        }
    }

    /*
    **	REGISTRO ACTION
    */
    public function registroAction(){  		
        if (!$this->usuarioLogeado()){
            if ( (isset($_POST['email']) AND isset($_POST['nombre']) AND isset($_POST['apellido']) AND isset($_POST['telefono']) AND isset($_POST['password'])) AND ( !empty($_POST['email']) AND !empty($_POST['nombre']) AND !empty($_POST['apellido']) AND !empty(['telefono']) AND !empty(['password'])))
            {
                $nombre = $_POST['nombre'];
                $apellido = $_POST['apellido'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $telefono = $_POST['telefono'];

    			$msg = Usuario::getInstance()->registrarUsuario($nombre, $apellido, $email, $password, $telefono);
                $this->login($msg);
    		} else {
    			$this->registro(Message::getMessage(5));
    		}
        }else{
            ResourceController::getInstance()->home($args);
        }
    }

    /*
    ** MI CUENTA
    */
    public function miCuenta($args = []){
        if ($this->usuarioLogeado()){
            $args = array_merge($args, ['user' => $this->usuarioLogeado(), 'localidad' =>  $this->usuarioLogeado()->getLocalidad()]);
            $view = new MiCuenta();
            $view->show($args);
        }else{
            ResourceController::getInstance()->home();
        }

    }

    /*
    ** EDITAR CUENTA
    */
    public function editarCuenta(){
        if ($this->usuarioLogeado()){
            $user = $this->usuarioLogeado();

            if ( isset($_POST['nombre']) AND isset($_POST['apellido']) AND isset($_POST['password']) AND isset($_POST['email']) AND isset($_POST['telefono']) AND !empty($_POST['nombre']) AND !empty($_POST['apellido']) AND !empty(['password']) AND !empty($_POST['email']) AND !empty($_POST['telefono'])) {
                
                $userMod = new Usuario($user->getId(), $_POST['nombre'], $_POST['apellido'], $_POST['email'], $_POST['password'], $_POST['telefono'], $_POST['creditos'], $_POST['localidad']);

                if($user->getPassword() == $userMod->getPassword()){
                    if ($user->getEmail() == $userMod->getEmail()){
                        if ($user->getCreditos() == $userMod->getCreditos()){
                            Usuario::getInstance()->modificarUsuario($userMod->getNombre(), $userMod->getApellido(), $userMod->getTelefono(), $userMod->getEmail(), $userMod->getLocalidad());
                                $session = Session::getInstance();
                                $session->usuario = $userMod;
                            $this->miCuenta(Message::getMessage(6));
                        }else{
                            $this->miCuenta(Message::getMessage(9));
                        }  
                    }else{
                        $this->miCuenta(Message::getMessage(7));
                    }
                }else{
                    $this->miCuenta(Message::getMessage(8));
                }
            }else{
                $this->miCuenta(Message::getMessage(5));
            }
        }else{
            ResourceController::getInstance()->home();
        }
    }
    /*
    ** VALIDAR DATOS Y FORMATO DE CAMPOS EDITAR CUENTA
    */
    public function validarEditarCuenta() {
        $nombre=$_POST['nombre'];
        $apellido=$_POST['apellido'];
        $telefono=$_POST['telefono'];
        $password=$_POST['password'];

        if(ctype_alpha($nombre) AND strlen($nombre)>=3 AND strlen($nombre)<=20){
            if(ctype_alpha($apellido) AND strlen($apellido)>=3 AND strlen($apellido)>=20){
                if(ctype_digit($telefono) AND strlen($telefono)>=6 AND strlen($telefono)>=20){
                    return true;
                }
            }
        }

        return false;
    }

    /*
    ** DESHABILITAR CUENTA
    */
    public function deshabilitarCuenta($args = []){
        if($this->usuarioLogeado()){
            $args = array_merge($args, ['user' => $this->usuarioLogeado()]);
            $view = new deshabilitarCuenta();
            $view->show($args);
        }else{
            ResourceController::getInstance()->home();
        }
    }

    /*
    ** DESHABILITAR CUENTA ACTION
    */
    public function deshabilitarCuentaAction($args = []){
        if($this->usuarioLogeado()){
            Usuario::getInstance()->deshabilitarUsuario($this->usuarioLogeado()->getEmail());
            Session::getInstance()->destroy();
            ResourceController::getInstance()->home();
        }else{
            ResourceController::getInstance()->home();
        }
    }

    /*
    ** CREDITOS
    */
    public function creditos($args = []){
        if($this->usuarioLogeado()){
            $precio = Creditos::getInstance()->getPrecio();
            $args = array_merge($args, ['user' => $this->usuarioLogeado(), 'precio' => $precio]);
            $view = new CargarCreditos();
            $view->show($args);
        }else{
            ResourceController::getInstance()->home();
        }
    }
    
    /*ALTA CREDITOS*/
    public function altaCreditos($args = []) {
        if (UsuarioController::getInstance()->usuarioLogeado()){
            if ( (isset($_POST['cantidad'])) AND (!empty($_POST['cantidad'])) && isset($_POST['password']) && !empty($_POST['password']) ) {
                $password = $_POST['password'];
                if($password == UsuarioController::getInstance()->usuarioLogeado()->getPAssworrd()){
                    $cantidad = $_POST['cantidad'];
                    $precioUnitario = $_POST['precio'];
                    $fecha = Date('Y-m-d');
                    $user = UsuarioController::getInstance()->usuarioLogeado();
                    $usuarioId = $user->getId();
                    $creditos = $user->getCreditos();
                    $totalCreditos = $cantidad + $creditos;
                    $user->setCreditos($totalCreditos);
                    $session = Session::getInstance();
                    $session->usuario = $user;
                    Usuario::getInstance()->actualizarCreditos($usuarioId, $totalCreditos);
                    Creditos::getInstance()->guardarRegistro($usuarioId, $precioUnitario, $cantidad, $fecha);
                    UsuarioController::getInstance()->miCuenta(Message::getMessage(15));
                }else{
                    
                }
            }else{
                $this->creditos(Message::getMessage(5));
            }
        }else{
            ResourceController::getInstance()->home();
        }
    }

    /*
     *DESCONTAR CREDITOS
     *Esta funcion es llamada al dar de alta un favor
     */
    public function descontarCreditos($cantidad) {
        $user = UsuarioController::getInstance()->usuarioLogeado();
        $usuarioId = $user->getId();
        $creditos = $user->getCreditos();
        $totalCreditos = $creditos - $cantidad;
        $user->setCreditos($totalCreditos);
        $session = Session::getInstance();
        $session->usuario = $user;
        Usuario::getInstance()->actualizarCreditos($usuarioId, $totalCreditos);
    }

    /*
    ** CERRAR SESION
    */
    public function cerrarSesion(){
        Session::getInstance()->destroy();
        ResourceController::getInstance()->home();
    }
}
