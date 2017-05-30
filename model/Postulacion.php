<?php

/*
 *
 *
 *
 */

class Postulacion extends PDORepository {
    
    private static $instance;
    protected $id;
    protected $idUsuario;
    protected $idFavor;
    protected $estado;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    function __construct($id = null, $idUsuario = null, $idFavor = null, $estado = null){
        $this->id = $id;
        $this->idUsuario = $idUsuario;
        $this->idFavor = $idFavor;
        $this->estado = $estado;        
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

    public function setEstado($estado){
        $this->estado = $estado;
    }

    public function getEstado(){
        return $this->estado;
    }

    public function altaPostulacion($idFavor, $idUsuario, $estado, $comentario){
            $mapper = function($row) {};
            $sql = "INSERT INTO postulacion (idFavor, idUsuario, estado, comentario) VALUES (?, ?, ?, ?)";
            $values = [$idFavor, $idUsuario, $estado, $comentario];
            $this->queryList($sql, $values, $mapper);
    }

    public function bajaPostulacion($idFavor, $idUsuario){
            $mapper = function($row) {};
            $sql = "DELETE FROM postulacion WHERE idFavor = ? AND idUsuario = ?;";
            $values = [$idFavor, $idUsuario];
            $this->queryList($sql, $values, $mapper);
    }

    public function estaPostulado($idFavor, $idUsuario){
            $mapper = function($row) {};
            $sql = "SELECT * FROM postulacion WHERE idFavor = ? AND idUsuario = ?";
            $values = [$idFavor, $idUsuario];
            $answer = $this->queryList($sql, $values, $mapper);
            return (count($answer));
    }

    public function favoresPostulados($userId){
        $mapper = function($row){return $row;};
        $sql = "SELECT * FROM `postulacion` INNER JOIN `favor` WHERE postulacion.idFavor = favor.id AND postulacion.idUsuario = ?";
        $values = [$userId];
        $answer = $this->queryList($sql, $values, $mapper);
        return $answer;

    }

    public function aceptarPostulante($userId){
        $mapper = function($row){};
        $sql = "UPDATE postulacion SET estado = 'A' WHERE idUsuario = ?";
        $values = [$userId];
        $answer = $this->queryList($sql, $values, $mapper);
    
        return $answer;

    }



}