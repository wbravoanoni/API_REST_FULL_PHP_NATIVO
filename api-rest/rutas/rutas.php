<?php

use Controllers\Cursos_controller;
use Controllers\Clientes_controller;

   $arrayRutas    = explode("/",$_SERVER["REQUEST_URI"]);
   $requestMethod = $_SERVER[ "REQUEST_METHOD" ];

   //echo $_SERVER["REQUEST_URI"];

   if( isset(array_filter($arrayRutas)[4]) ){
    $idBusqueda = array_filter($arrayRutas)[4];
   }else{
    $idBusqueda = null;
   }

    if( $arrayRutas[3] === 'cursos' and $requestMethod === 'GET' and (is_numeric($idBusqueda)) ){
        $cursos = new Cursos_controller;
        $cursos->show($idBusqueda);
    }else if( $arrayRutas[3] === 'cursos' and $requestMethod === 'GET' and (isset($_GET['pagina']) && is_numeric($_GET['pagina']))  ){
        $cursos = new Cursos_controller;
        $cursos->index($_GET['pagina']);
    }else if( $arrayRutas[3] === 'cursos' and $requestMethod === 'GET' ){
        $cursos = new Cursos_controller;
        $cursos->index(null);
    }else if($arrayRutas[3] === 'cursos' and $requestMethod === 'PUT' and (is_numeric($idBusqueda)) ){
        $cursos = new Cursos_controller;
        $cursos->update($idBusqueda);
    }else if($arrayRutas[3] === 'cursos' and $requestMethod === 'DELETE' and (is_numeric($idBusqueda)) ){
        $cursos = new Cursos_controller;
        $cursos->delete($idBusqueda);
    }else if($arrayRutas[3] === 'cursos' and $requestMethod === 'POST' ){
        $cursos = new Cursos_controller;
        $cursos->create();
    }elseif( $arrayRutas[3] === 'clientes' and $requestMethod === 'POST'  ){
        $cliente = new Clientes_controller;
        $cliente->index();
    }elseif( $arrayRutas[3] === 'registros' and $requestMethod === 'POST' ){
        $cliente = new Clientes_controller;
        $cliente->create();
    }else{
        echo json_encode(["detalle" => "ruta no encontrada"]);
    }

?>