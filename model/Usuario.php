<?php

/*
 *
 *
 *
 */

class Usuario extends PDORepository {
    
    private static $instance;
    protected $id;
    protected $nombre;
    protected $apellido;
    protected $email;
    protected $telefono;
    protected $password;
    protected $creditos;
    protected $esAdmin;
    protected $habilitado;

    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    function __construct($id = null, $nombre = null, $apellido = null, $email = null, $password = null, $telefono = null, $creditos = null, $esAdmin = null, $habilitado = null){
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->email = $email;
        $this->password = $password;
        $this->telefono = $telefono;
        if ($creditos != null){
            $this->creditos = $creditos;
        }else{
            $this->creditos = 0;
        }

        if ($esAdmin != null){
            $this->esAdmin = $esAdmin;
        }else{
            $this->esAdmin = 0;
        }

        if ($habilitado != null){
            $this->habilitado = $habilitado;
        }else{
            $this->habilitado = 1;
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

    public function setApellido($apellido){
        $this->apellido= $apellido;
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

    public function setTelefono($telefono){
        $this->telefono = $telefono;
    }

    public function getTelefono(){
        return $this->telefono;
    }

    public function setPassword($password){
        $this->password = $password;
    }

    public function getPassword(){
        return $this->password;
    }

    public function setCreditos($creditos){
        $this->creditos = $creditos;
    }

    public function getCreditos(){
        return $this->creditos;
    }

    public function getEsAdmin(){
        return $this->esAdmin;
    }

    public function setHabilitado($habilitado){
        $this->habilitado = $habilitado;
    }

    public function getHabilitado(){
        return $this->habilitado;
    }

    public function registrarUsuario($nombre, $apellido, $email, $password, $telefono){
        $mapper = function($row) {};

        if (!$this->existeEmail($email)) {
            $sql = "INSERT INTO usuario (nombre, apellido, email, password, telefono, creditos, esAdmin, habilitado) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $values = [$nombre, $apellido, $email, $password, $telefono, 1, 0, 1];
            $this->queryList($sql, $values, $mapper);
            return Message::getMessage(3);
        }
        return Message::getMessage(4);
    }

    public function existeEmail($email) {
        $mapper = function($row) {};
        
        $answer = $this->queryList("SELECT * FROM usuario WHERE email=?", [$email], $mapper);
        
        return (count($answer) > 0);
    }

    public function existeEmailPassword($email, $pass) {
        $mapper=function($row){};
        $answer = $this->queryList("SELECT * FROM usuario WHERE email=? AND password=?;", [$email, $pass], $mapper);
        return (count($answer) > 0);
    }

    public function logear($email, $pass) {
        $mapper = function($row) {
            $resource = new Usuario($row['id'], $row['nombre'], $row['apellido'], $row['email'], $row['password'], $row['telefono'], $row['creditos'], $row['esAdmin'], $row['habilitado']);
            return $resource;
        };

        $answer = $this->queryList("SELECT * FROM usuario WHERE email=? AND password=?;", [$email, $pass], $mapper);
        if (count($answer) > 0) {
            $session = Session::getInstance();
            $session->usuario = $answer[0];
        }
        return (count($answer) > 0);
    }

    public function modificarUsuario($nombre, $apellido, $telefono, $email){
        $mapper=function($row){};
        $answer = $this->queryList("UPDATE usuario SET nombre=?, apellido =?,telefono=? WHERE email = ?", [$nombre, $apellido, $telefono, $email], $mapper);
        return $answer;
    }

    public function deshabilitarUsuario($email){
        $mapper=function($row){};
        $answer = $this->queryList("UPDATE usuario SET habilitado=? WHERE email = ?", [0, $email], $mapper);
        return $answer;
    }

    public function habilitarUsuario($email){
        $mapper=function($row){};
        $answer = $this->queryList("UPDATE usuario SET habilitado=? WHERE email = ?", [1, $email], $mapper);
        return $answer;
    }

    public function getUsuario($id) {
        $mapper = function($row) {
            $resource = new Usuario($row['id'], $row['nombre'], $row['apellido'], $row['email'], $row['password'], $row['telefono'], $row['creditos'], $row['esAdmin'], $row['habilitado']);
            return $resource;
        };

        $answer = $this->queryList("SELECT * FROM usuario WHERE id=?;", [$id], $mapper);
        return ($answer[0]);
    }

    public function cargarCreditos($idUsuario, $totalCreditos) {
        $mapper = function($row) {};
        $answer = $this->queryList("UPDATE usuario SET creditos = ? WHERE id = ?;", [$totalCreditos, $idUsuario], $mapper);
    }
}
