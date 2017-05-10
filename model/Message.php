<?php

/*
**  Descripcion de Message
**      
*/

class Message {

    public static function getMessage($message) {
        switch ($message) {
            case 0:
                return ['message' => 'Ups! No tiene permiso para acceder a ese lugar.', 'tipo' => 'warning'];
            case 1:
                return ['message' => 'El usuario o la contraseña son incorrectas.', 'tipo' => 'warning'];
            case 2:
                return ['message' => 'Se ha iniciado sesion exitosamente.', 'tipo' => 'success'];
            case 3:
                return ['message' => 'Se ha registrado exitosamente.', 'tipo' => 'success'];
            case 4:
                return ['message' => 'Ya exite una cuenta registrada con ese email', 'tipo' => 'warning'];
            case 5:
                return ['message' => 'Error, los campos no se validaron correctamente.', 'tipo' => 'warning'];
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
            default:
                return ['message' => 'Ups! No hay un case para este numero de mensaje de error.', 'tipo' => 'warning'];
        }
    }

}