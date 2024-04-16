<?php

use Controllers\Cursos_controller;
use Controllers\Clientes_controller;

   $arrayRutas    = explode("/",$_SERVER["REQUEST_URI"]);
   $requestMethod = $_SERVER[ "REQUEST_METHOD" ];

   //echo $_SERVER["REQUEST_URI"];

    
    if( $arrayRutas[3] === 'cursos' and $requestMethod === 'GET' ){
        $cursos = new Cursos_controller;
        $cursos->index();
    }else if( $arrayRutas[3] === 'cursos' and $requestMethod === 'GET' and is_numeric(array_filter($arrayRutas)[4]) ){
        $cursos = new Cursos_controller;
        $cursos->show($arrayRutas[4]);
    }else if($arrayRutas[3] === 'cursos' and $requestMethod === 'PUT' and is_numeric(array_filter($arrayRutas)[4]) ){
        $cursos = new Cursos_controller;
        $cursos->update($arrayRutas[4]);
    }else if($arrayRutas[3] === 'cursos' and $requestMethod === 'DELETE' and is_numeric(array_filter($arrayRutas)[4]) ){
        $cursos = new Cursos_controller;
        $cursos->update($arrayRutas[4]);
    }else if($arrayRutas[3] === 'cursos' and $requestMethod === 'POST' ){
        $cursos = new Cursos_controller;
        $cursos->create();
    }elseif( $arrayRutas[3] === 'clientes' and $requestMethod === 'POST'  ){
        $cliente = new Clientes_controller;
        $cliente->index();
    }elseif( $arrayRutas[3] === 'registros' and $requestMethod === 'POST' ){

        $data = array("primer_nombre" => $_POST['primer_nombre'], "primer_apellido" => $_POST['primer_apellido'], "email" => $_POST['email']);
        $cliente = new Clientes_controller;
        $cliente->create($data);
    }else{
        echo json_encode(["detalle" => "ruta no encontrada"]);
    }

?>