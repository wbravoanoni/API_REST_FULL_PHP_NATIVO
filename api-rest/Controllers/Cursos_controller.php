<?php

namespace Controllers;

use Models\Cursos;
use Models\Clientes;

class Cursos_controller{
    
    public function index(){
        //Trabajar autenticacion
        if( isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW']) ){
            $data['PHP_AUTH_USER'] = $_SERVER['PHP_AUTH_USER'];
            $data['PHP_AUTH_PW'] = $_SERVER['PHP_AUTH_PW'];

            $clientes = new Clientes;
            $existe_llave = $clientes->buscar_llave($data);

            if($existe_llave){       
                $curso  = new Cursos();
                $cursos = $curso->index();
                echo json_encode(
                                    [
                                    "status" => 200,
                                    "total_registros"=> count($cursos),
                                    "detalle" => $cursos 
                                    ]
                                );
                return;
            }else{
                echo json_encode(
                    [
                    "status" => 404,
                    "detalle" => 'error pass token not found' 
                    ]
                );
            }
        }
    }

    public function show($id){
        echo json_encode(["detalle" => "Estas en la vista del cursos {$id}"]);
        return;
    }

    public function update($id){
        echo json_encode(["detalle" => "Estas en la vista del cursos actualizando el curso {$id}"]);
        return;
    }

    public function delete($id){
        echo json_encode(["detalle" => "Estas en la vista del cursos borrando el curso {$id}"]);
        return;
    }

    public function create(){

        if( isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW']) ){
            $data['PHP_AUTH_USER'] = $_SERVER['PHP_AUTH_USER'];
            $data['PHP_AUTH_PW'] = $_SERVER['PHP_AUTH_PW'];

            $clientes = new Clientes;
            $existe_llave = $clientes->buscar_llave($data);

            if($existe_llave){    
                $data['titulo']      = $_POST['titulo'];
                $data['descripcion'] = $_POST['descripcion'];
                $data['instructor']  = $_POST['instructor'];
                $data['imagen']      = $_POST['imagen'];
                $data['precio']      = $_POST['precio'];
                
                //validar que no exista otro
                $curso = new Cursos();

                if( !$curso->curso_repetido('titulo',$data['titulo']) ){
                    $create_curso = $curso->create_curso($data);

                    if($create_curso == "ok"){
                        echo json_encode([
                            "detalle"       => "",
                            "status"        => "Se creo el curso",
                            "curso"         => $data['titulo']
                        ]);
                    }
                }else{
                    echo json_encode([
                        "detalle"       => "",
                        "status"        => "este titulo ya se encuentra registrado, intente con otro nombre",
                        "curso"         => $data['titulo']
                    ]);
                }
                return;
            }else{
                echo json_encode(
                    [
                    "status" => 404,
                    "detalle" => 'error pass token not found' 
                    ]
                );
            }
        };   
        return;
    }
}


