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

    public function setUsuarioId($usuarioId){
        $this->usuarioId = $usuarioId;
    }

    public function getUsuarioId(){
        return $this->usuarioId;
    }

    public function setTitulo($titulo){
        $this->titulo = $titulo;
    }

    public function getTitulo(){
        return $this->titulo;
    }

    public function setDescripcion($descripcion){
        $this->descripcion = $descripcion;
    }

    public function getDescripcion(){
        return $this->descripcion;
    }

    public function setCategoriaId($categoriaId){
        $this->categoriaId = $categoriaId;
    }

    public function getCategoriaId(){
        return $this->categoriaId;
    }

    public function setLocalidad($localidad){
        $this->localidad = $localidad;
    }

    public function getLocalidad(){
        return $this->localidad;
    }

    public function setFechaPublicacion($fechaPublicacion){
        $this->fechaPublicacion = $fechaPublicacion;
    }

    public function getFechapublicacion(){
        return $this->fechaPublicacion;
    }

    public function setCerrada($cerrada){
        $this->cerrada = $cerrada;
    }

    public function getCerrada(){
        return $this->cerrada;
    }

    public function setImagen($imagen){
        $this->imagen = $imagen;
    }

    public function getImagen(){
        return $this->imagen;
    }


    public function altaFavor($usuarioId, $titulo, $descripcion, $categoriaId, $localidad, $fecha, $imagen){
        $mapper = function($row) {};

        $sql = "INSERT INTO favor (usuario_id, titulo, descripcion, categoria, localidad, fecha_publicacion, cerrada, imagen) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $values = [$usuarioId, $titulo, $descripcion, $categoriaId, $localidad, $fecha, 0, $imagen];
        $this->queryList($sql, $values, $mapper);
        return (Message::getMessage(10));
    }

    public function obtenerFavores(){
        $mapper = function($row) {
            $resource = new Favor($row['id'], $row['usuario_id'], $row['titulo'], $row['descripcion'], $row['categoria'], $row['localidad'], $row['fecha_publicacion'], $row['cerrada'], $row['imagen']);
            return $resource;
        };
        $answer = $this->queryList("SELECT * FROM Favor WHERE cerrada=0;", [], $mapper);
        return ($answer);
    }

    public function verFavor($id){
         $mapper = function($row) {
            $resource = new Favor($row['id'], $row['usuario_id'], $row['titulo'], $row['descripcion'], $row['categoria'], $row['localidad'], $row['fecha_publicacion'], $row['cerrada'], $row['imagen']);
            return $resource;
        };
        $answer = $this->queryList("SELECT * FROM Favor WHERE cerrada=? AND id=?;", [0, $id], $mapper);
        return ($answer);
    }

    public function obtenerFavoresAsc(){
        $mapper = function($row) {
            return $row;
        };

        $answer = $this->queryList("SELECT COUNT(*) as cantidadPostulantes, favor.id as favorId, favor.titulo as titulo, favor.fecha_publicacion as fecha FROM favor LEFT JOIN postulacion ON favor.id = postulacion.idFavor GROUP BY favor.id ORDER BY cantidadPostulantes ASC;", [], $mapper);
        return ($answer);
    }

}