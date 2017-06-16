<?php

/*
 *
 *
 *
 */

class Calificacion extends PDORepository {
    
    private static $instance;
    protected $id;
    protected $comentario;
    protected $idUsuario;
    protected $idFavor;
    protected $calificacion;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    function __construct($id = null, $comentario = null, $idUsuario = null, $idFavor = null, $calificacion = null){
        $this->id = $id;
        $this->comentario = $comentario;
        $this->idUsuario = $idUsuario;
        $this->idFavor = $idFavor;
        $this->calificacion = $calificacion;
        return $this;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getId(){
        return $this->id;
    }

    public function setComentario($comentario){
        $this->comentario = $comentario;
    }

    public function getComentario(){
        return $this->comentario;
    }

    public function setIdUsuario($idUsuario){
        $this->idUsuario = $idUsuario;
    }

    public function getIdUsuario(){
        return $this->idUsuario;
    }

    public function setIdFavor($idFavor){
        return $this->idFavor;
        
    }

    public function setCalificacion($calificacion){
        $this->calificacion = $calificacion;
    }

    public function getCalificacion(){
        return $this->calificacion;
    }

    public function altaCalificacion($comentario, $idUsuario, $idFavor, $calificacion){
        $mapper = function($row) {};
        print_r($comentario); die();
        $sql = "INSERT INTO calificacion (comentario, idUsuario, idFavor, calificacion) VALUES (?, ?, ?, ?)";
        $values = [$comentario, $idUsuario, $idFavor, $calificacion];
        $this->queryList($sql, $values, $mapper);


    }

    

}