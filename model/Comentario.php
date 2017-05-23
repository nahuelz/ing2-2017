<?php

/*
 *
 *
 *
 */

class comentario extends PDORepository {
    
    private static $instance;
    protected $id;
    protected $idUsuario;
    protected $idFavor;
    protected $comentario;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    function __construct($id = null, $idUsuario = null, $idFavor = null, $comentario = null){
        $this->id = $id;
        $this->idUsuario = $idUsuario;
        $this->idFavor = $idFavor;
        $this->comentario = $comentario;        
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


    public function altaComentario($idUsuario, $idFavor, $comentario){
            $mapper = function($row) {};
            $sql = "INSERT INTO comentario (idUsuario, idFavor, comentario) VALUES (?, ?, ?)";
            $values = [$idUsuario, $idFavor, $comentario];
            $this->queryList($sql, $values, $mapper);
            $msg=Message::getMessage(12);
            FavorController::getInstance()->verDetalle($msg);
    }

    public function verComentario($id) {
         $mapper = function($row) {
            $resource = new Comentario($row['id'], $row['idUsuario'], $row['idFavor'], $row['comentario']);
            return $resource;
        };
        $answer = $this->queryList("SELECT * FROM comentario WHERE idFavor=? ",[$id], $mapper);
        return ($answer);
    }
    }