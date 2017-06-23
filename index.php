<?php
//error_reporting(0);
/* CONTROLLER */
require_once('controller/ResourceController.php');
require_once('controller/UsuarioController.php');
require_once('controller/FavorController.php');
require_once('controller/CreditosController.php');
require_once('controller/ReputacionController.php');
require_once('controller/CategoriaController.php');



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
require_once('model/Calificacion.php');
require_once('model/Reputacion.php');
require_once('model/Categoria.php');

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
require_once('view/FavoresPostulados.php');
require_once('view/FavoresSolicitados.php');
require_once('view/VerPostulantes.php');
require_once('view/CalificarPostulante.php');
require_once('view/ConfirmarEliminacion.php');
require_once('view/EditarFavor.php');
require_once('view/VerReputacion.php');
require_once('view/AltaReputacion.php');
require_once('view/VerCategorias.php');
require_once('view/ModificarCategoria.php');
require_once('view/AltaCategoria.php');


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
        case 'solicitarEliminarFavor' : { FavorController::getInstance()->solicitarEliminarFavor(); break; }
        case 'eliminarFavor' : { FavorController::getInstance()->eliminarFavor(); break; }
        case 'eliminarFavorConPostulante' : { FavorController::getInstance()->eliminarFavorConPostulante(); break; }
        case 'verPostulantes' : { FavorController::getInstance()->verPostulantes(); break; }
        case 'aceptarPostulante' : { FavorController::getInstance()->aceptarPostulante(); break; }
        case 'calificarPostulante' : { FavorController::getInstance()->calificarPostulante(); break; }
        case 'calificarPostulanteAction' : { FavorController::getInstance()->calificarPostulanteAction(); break; }
        case 'editarFavor' : { FavorController::getInstance()->editarFavor(); break; }
        case 'editarFavorAction' : { FavorController::getInstance()->editarFavorAction(); break; }

        /* CREDITOS */
        case 'altaCreditos': { CreditosController::getInstance()->altaCreditos(); break; }
        case 'altaCreditosAction': { CreditosController::getInstance()->altaCreditosAction(); break; }

        /* REPUTACION */
        case 'reputacion': { ReputacionController::getInstance()->reputacion(); break; }
        case 'altaReputacion': { ReputacionController::getInstance()->altaReputacion(); break; }
        case 'altaReputacionAction': { ReputacionController::getInstance()->altaReputacionAction(); break; }
        case 'eliminarReputacion': { ReputacionController::getInstance()->eliminarReputacion(); break; }
        //case 'modificarReputacion': { ReputacionController::getInstance()->modificarReputacion(); break; }

        /* CATEGORIA */
        case 'categoria': {CategoriaController::getInstance()->categorias();break;}
        case 'altaCategoria': {CategoriaController::getInstance()->altaCategoria();break;}
        case 'altaCategoriaAction': {CategoriaController::getInstance()->altaCategoriaAction();break;}
        case 'modificarCategoria': {CategoriaController::getInstance()->modificarCategoria();break;}
        case 'modificarCategoriaAction': {CategoriaController::getInstance()->modificarCategoriaAction();break;}
        case 'eliminarCategoria': { CategoriaController::getInstance()->eliminarCategoria(); break; }
        
        default: { ResourceController::getInstance()->home(); break; }
    }
} else {
    ResourceController::getInstance()->home();
}