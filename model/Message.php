<?php

/*
**  Descripcion de Message
**      
*/

class Message {

    public static function getMessage($message) {
        switch ($message) {
            case 0:
                return ['message' => 'Ups! No tiene permiso para acceder a este lugar.', 'tipo' => 'warning'];
            case 1:
                return ['message' => 'El usuario o la contraseña son incorrectas.', 'tipo' => 'warning'];
            case 2:
                return ['message' => 'Se ha iniciado sesion exitosamente.', 'tipo' => 'success'];
            case 3:
                return ['message' => 'Se ha registrado exitosamente.', 'tipo' => 'success'];
            case 4:
                return ['message' => 'Ya exite una cuenta registrada con este email', 'tipo' => 'warning'];
            case 5:
                return ['message' => 'Error, complete todos los campos.', 'tipo' => 'warning'];
            case 6:
                return ['message' => 'Datos modificados correctamente', 'tipo' => 'success'];
            case 7:
                return ['message' => 'Error, no puedes modificar el email.', 'tipo' => 'warning'];
            case 8:
                return ['message' => 'Error, password incorrecto', 'tipo' => 'warning'];
            case 9:
                return ['message' => 'Error, no puedes modificar los creditos desde aqui', 'tipo' => 'warning'];
            case 10:
                return ['message' => 'Publicacion creada', 'tipo' => 'success'];
            case 11:
                return ['message' => 'Error, seleccione una imagen valida', 'tipo' => 'warning'];
            case 12:
                return ['message' => 'Se ha comentado exitosamente', 'tipo' => 'success'];
            case 13:
                return ['message' => 'Te has postulado exitosamente a este favor', 'tipo' => 'success'];
            case 14:
                return ['message' => 'Ya te encuentras postulado a este favor!', 'tipo' => 'warning'];
            case 15:
                return ['message' => 'Se han cargado exitosamente los creditos', 'tipo' => 'success'];
            case 16:
                return ['message' => 'No se han encontrado resultados para la busqueda', 'tipo' => 'warning'];
            case 17:
                return ['message' => 'Debes iniciar sesion para poder ver esta publicacion.', 'tipo' => 'warning'];
            case 18:
                return ['message' => 'Postulante aceptado.', 'tipo' => 'success'];
            case 19:
                return ['message' => 'Postulacion cancelada', 'tipo' => 'success'];
            case 20:
                return ['message' => 'No eres postulante en este favor', 'tipo' => 'warning'];
            case 21:
                return ['message' => 'El titulo ya existe.', 'tipo' => 'warning'];
            case 22:
                return ['message' => 'Se elimino el favor', 'tipo' => 'success'];
            case 23:
                return ['message' => 'No se encontro el favor', 'tipo' => 'warning'];
            case 24:
                return ['message' => 'Seleccione una localidad', 'tipo' => 'warning'];
            case 25:
                return ['message' => 'No tiene creditos suficientes', 'tipo' => 'warning'];
            case 26:
                return ['message' => 'El favor no se puede eliminar ya que no se encuentra abierto', 'tipo' => 'warning'];
            case 27:
                return ['message' => 'Se dio de alta el rango', 'tipo' => 'success'];
            case 28:
                return ['message' => 'Error, el rango ingresado superpone completame a un rango existente', 'tipo' => 'danger'];
            case 29:
                return ['message' => 'Error, ingrese un rango valido', 'tipo' => 'danger'];
            case 30:
                return ['message' => 'Error, el nombre ya existe', 'tipo' => 'danger'];
            case 31:
                return ['message' => 'Reputacion  eliminada', 'tipo' => 'success'];
            case 32:
                return ['message' => 'Categoria modificada correctamente', 'tipo' => 'success'];
            case 33:
                return ['message' => 'Categoria agregada correctamente', 'tipo' => 'success'];
            case 34:
                return ['message' => 'Ya existe esa categoria', 'tipo' => 'danger'];
            case 35:
                return ['message' => 'Se ha eliminado la categoria correctamente', 'tipo' => 'success'];
            case 36:
                return ['message' => 'Debe elegir otro nombre para la categoria', 'tipo' => 'warning'];
            case 37:
                return ['message' => 'No se encontraron ganancias entre esas fechas', 'tipo' => 'warning'];
            case 38:
                return ['message' => 'Se encontraron ganancias entre esas fechas', 'tipo' => 'success'];
            case 39:
                return ['message' => 'No se puede borrar la Categoria, ya que tiene favores', 'tipo' => 'warning'];
            default:
                return ['message' => 'Ups! No hay un case para este numero de mensaje de error.', 'tipo' => 'warning'];
        }
    }

}