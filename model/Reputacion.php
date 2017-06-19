<?php

/*
 *
 *
 *
 */

class Reputacion extends PDORepository {
    
    private static $instance;
    protected $id;
    protected $nombre;
    protected $inicio;
    protected $fin;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    function __construct($id = null, $nombre = null, $inicio = null, $fin = null){
        $this->id = $id;
        $this->nombre = $nombre;
        $this->inicio = $inicio;
        $this->fin = $fin;
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

    public function setInicio($inicio){
        $this->inicio = $inicio;
    }

    public function getInicio(){
        return $this->inicio;
    }

    public function setFin($fin){
        $this->fin = $fin;
    }

    public function getFin(){
        return $this->fin;
    }

    public function altaReputacion($nombre, $inicio, $fin) {
        $mapper = function($row) {};
        $answer = $this->queryList("INSERT INTO reputacion (nombre, inicio, fin) VALUES (?, ?, ?);", [$nombre, $inicio, $fin], $mapper);
    }

    public function getReputaciones() {
        $mapper = function($row) {
            $resource = new Reputacion($row['id'], $row['nombre'], $row['inicio'], $row['fin']);
            return $resource;
        };
        $answer = $this->queryList("SELECT * FROM Reputacion ORDER BY inicio;", [], $mapper);
        return ($answer);
    }

    public function getReputacionValor($valor) {
        $mapper = function($row) {
            $resource = new Reputacion($row['id'], $row['nombre'], $row['inicio'], $row['fin']);
            return $resource;
        };
        $answer = $this->queryList("SELECT * FROM Reputacion WHERE inicio <= ? AND fin >=? ;", [$valor, $valor], $mapper);

        if (count($answer) > 0){
            return ($answer[0]);
        }else{
            return 0;
        }
        
    }

    public function getReputacion($id) {
        $mapper = function($row) {
            $resource = new Reputacion($row['id'], $row['nombre'], $row['inicio'], $row['fin']);
            return $resource;
        };
        $answer = $this->queryList("SELECT * FROM Reputacion WHERE id=?;", [$id], $mapper);
        if (count($answer) > 0){
            return ($answer[0]);
        }else{
            return 0;
        }
    }

    public function existeNombre($nombre) {
        $mapper = function($row) {};
        $answer = $this->queryList("SELECT * FROM Reputacion WHERE nombre=?;", [$nombre], $mapper);
        return (count($answer) > 0);
    }

    public function modificarFin($fin, $id) {
        $mapper = function($row) {};
        $answer = $this->queryList("UPDATE reputacion SET fin = ? WHERE id = ?;", [$fin, $id], $mapper);
    }

    public function modificarInicio($inicio, $id) {
        $mapper = function($row) {};
        $answer = $this->queryList("UPDATE reputacion SET inicio = ? WHERE id = ?;", [$inicio, $id], $mapper);
    }

    public function eliminar($id) {
        $mapper = function($row) {};
        $answer = $this->queryList("DELETE FROM reputacion WHERE id = ?", [$id], $mapper);
    }


}
