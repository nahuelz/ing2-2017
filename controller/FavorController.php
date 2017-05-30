<?php

class FavorController {
    
    private static $instance;

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }    
    private function __construct() {
        
    }

    
    /*
    *   ALTA FAVOR
    */
    public function altaFavor($args = []) {
        if (UsuarioController::getInstance()->usuarioLogeado()){
            $categorias = Categoria::getInstance()->categoriasHabilitadas();
            $args = array_merge($args, ['user' => UsuarioController::getInstance()->usuarioLogeado(), 'categorias' => $categorias]);
            $view = new AltaFavor();
            $view->show($args);
        }else{
            ResourceController::getInstance()->home();
        }

    }

    

    /*
    *   ALTA FAVOR ACTION
    */
    public function altaFavorAction($args = []) {
        if (UsuarioController::getInstance()->usuarioLogeado()){
            if ((isset($_POST['titulo']) AND isset($_POST['localidad']) AND !empty($_POST['localidad']) && isset($_POST['descripcion'])) AND !empty($_POST['titulo']) AND !empty($_POST['descripcion']) AND ($this->validarFormulario($_POST['titulo'],$_POST['descripcion']))) {
                $titulo = $_POST['titulo'];
                if (!Favor::getInstance()->existeTitulo($titulo)) {
                    $descripcion = $_POST['descripcion'];
                    $categoria = $_POST['categoria'];
                    $localidad = $_POST['localidad'];
                    $fecha = Date('Y-m-d');
                    $nombreImagen = '';
                    $usuarioId = UsuarioController::getInstance()->usuarioLogeado()->getId();

                    if ( (isset($_FILES['imagen'])) && ($_FILES['imagen']['size'] > 0) )  {
                        if ($this->validarImagen()){
                            $imagen = $this->procesarImagen();
                            $nombreImagen = $_FILES['imagen']['name'];
                            $msg =  Favor::getInstance()->altaFavor($usuarioId, $titulo, $descripcion, $categoria, $localidad, $fecha, $nombreImagen);
                            UsuarioController::getInstance()->descontarCreditos(1);
                            $this->misFavores($msg);
                        }else{
                            $this->misFavores(Message::getMessage(11));
                        }
                    }else{
                        $msg =  Favor::getInstance()->altaFavor($usuarioId, $titulo, $descripcion, $categoria, $localidad, $fecha, $nombreImagen);
                        UsuarioController::getInstance()->descontarCreditos(1);
                        $this->misFavores($msg);
                    }
                }else{
                    $this->altaFavor(Message::getMessage(21));
                }
            }else{
                $this->altaFavor(Message::getMessage(5));
            }
        }else{
            ResourceController::getInstance()->home(Message::getMessage(0));
        }
    }

    public function validarFormulario($titulo,$descripcion){

        if(strlen($titulo)>3 AND strlen($titulo)<255){
            if(strlen($descripcion)>3 AND strlen($descripcion)<=255){
                 return true;
            }
          } 

        return false;
    }
    
    public function validarImagen(){
        if (isset($_FILES['imagen']) && $_FILES['imagen']['size'] > 0){
            if ($_FILES['imagen']['size'] < 65000000){
                if ( (strpos($_FILES['imagen']['type'], "jpeg")) || (strpos($_FILES['imagen']['type'], "jpg")) || (strpos($_FILES['imagen']['type'], "png")) ){
                    return true;
                }
            }
        }
        return false;
    }

    public function procesarImagen(){
        $nombreImagen = $_FILES['imagen']['name'];
        $nombreTmp = $_FILES['imagen']['tmp_name'];
        move_uploaded_file($nombreTmp, './imagenes/'.$nombreImagen);

    }

    /*
    *   VER DETALLE
    */
    public function verDetalle($args = []) {
        if (UsuarioController::getInstance()->usuarioLogeado()){

            if (isset($_GET['id'])){
                $idFavor = $_GET['id'];  // "null! == func ()"
                if (null!==(Favor::getInstance()->verFavor($idFavor)[0])){
                    $favor = Favor::getInstance()->verFavor($idFavor)[0];
                    $comentarios= Comentario::getInstance()->verComentario($idFavor);
                    $userFavor = Usuario::getInstance()->getUsuario($favor->getUsuarioId());
                    $categoria = Categoria::getInstance()->getCategoria($favor->getCategoriaId());
                    $idUsuario =UsuarioController::getInstance()->usuarioLogeado()->getId();
                    $estaPostulado = Postulacion::getInstance()->estaPostulado($idFavor, $idUsuario);
                    $args = array_merge($args, ['user' => UsuarioController::getInstance()->usuarioLogeado(), 'favor' => $favor, 'comentarios' => $comentarios, 'userFavor' => $userFavor, 'categoria' => $categoria, 'estaPostulado' => $estaPostulado]);
                    $view = new DetalleFavor();
                    $view->show($args);
                }else{
                    ResourceController::getInstance()->home(Message::getMessage(23));
                }
            }else{

            }
        }else{
            ResourceController::getInstance()->home(Message::getMessage(17));
        }

    }

    /*
     * COMENTAR PUBLICACION
     */
    public function comentarFavor($args = []) {
        if (UsuarioController::getInstance()->usuarioLogeado()){
            $_GET['id'] = $_POST['idFavor']; // ES PARA FIXEAR UN ERROR CUANDO QUIERO CARGAR EL DETALLE, SE PIERDE EL ID DEL FAVOR
            if ((isset($_POST['idFavor'])) && (isset($_POST['comentario']))) {
                if ( (!empty($_POST['idFavor'])) && (!empty($_POST['comentario']))) {
                    $idFavor = $_POST['idFavor'];
                    $comentario = $_POST['comentario'];
                    $usuario= UsuarioController::getInstance()->usuarioLogeado();
                    $idUsuario = $usuario->getId();
                    $nombre = $usuario->getNombre();

                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                    $fecha = new \DateTime(); 
                    $fecha = date_format($fecha, 'Y-m-d H:i:s');

                    Comentario::getInstance()->altaComentario($idFavor, $idUsuario, $comentario, $nombre, $fecha);
                    $this->verDetalle(Message::getMessage(12));
                }else{
                    $this->verDetalle(Message::getMessage(5));
                }
            }else{
                $view = new DetalleFavor(Message::getMessage(5));
            }
        }else{
            ResourceController::getInstance()->home();
        }

    }

    /*
     * RESPONDER COMENTARIO
     */
    public function responderComentario($args = []) {
        if (UsuarioController::getInstance()->usuarioLogeado()){
            $_GET['id'] = $_POST['idFavor']; // ES PARA FIXEAR UN ERROR CUANDO QUIERO CARGAR EL DETALLE, SE PIERDE EL ID DEL FAVOR
            if ((isset($_POST['idComentario'])) && (isset($_POST['respuesta']))) {
                if ( (!empty($_POST['idComentario'])) && (!empty($_POST['respuesta']))) {
                    $idComentario = $_POST['idComentario'];
                    $respuesta = $_POST['respuesta'];
                    $usuario= UsuarioController::getInstance()->usuarioLogeado();
                    $idUsuario = $usuario->getId();
                    $nombre = $usuario->getNombre();

                    date_default_timezone_set('America/Argentina/Buenos_Aires');
                    $fechaRespuesta = new \DateTime(); 
                    $fechaRespuesta = date_format($fechaRespuesta, 'Y-m-d H:i:s');

                    Comentario::getInstance()->altaRespuesta($idComentario, $respuesta, $fechaRespuesta);
                    $this->verDetalle(Message::getMessage(12));
                }else{
                    $this->verDetalle(Message::getMessage(5));
                }
            } else{
                $view = new DetalleFavor(Message::getMessage(5));
            }
        }else{
            ResourceController::getInstance()->home();
        }

    }
    /*
     * POSTULARSE
     */
    
    public function postularse($args = []) {
        if (UsuarioController::getInstance()->usuarioLogeado()){
            $_GET['id'] = $_POST['idFavor']; // ES PARA FIXEAR UN ERROR CUANDO QUIERO CARGAR EL DETALLE, SE PIERDE EL ID DEL FAVOR
            if  ( (isset($_POST['idFavor'])) && (isset($_POST['comentario'])) && (!empty($_POST['idFavor'])) && (!empty($_POST['comentario'])) ) {
                $idFavor = $_POST['idFavor'];
                $comentario = $_POST['comentario'];
                $localidad = $_POST['localidad'];
                $nombre = $_POST['nombre'];
                $idUsuario = UsuarioController::getInstance()->usuarioLogeado()->getId();
                if (!Postulacion::getInstance()->estaPostulado($idFavor, $idUsuario)) {
                    $estado = 'E'; 
                    Postulacion::getInstance()->altaPostulacion($idFavor, $idUsuario, $estado, $comentario, $localidad, $nombre);
                    $this->verDetalle(Message::getMessage(13));
                }else{
                    $this->verDetalle(Message::getMessage(14));
                }
            }else{
                $this->verDetalle(Message::getMessage(5));
            }
        }else{
            ResourceController::getInstance()->home(Message::getMessage(0));
        }

    }

    /*
     * CANCELAR POSTULACION
     */
    public function cancelarPostulacion ($args = []){
        if (UsuarioController::getInstance()->usuarioLogeado()){
            $_GET['id'] = $_POST['idFavor']; // ES PARA FIXEAR UN ERROR CUANDO QUIERO CARGAR EL DETALLE, SE PIERDE EL ID DEL FAVOR
            if  ( (isset($_POST['idFavor'])) && (!empty($_POST['idFavor'])) ) {
                $idFavor = $_POST['idFavor'];
                $idUsuario = UsuarioController::getInstance()->usuarioLogeado()->getId();
                if (Postulacion::getInstance()->estaPostulado($idFavor, $idUsuario)) {
                    Postulacion::getInstance()->bajaPostulacion($idFavor, $idUsuario);
                    if ($_POST['from'] == 'detalleFavor')
                        $this->verDetalle(Message::getMessage(19));
                    else{
                        $this->favoresPostulados(Message::getMessage(19));
                    }
                }else{
                    $this->verDetalle(Message::getMessage(20));
                }
            }else{
                $this->verDetalle(Message::getMessage(5));
            }
        }else{
            ResourceController::getInstance()->home(Message::getMessage(0));
        }
    }

    /*
     * buscarFavor
     */
    public function buscarFavor($args=[]){
        if ( (isset($_GET['localidad'])) && (isset($_GET['categoria'])) && isset($_GET['titulo']) ){
            $localidad = $_GET['localidad'];
            $categoria = $_GET['categoria'];
            $titulo = $_GET['titulo'];
            $favores = Favor::getInstance()->obtenerFavoresBusqueda($titulo, $localidad, $categoria);
            if ($favores == []) {
                $args = Message::getMessage(16);
            }else{
                $args = array_merge($args, ['favores' => $favores,'titulo' => $titulo, 'localidad' => $localidad, 'categoria' => $categoria]);
            } 
            ResourceController::getInstance()->home($args);
        }
    }

    /*
     * MIS POSTULACIONES
     */

    public function favoresPostulados($args=[]){
        if (UsuarioController::getInstance()->usuarioLogeado()){
            $userId = UsuarioController::getInstance()->usuarioLogeado()->getId();
            $favoresPostulados = Postulacion::getInstance()->favoresPostulados($userId);
            $args = array_merge($args, ['user' => UsuarioController::getInstance()->usuarioLogeado(), 'favores' => $favoresPostulados]);
            $view = new FavoresPostulados();
            $view->show($args);
        }else{
            ResourceController::getInstance()->home(Message::getMessage(0));
        }
    }



    /*
     * MIS FAVORES
     */
    public function verFavores($args = []){
        if (UsuarioController::getInstance()->usuarioLogeado()){
            $userId = UsuarioController::getInstance()->usuarioLogeado()->getId();
            $favoresSolicitados = Favor::getInstance()->favoresSolicitados($userId);
            $args = array_merge($args, ['user' => UsuarioController::getInstance()->usuarioLogeado(), 'favores' => $favoresSolicitados]);
            $view = new FavoresSolicitados();
            $view->show($args);
        }else{
            ResourceController::getInstance()->home(Message::getMessage(0));
        }
    }

    public function misFavores($args=[]){
        if (UsuarioController::getInstance()->usuarioLogeado()){
            $userId = UsuarioController::getInstance()->usuarioLogeado()->getId();
            $favoresSolicitados = Favor::getInstance()->favoresSolicitados($userId);
            $args = array_merge($args, ['user' => UsuarioController::getInstance()->usuarioLogeado(), 'favores' => $favoresSolicitados]);
            $view = new FavoresSolicitados();
            $view->show($args);
        }else{
            ResourceController::getInstance()->home(Message::getMessage(0));
        }
    }

    /*
     * CERRAR FAVOR 
     */
    public function finalizarFavor($args = []){
        if (UsuarioController::getInstance()->usuarioLogeado()){
            if ( (isset($_POST['idFavor'])) && !empty($_POST['idFavor'])  ){
                $idFavor = $_POST['idFavor'];
                Favor::getInstance()->finalizarFavor($idFavor);
                $this->verFavores(Message::getMessage(22));
            }else{
                ResourceController::getInstance()->home(Message::getMessage(99));
            }
        }else{
            ResourceController::getInstance()->home(Message::getMessage(0));
        }

    }

    /*
     * VER POSTULANTES
     */
    public function verPostulantes ($args = []){
        if (UsuarioController::getInstance()->usuarioLogeado()){
            if ( (isset($_POST['idFavor'])) && !empty($_POST['idFavor'])  ){
                $idFavor = $_POST['idFavor'];
                $idUsuario = UsuarioController::getInstance()->usuarioLogeado()->getId();
                $favor = Favor::getInstance()->getFavor($idFavor)[0];
                if ($favor->getUsuarioId() == $idUsuario){ //  valido que sea su favor. una persona no podria ver los
                                                                        // postulantes del favor de otra persona
                    $postulantes = Favor::getInstance()->getPostulantes($idUsuario, $idFavor);
                    $args = array_merge($args, ['user' => UsuarioController::getInstance()->usuarioLogeado(), 'favor' => $favor, 'postulantes' => $postulantes]);
                    $view = new VerPostulantes();
                    $view->show($args);


                }
            }else{
                ResourceController::getInstance()->home();
            }

        }else{
            ResourceController::getInstance()->home(Message::getMessage(0));
        }
    }

    public function aceptarPostulante($args=[]){
        if (UsuarioController::getInstance()->usuarioLogeado()){
            if ( (isset($_POST['idPostulante'])) && (!empty($_POST['idPostulante'])) && (isset($_POST['idFavor'])) && (!empty($_POST['idFavor'])) ) {
                $idPostulante = $_POST['idPostulante'];
                $idFavor = $_POST['idFavor'];
                Favor::getInstance()->cerrarFavor($idFavor, $idPostulante);
                Postulacion::getInstance()->aceptarPostulante($idPostulante);
                $this->misFavores();
            }else{
                $this->VerPostulantes(Message::getMessage(5));
            }
        }else{
            ResourceController::getInstance()->home(Message::getMessage(0));
        }
    }

    public function calificarPostulante($args=[]){
        if (UsuarioController::getInstance()->usuarioLogeado()){
            if ( (isset($_POST['idPostulante'])) && (!empty($_POST['idPostulante'])) && (isset($_POST['idFavor'])) && (!empty($_POST['idFavor'])) ) {
                $idPostulante = $_POST['idPostulante'];
                $idFavor = $_POST['idFavor'];
                $args = array_merge($args, ['user' => UsuarioController::getInstance()->usuarioLogeado()]);
                $view = new CalificarPostulante();
                $view->show($args);
            }else{
                $this->VerPostulantes();
            }
        }else{
            ResourceController::getInstance()->home(Message::getMessage(0));
        }
    }


    
}