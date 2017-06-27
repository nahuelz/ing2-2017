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
    public function registro($args = []){
        if (!$this->usuarioLogeado()){
            $view = new Registro();
            $view->show($args);
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
                if (!Usuario::getInstance()->existeEmail($email)) {
                    Usuario::getInstance()->registrarUsuario($nombre, $apellido, $email, $password, $telefono);
                    $this->login(Message::getMessage(3));
                }else{
                    $msg = Message::getMessage(4);
                    $args = array_merge($msg, ['nombre' => $nombre, 'apellido' => $apellido, 'email' => $email, 'password' => $password, 'telefono' => $telefono]);
                    $this->registro($args);
                }
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
            $user = Usuario::getInstance()->getUsuario($this->usuarioLogeado()->getId());
            $this->actualizarSession($user);
            $reputaciones = Reputacion::getInstance()->getReputaciones();
            $args = array_merge($args, ['reputaciones' => $reputaciones, 'user' => $user, 'localidad' =>  $this->usuarioLogeado()->getLocalidad()]);
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
                
                $userMod = new Usuario($user->getId(), $_POST['nombre'], $_POST['apellido'], $_POST['email'], $_POST['password'], $_POST['telefono'], $_POST['creditos'], $user->getPuntos(), $_POST['localidad']);
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
     * ACTUALIZAR SESSION
     */
    public function actualizarSession($user){
        $session = Session::getInstance();
        $session->usuario = $user;
    }

    /*
    ** CERRAR SESION
    */
    public function cerrarSesion(){
        Session::getInstance()->destroy();
        ResourceController::getInstance()->home();
    }

    /*
    ** REPORTE DE USUARIOS MEJOR PUNTUADOS
    */
    public function reporteUsuarios($args = []){
        if($this->usuarioLogeado()){
            if ($this->usuarioLogeado()->getEsAdmin()){
                $usuariosConMasPuntos= Usuario::getInstance()->usuariosConMasPuntos();
                $args = array_merge($args, ['user' => $this->usuarioLogeado(), 'usuarioConMasPuntos' =>  $usuariosConMasPuntos]);
                $view = new ReporteUsuarios();
                $view->show($args);
            }else{
                ResourceController::getInstance()->home();
            }
        }else{
            ResourceController::getInstance()->home();
        }
    }
    /*
    ** REPORTE GANANCIAS ENTRE DOS FECHAS
    */
    public function reporteGanancias($args = []){
        if($this->usuarioLogeado()){
            if ($this->usuarioLogeado()->getEsAdmin()){
                if (!array_key_exists('user', $args)) {
                     $args=array_merge($args, ['user' => $this->usuarioLogeado()]);
                }
                if(isset($_POST['fechaInicial'])&& !empty($_POST['fechaInicial']) && isset($_POST['fechaFinal']) && !empty($_POST['fechaFinal'])){

                    $fechaInicial=$_POST['fechaInicial'];
                    $fechaFinal=$_POST['fechaFinal'];
                    $reporteGanancias=ReporteGanancia::getInstance()->reporteGanancias($fechaInicial, $fechaFinal);
                    if(count($reporteGanancias)){
                        $totalPorPeriodo=$this->totalPeriodo($reporteGanancias);
                        $creditosPorPeriodo=$this->totalCreditos($reporteGanancias);
                        $mensaje=Message::getMessage(38);
                        $args = array_merge($args,$mensaje, ['reporteGanancias' => $reporteGanancias, 'fechaInicial' =>  $fechaInicial, 'fechaFinal' => $fechaFinal, 'totalPorPeriodo' => $totalPorPeriodo, 'creditosPorPeriodo' => $creditosPorPeriodo]);
                        $view = new reporteGanancias();
                        $view->show($args);
                    }else{
                        $mensaje=Message::getMessage(37);
                        $args=array_merge($args,$mensaje, ['fechaInicial' =>  $fechaInicial, 'fechaFinal' => $fechaFinal]);
                        $view = new reporteGanancias();
                        $view->show($args);
                    }

                }else{

                    $view = new reporteGanancias();
                    $view->show($args);
                }
            }else{
                ResourceController::getInstance()->home();
            }
        }else{
            ResourceController::getInstance()->home();
        }
    }

    private function totalPeriodo($reporte){
        $total=0;
        foreach ($reporte as $posicion => $elemento) {
            # code...
            $total=$total+$elemento->getTotalRecaudado();
        }
        return $total;
    }

    private function totalCreditos($reporte){
        $total=0;
        foreach ($reporte as $posicion => $elemento) {
            # code...
            $total=$total+$elemento->getCreditosVendidos();
        }
        return $total;
    }

    /*
     * VER DATOS
     */
     public function verDatos($args = []){
        if ($this->usuarioLogeado()){
            $userId = $_POST['userId'];
            $volver = $_POST['volver'];
            $favorId = $_POST['favorId'];
            $usuario = Usuario::getInstance()->getUsuario($userId);
            $args = array_merge($args, ['favorId' => $favorId, 'volver' => $volver, 'user' => $this->usuarioLogeado(), 'usuario' => $usuario]);
            $view = new VerDatos();
            $view->show($args);
        }else{
            ResourceController::getInstance()->home();
        }
    }
}
