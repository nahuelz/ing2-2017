<?php

/*
 *
 *
 *
 */

class Favor extends PDORepository {
    
    private static $instance;
    protected $id;
    protected $usuarioId;
    protected $titulo;
    protected $descripcion;
    protected $categoriaId;
    protected $localidad;
    protected $fechaPublicacion;
    protected $cerrada;
    protected $imagen;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    function __construct($id = null, $usuarioId = null, $titulo = null, $descripcion = null, $categoriaId = null, $localidad = null, $fechaPublicacion = null, $fechaCierre = null, $imagen = null){
        $this->id = $id;
        $this->usuarioId = $usuarioId;
        $this->titulo = $titulo;
        $this->descripcion = $descripcion;
        $this->categoriaId = $categoriaId;
        $this->localidad = $localidad;
        $this->fechaPublicacion = $fechaPublicacion;
        $this->cerrada = 0;
        $this->imagen = $imagen;
        return $this;
    }

     public function setId($id){
        $this->id = $id;
    }

    public function getId(){
        return $this->id;
    }

    public function altaFavor($usuarioId, $titulo, $descripcion, $categoriaId, $localidad, $fecha){
        $mapper = function($row) {};

        $sql = "INSERT INTO favor (usuario_id, titulo, descripcion, categoria, localidad, fecha_publicacion, cerrada) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $values = [$usuarioId, $titulo, $descripcion, $categoriaId, $localidad, $fecha, 0];
        $this->queryList($sql, $values, $mapper);
        return (Message::getMessage(10));
    }

}