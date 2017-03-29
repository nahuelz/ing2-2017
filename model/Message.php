<?php

/*
**  Descripcion de Message
**      
*/

class Message {

    public static function getMessage($message) {
        switch ($message) {
            case 0:
                return ['message' => 'Ups! No tiene permiso para acceder a ese lugar.'];
            case 1:
                return ['message' => 'El usuario o la contraseña son incorrectas.'];
            case 2:
                return ['message' => 'Se ha iniciado sesion exitosamente.'];
            case 3:
                return ['message' => 'Se ha registrado exitosamente.'];
            case 4:
                return ['message' => 'Ya exite una cuenta registrada con ese email'];
            case 5:
                return ['message' => 'Error, debe completar todos los campos.'];
            case 6:
                return ['message' => 'Datos modificados correctamente, por favor vuelve a iniciar sesion'];
            case 7:
                return ['message' => 'Error, no puedes modificar el email.'];
            case 8:
                return ['message' => 'Error, password incorrecto'];
            case 9:
                return ['message' => 'Error, no puedes modificar los creditos desde aqui'];
            default:
                return ['message' => 'Ups! No hay un case para este numero de mensaje de error.'];
        }
    }

}