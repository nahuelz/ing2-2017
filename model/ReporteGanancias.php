<?php

/*
 *
 *
 *
 */
 class ReporteGanancia extends PDORepository {
 	private static $instance;
    protected $nombre;
    protected $apellido;
    protected $email;
    protected $fecha;
    protected $totalRecaudado;
    protected $creditosVendidos;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    function __construct($nombre=null, $apellido=null, $email=null, $fecha=null, $creditosVendidos=null, $totalRecaudado=null){
        $this->nombre=$nombre;
        $this->apellido=$apellido;
        $this->email=$email;
        $this->fecha=$fecha;
        $this->totalRecaudado = $totalRecaudado;
        $this->creditosVendidos = $creditosVendidos;    
        return $this;
    }

    public function setNombre($nombre){
        $this->nombre = $nombre;
    }

    public function getNombre(){
        return $this->nombre;
    }
    public function setApellido($apellido){
        $this->apellido = $apellido;
    }

    public function getApellido(){
        return $this->apellido;
    }
    public function setEmail($email){
        $this->email = $email;
    }

    public function getEmail(){
        return $this->email;
    }
    public function setFecha($fecha){
        $this->fecha = $fecha;
    }

    public function getFecha(){
        return $this->fecha;
    }

    public function setTotalRecaudado($totalRecaudado){
        $this->totalRecaudado = $totalRecaudado;
    }

    public function getTotalRecaudado(){
        return $this->totalRecaudado;
    }

    public function setCreditosVendidos($creditosVendidos){
        $this->creditosVendidos = $creditosVendidos;
    }

    public function getCreditosVendidos(){
        return $this->creditosVendidos;
    }

    public function reporteGanancias($fechaInicial, $fechaFinal) {
        $mapper = function($row) {

            $resource = new ReporteGanancia($row['nombre'],$row['apellido'],$row['email'],$row['fecha'], $row['creditosVendidos'],$row['totalRecaudado']);
            return $resource;
        };

        $sql="SELECT usuario.nombre, usuario.apellido, usuario.email, creditos.fecha, creditos.cantidad as creditosVendidos, (creditos.cantidad * creditos.precioUnitario) as totalRecaudado FROM creditos INNER JOIN usuario ON creditos.usuarioId=usuario.id WHERE creditos.fecha BETWEEN ? AND ? ORDER BY totalRecaudado DESC";
        $values=[$fechaInicial,$fechaFinal];
        $answer = $this->queryList($sql, $values, $mapper);
        return ($answer);
    }
 }