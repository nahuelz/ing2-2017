<?php

class CreditosController {
    
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
    * CREDITOS
    */
    public function altaCreditos($args = []){
        if(UsuarioController::getInstance()->usuarioLogeado()){
            $precio = Creditos::getInstance()->getPrecio();
            $args = array_merge($args, ['user' => UsuarioController::getInstance()->usuarioLogeado(), 'precio' => $precio]);
            $view = new CargarCreditos();
            $view->show($args);
        }else{
            ResourceController::getInstance()->home();
        }
    }

    /*ALTA CREDITOS*/
    public function altaCreditosAction($args = []) {
        if (UsuarioController::getInstance()->usuarioLogeado()){
            if ( (isset($_POST['cantidad'])) AND (!empty($_POST['cantidad'])) && isset($_POST['password']) && !empty($_POST['password']) && isset($_POST['tarjeta']) && !empty($_POST['tarjeta']) && isset($_POST['mes']) && !empty($_POST['mes']) && isset($_POST['ano']) && !empty($_POST['ano']) && isset($_POST['ccv']) && !empty($_POST['ccv']) ) {
                $password = $_POST['password'];
                $tarjeta = $_POST['tarjeta'];
                $ano = $_POST['ano'];
                $mes = $_POST['mes'];
                $ccv = $_POST['ccv'];
                $nombre = $_POST['nombre'];
                $cantidad = $_POST['cantidad'];
                $user = UsuarioController::getInstance()->usuarioLogeado();
                if($password == $user->getPassword()){
                    $precioUnitario = $_POST['precio'];
                    $fecha = Date('Y-m-d');
                    $this->incrementarCreditos($cantidad);
                    Creditos::getInstance()->guardarRegistro($user->getId(), $precioUnitario, $cantidad, $fecha);
                    UsuarioController::getInstance()->miCuenta(Message::getMessage(15));
                }else{
                    $msg = Message::getMessage(8);
                    $args = array_merge($msg, [$msg, 'nombre' => $nombre, 'tarjeta' => $tarjeta, 'cantidad' => $cantidad, 'ccv' => $ccv, 'mes' => $mes, 'ano' => $ano]);
                    $this->altaCreditos($args);
                }
            }else{
                $this->creditos(Message::getMessage(5));
            }
        }else{
            ResourceController::getInstance()->home();
        }
    }

    
    /*
    *   INCREMENTAR CREDITOS
    */
    public function incrementarCreditos($cantidad) {
        $user = UsuarioController::getInstance()->usuarioLogeado();
        $creditosAct = $user->getCreditos() + $cantidad;
        $user->setCreditos($creditosAct);
        $userId = $user->getId();
        UsuarioController::getInstance()->actualizarSession($user);
        Usuario::getInstance()->actualizarCreditos($userId, $creditosAct);
    }

    /*
     * DESCONTAR CREDITOS
     */
    public function descontarCreditos($cantidad) {
        $user = UsuarioController::getInstance()->usuarioLogeado();
        $creditosAct = $user->getCreditos() - $cantidad;
        $user->setCreditos($creditosAct);
        $userId = $user->getId();
        UsuarioController::getInstance()->actualizarSession($user);
        Usuario::getInstance()->actualizarCreditos($userId, $creditosAct);
    }
        

}