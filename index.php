<?php
/* CONTROLLER */
require_once('controller/ResourceController.php');
require_once('controller/UsuarioController.php');


/* MODEL */
require_once('model/PDORepository.php');
require_once('model/Usuario.php');
require_once('model/Message.php');
require_once('model/Session.php');


/* VIEW */
require_once('view/TwigView.php');
require_once('view/Home.php');
require_once('view/Login.php');
require_once('view/Registro.php');
require_once('view/MiCuenta.php');

if (isset($_GET["action"])){
    switch($_GET['action']){

        /* USUARIO */
        case 'login': { UsuarioController::getInstance()->login(); break; }
        case 'loginAction': { UsuarioController::getInstance()->loginAction(); break; }
        case 'registro' : { UsuarioController::getInstance()->registro(); break; }
        case 'registroAction': { UsuarioController::getInstance()->registroAction(); break; }
        case 'miCuenta': { UsuarioController::getInstance()->miCuenta(); break; }
        case 'editarCuenta': { UsuarioController::getInstance()->editarCuenta(); break; }
        case 'cerrarSesion': { UsuarioController::getInstance()->cerrarSesion(); break; }

        default: { ResourceController::getInstance()->home(); break; }
    }
} else {
    ResourceController::getInstance()->home();
}