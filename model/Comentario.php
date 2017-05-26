<?php

/*
 *
 *
 *
 */

class Comentario extends PDORepository {
    
    private static $instance;
    protected $id;
    protected $idUsuario;
    protected $idFavor;
    protected $comentario;
    protected $respuesta;
    protected $nombreUsuario;
    protected $fecha;
    protected $fechaRespuesta;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    function __construct($id = null, $idUsuario = null, $idFavor = null, $comentario = null, $respuesta = null, $nombreUsuario = null, $fecha = null){
        $this->id = $id;
        $this->idUsuario = $idUsuario;
        $this->idFavor = $idFavor;
        $this->comentario = $comentario;    
        $this->respuesta = $respuesta;
        $this->nombreUsuario = $nombreUsuario;   
        $this->fecha = $fecha;
        return $this;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getId(){
        return $this->id;
    }

    public function setIdUsuario($idUsuario){
        $this->idUsuario = $idUsuario;
    }

    public function getIdUsuario(){
        return $this->idUsuario;
    }

    public function setIdFavor($idFavor){
        $this->id = $id;
    }

    public function getIdFavor(){
        return $this->idFavor;
    }

    public function setComentario($comentario){
        $this->comentario = $comentario;
    }

    public function getComentario(){
        return $this->comentario;
    }

    public function setRespuesta($respuesta){
        $this->respuesta = $respuesta;
    }

    public function getRespuesta(){
        return $this->respuesta;
    }

    public function setNombreUsuario($nombreUsuario){
        $this->nombreUsuario = $nombreUsuario;
    }

    public function getNombreUsuario(){
        return $this->nombreUsuario;
    }

    public function setFecha($fecha){
        $this->fecha = $fecha;
    }

    public function getFecha(){
        return $this->fecha;
    }

    public function setFechaRespuesta($fechaRespuesta){
        $this->fechaRespuesta = $fechaRespuesta;
    }

    public function getFechaRespuesta(){
        return $this->fechaRespuesta;
    }


    public function altaComentario($idFavor, $idUsuario, $comentario, $nombre, $fecha){
            $mapper = function($row) {};
            $sql = "INSERT INTO comentario (idUsuario, idFavor, comentario, nombreUsuario, fecha) VALUES (?, ?, ?, ?, ?)";
            $values = [$idUsuario, $idFavor, $comentario, $nombre, $fecha];
            $this->queryList($sql, $values, $mapper);
    }

    public function altaRespuesta($idComentario, $respuesta, $fechaRespuesta){
            $mapper = function($row) {};
            $sql = "UPDATE comentario SET respuesta= ?, fechaRespuesta=? WHERE id=?";
            $values = [$respuesta, $fechaRespuesta,$idComentario];
            $this->queryList($sql, $values, $mapper);
    }

    public function verComentario($id) {
         $mapper = function($row) {
            $resource = new Comentario($row['id'], $row['idUsuario'], $row['idFavor'], $row['comentario'], $row['respuesta'], $row['nombreUsuario'], $row['fecha']);
            return $resource;
        };
        $answer = $this->queryList("SELECT * FROM comentario WHERE idFavor=? ",[$id], $mapper);
        return ($answer);
    }
    }