<?php
/* CONTROLLER */
require_once('controller/ResourceController.php');
require_once('controller/UsuarioController.php');
require_once('controller/FavorController.php');



/* MODEL */
require_once('model/PDORepository.php');
require_once('model/Usuario.php');
require_once('model/Message.php');
require_once('model/Session.php');
require_once('model/Categoria.php');
require_once('model/Favor.php');
require_once('model/Comentario.php');
require_once('model/Postulacion.php');
require_once('model/Creditos.php');


/* VIEW */
require_once('view/TwigView.php');
require_once('view/Home.php');
require_once('view/Login.php');
require_once('view/Registro.php');
require_once('view/MiCuenta.php');
require_once('view/DeshabilitarCuenta.php');
require_once('view/CargarCreditos.php');
require_once('view/AltaFavor.php');
require_once('view/DetalleFavor.php');
require_once('view/favoresPostulados.php');
require_once('view/favoresSolicitados.php');
require_once('view/verPostulantes.php');

if (isset($_GET["action"])){
    switch($_GET['action']){

        /* USUARIO */
        case 'login': { UsuarioController::getInstance()->login(); break; }
        case 'loginAction': { UsuarioController::getInstance()->loginAction(); break; }
        case 'registro' : { UsuarioController::getInstance()->registro(); break; }
        case 'registroAction': { UsuarioController::getInstance()->registroAction(); break; }
        case 'miCuenta': { UsuarioController::getInstance()->miCuenta(); break; }
        case 'deshabilitarCuenta': { UsuarioController::getInstance()->deshabilitarCuenta(); break; }
        case 'deshabilitarCuentaAction': { UsuarioController::getInstance()->deshabilitarCuentaAction(); break; }
        case 'creditos': { UsuarioController::getInstance()->creditos(); break; }
        case 'cargarCreditos': { UsuarioController::getInstance()->altaCreditos(); break; }
        case 'editarCuenta': { UsuarioController::getInstance()->editarCuenta(); break; }
        case 'cerrarSesion': { UsuarioController::getInstance()->cerrarSesion(); break; }

        /* FAVOR */
        case 'altaFavor': { FavorController::getInstance()->altaFavor(); break; }
        case 'altaFavorAction': { FavorController::getInstance()->altaFavorAction(); break; }
        case 'verDetalle': { FavorController::getInstance()->verDetalle(); break; }
        case 'comentarFavor': { FavorController::getInstance()->comentarFavor(); break; }
        case 'responderComentario': { FavorController::getInstance()->responderComentario(); break; }
        case 'postularse' : { FavorController::getInstance()->postularse(); break; }
        case 'cancelarPostulacion' : { FavorController::getInstance()->cancelarPostulacion(); break; }
        case 'buscarFavor' : { FavorController::getInstance()->buscarFavor(); break; }
        case 'favoresPostulados' : { FavorController::getInstance()->favoresPostulados(); break; }
        case 'aceptarPostulante': { FavorController::getInstance()->aceptarPostulante(); break; }
        case 'misFavores': { FavorController::getInstance()->misFavores(); break; }
        case 'cerrarFavor' : { FavorController::getInstance()->cerrarFavor(); break; }
        case 'verPostulantes' : { FavorController::getInstance()->verPostulantes(); break; }
        
        default: { ResourceController::getInstance()->home(); break; }
    }
} else {
    ResourceController::getInstance()->home();
}