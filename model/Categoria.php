<?php

/*
 *
 *
 *
 */

class Categoria extends PDORepository {
    
    private static $instance;
    protected $id;
    protected $nombre;
    protected $habilitada;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    function __construct($id = null, $nombre = null, $habilitada = null){
        $this->id = $id;
        $this->nombre = $nombre;
        if ($habilitada != null ) {
            $this->habilitada = $habilitada;
        }else{
            $this->habilitada = 1;
        }
        
        return $this;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getId(){
        return $this->id;
    }

    public function setNombre($nombre){
        $this->nombre = $nombre;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function estaHabilitada(){
        return $this->habilitada;
    }

    public function deshabilitar(){
        
    }

    public function agregarCategoria($nombreCategoria){
           $mapper = function($row) {};
            $habilitada=1;
            $sql = "INSERT INTO categoria (nombre,habilitada) VALUES (?,?)";
            $values = [$nombreCategoria,$habilitada];

            $this->queryList($sql, $values, $mapper);        
    }
    
    public function categoriasHabilitadas() {
        $mapper = function($row) {
            $resource = new Categoria($row['id'], $row['nombre'], $row['habilitada']);
            return $resource;
        };
        $answer = $this->queryList("SELECT * FROM Categoria WHERE habilitada=1;", [], $mapper);
        return ($answer);
    }
    public function editar($idCategoria, $nombre){
       $mapper=function($row){};
        $answer = $this->queryList("UPDATE categoria SET nombre=?  WHERE id = ?", [$nombre, $id], $mapper);
        return $answer;
    }

    public function getCategoria($id){
        $mapper = function($row) {
            $resource = new Categoria($row['id'], $row['nombre'], $row['habilitada']);
            return $resource;
        };

        $answer = $this->queryList("SELECT * FROM categoria WHERE id=?;", [$id], $mapper);
        return $answer[0];
    }

    public function existeCategoria($nombreCategoria){
    
        $mapper = function($row) {};
        
        $answer = $this->queryList("SELECT * FROM categoria WHERE nombre=?", [$nombreCategoria], $mapper);
        
        return (count($answer) > 0);
    }

    public function modificarCategoria($idCategoria, $nombreCategoria){
            $mapper = function($row) {};
            $sql = "UPDATE categoria SET nombre= ? WHERE id=?";
            $values = [$nombreCategoria, $idCategoria];
            $this->queryList($sql, $values, $mapper);
    }
    public function eliminarCategoria($idCategoria){
            $mapper = function($row) {};
            $sql = "DELETE FROM categoria WHERE id=?";
            $values = [$idCategoria];
            $this->queryList($sql, $values, $mapper);
    }
}