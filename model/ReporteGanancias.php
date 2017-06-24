<?php

/*
 *
 *
 *
 */
 class ReporteGanancia extends PDORepository {
 	private static $instance;
    protected $totalRecaudado;
    protected $creditosVendidos;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    function __construct($totalRecaudado=null, $creditosVendidos=null){

        $this->totalRecaudado = $totalRecaudado;
        $this->creditosVendidos = $creditosVendidos;
        
        return $this;
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

            $resource = new ReporteGanancia($row['totalRecaudado'], $row['creditosVendidos']);
            return $resource;
        };

        $sql="SELECT SUM(precioUnitario) as totalRecaudado, SUM(cantidad) as creditosVendidos FROM creditos WHERE fecha BETWEEN ? AND ? ";
        $values=[$fechaInicial,$fechaFinal];
        $answer = $this->queryList($sql, $values, $mapper);
        return ($answer[0]);
    }
 }