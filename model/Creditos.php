<?php

/*
 *
 *
 *
 */

class Creditos extends PDORepository {
    
    private static $instance;
    protected $id;
    protected $precioUnitario;
    protected $cantidad;
    protected $fecha;


    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    function __construct($id = null, $precioUnitario = null, $cantidad = null, $fecha = null){
        $this->id = $id;
        $this->precioUnitario = $precioUnitario;
        $this->cantidad = $cantidad;
        $this->fecha = $fecha;
        
        return $this;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getId(){
        return $this->id;
    }

    public function setPrecioUnitario($precioUnitario){
        $this->precioUnitario = $precioUnitario;
    }

    public function getPrecioUnitario(){
        return $this->precioUnitario;
    }

    public function setCantidad($cantidad){
        $this->cantidad = $cantidad;
    }

    public function getCantidad(){
        return $this->cantidad;
    }

    public function setFecha($fecha){
        $this->fecha = $fecha;
    }

    public function getFecha(){
        return $this->fecha;
    }

    public function guardarRegistro($usuarioId, $precioUnitario, $cantidad, $fecha){
        $mapper = function($row) {};
        $sql = "INSERT INTO creditos (usuarioId, precioUnitario, cantidad, fecha) VALUES (?, ?, ?, ?)";
        $values = [$usuarioId, $precioUnitario, $cantidad, $fecha];
        $this->queryList($sql, $values, $mapper);
    }
}