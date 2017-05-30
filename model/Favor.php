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
    protected $estado;
    protected $imagen;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    function __construct($id = null, $usuarioId = null, $titulo = null, $descripcion = null, $categoriaId = null, $localidad = null, $fechaPublicacion = null, $estado = null, $imagen = null){
        $this->id = $id;
        $this->usuarioId = $usuarioId;
        $this->titulo = $titulo;
        $this->descripcion = $descripcion;
        $this->categoriaId = $categoriaId;
        $this->localidad = $localidad;
        $this->fechaPublicacion = $fechaPublicacion;
        if ($estado == null) {
            $this->estado = 'A';
        }else{
            $this->estado = $estado;
        }
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

    public function setEstado($estado){
        $this->estado = $estado;
    }

    public function getEstado(){
        return $this->estado;
    }

    public function setImagen($imagen){
        $this->imagen = $imagen;
    }

    public function getImagen(){
        return $this->imagen;
    }

    public function altaFavor($usuarioId, $titulo, $descripcion, $categoriaId, $localidad, $fecha, $imagen){
        $mapper = function($row) {};
        if(!$this->existeTitulo($titulo)){
            $sql = "INSERT INTO favor (usuario_id, titulo, descripcion, categoria, localidad, fecha_publicacion, estado, imagen) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $values = [$usuarioId, $titulo, $descripcion, $categoriaId, $localidad, $fecha, 'A', $imagen];
            $this->queryList($sql, $values, $mapper);
            return (Message::getMessage(10));
        }
        return Message::getMessage(21);
    }

    public function obtenerFavores(){
        $mapper = function($row) {
            $resource = new Favor($row['id'], $row['usuario_id'], $row['titulo'], $row['descripcion'], $row['categoria'], $row['localidad'], $row['fecha_publicacion'], $row['estado'], $row['imagen']);
            return $resource;
        };
        $answer = $this->queryList("SELECT * FROM Favor WHERE estado='A';", [], $mapper);
        return ($answer);
    }

    public function verFavor($id){
         $mapper = function($row) {
            $resource = new Favor($row['id'], $row['usuario_id'], $row['titulo'], $row['descripcion'], $row['categoria'], $row['localidad'], $row['fecha_publicacion'], $row['estado'], $row['imagen']);
            return $resource;
        };
        $answer = $this->queryList("SELECT * FROM Favor WHERE estado=? AND id=?;", ['A', $id], $mapper);
        return ($answer);
    }

    public function obtenerFavoresAsc(){
        $mapper = function($row) {
            return $row;
        };

        $answer = $this->queryList("SELECT COUNT(postulacion.id) as cantidadPostulantes, favor.imagen as imagen, favor.localidad as localidad, favor.id as favorId, favor.titulo as titulo, favor.fecha_publicacion as fecha FROM favor LEFT JOIN postulacion ON favor.id = postulacion.idFavor WHERE favor.estado = 'A' GROUP BY favor.id ORDER BY cantidadPostulantes ASC;", [], $mapper);
        return ($answer);
    }

    public function obtenerFavoresBusqueda($titulo, $localidad, $categoria){
        $mapper = function($row) {
            return $row;
        };

        if ($categoria != '') {
            $answer = $this->queryList("SELECT COUNT(postulacion.id) as cantidadPostulantes, favor.localidad as localidad, favor.id as favorId, favor.titulo as titulo, favor.fecha_publicacion as fecha FROM favor LEFT JOIN postulacion ON favor.id = postulacion.idFavor WHERE favor.estado = 'A' AND favor.titulo LIKE '%".$titulo."%' AND favor.localidad LIKE '%".$localidad."%' AND favor.categoria=".$categoria." GROUP BY favor.id ORDER BY cantidadPostulantes ASC;", [], $mapper);
        }else{
            $answer = $this->queryList("SELECT COUNT(postulacion.id) as cantidadPostulantes, favor.localidad as localidad, favor.id as favorId, favor.titulo as titulo, favor.fecha_publicacion as fecha FROM favor LEFT JOIN postulacion ON favor.id = postulacion.idFavor WHERE favor.estado = 'A' AND favor.titulo LIKE '%".$titulo."%' && favor.localidad LIKE '%".$localidad."%' GROUP BY favor.id ORDER BY cantidadPostulantes ASC;", [], $mapper);
        }
        return ($answer);
    }

    public function favoresSolicitados($userId){
        $mapper = function($row){
            $resource = new Favor($row['id'], $row['usuario_id'], $row['titulo'], $row['descripcion'], $row['categoria'], $row['localidad'], $row['fecha_publicacion'], $row['estado'], $row['imagen']);
            return $resource;
        };
        $sql = "SELECT * FROM favor WHERE usuario_id = ?;";
        $values = [$userId];
        $answer = $this->queryList($sql, $values, $mapper);
    
        return $answer;

    }

    public function existeTitulo($titulo){
        $mapper = function($row) {return $row;};
        $answer = $this->queryList("SELECT * FROM Favor WHERE titulo = ? AND estado='A';", [$titulo], $mapper);
        return (count($answer) > 0);
    }

    public function cerrarFavor($id){
         $mapper = function($row) {};
        $answer = $this->queryList("UPDATE favor SET estado = ? WHERE id = ?;", ['C', $id], $mapper);
        return ($answer);
    }

    public function getPostulantes($idUsuario, $idFavor){
        $mapper = function($row){return $row;};
        $sql = "SELECT * FROM favor INNER JOIN postulacion INNER JOIN usuario ON favor.id = postulacion.idFavor AND postulacion.idUsuario = usuario.id WHERE favor.id = ? AND favor.usuario_id = ? AND favor.estado = 'A';";
        $values = [$idFavor, $idUsuario];
        $answer = $this->queryList($sql, $values, $mapper);
    
        return $answer;
    }

    public function postulantes($idFavor){
        $mapper = function($row){return $row;};
        $sql = "SELECT * FROM favor INNER JOIN postulacion ON favor.id = postulacion.idFavor WHERE favor.id = ? AND favor.estado = 'A';";
        $values = [$idFavor];
        $answer = $this->queryList($sql, $values, $mapper);
    
        return $answer;
    }

    public function getFavor($id){
         $mapper = function($row) {
            $resource = new Favor($row['id'], $row['usuario_id'], $row['titulo'], $row['descripcion'], $row['categoria'], $row['localidad'], $row['fecha_publicacion'], $row['estado'], $row['imagen']);
            return $resource;
        };
        $answer = $this->queryList("SELECT * FROM Favor WHERE estado=? AND id=?;", ['A', $id], $mapper);
        return ($answer);
    }

}