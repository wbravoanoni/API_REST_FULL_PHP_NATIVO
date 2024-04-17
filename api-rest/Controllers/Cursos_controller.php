<?php

namespace Controllers;

use Models\Cursos;
use Models\Clientes;

class Cursos_controller{
    
    public function index($pagina){
        //Trabajar autenticacion
        if( isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW']) ){
            $data['PHP_AUTH_USER'] = $_SERVER['PHP_AUTH_USER'];
            $data['PHP_AUTH_PW'] = $_SERVER['PHP_AUTH_PW'];

            $clientes = new Clientes;
            $existe_llave = $clientes->buscar_llave($data);

            if($existe_llave){      
                $curso  = new Cursos();

                if($pagina != null){
                    $data['pagina']   = $pagina;
                    $data['cantidad'] = 10;
                    $data['desde']    = ($pagina -1) * $data['cantidad'];
                    $cursos = $curso->index_limit($data);
                }else{
                   $cursos = $curso->index();
                }

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

        if( isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW']) ){

            $data['PHP_AUTH_USER'] = $_SERVER['PHP_AUTH_USER'];
            $data['PHP_AUTH_PW'] = $_SERVER['PHP_AUTH_PW'];

            $clientes = new Clientes;
            $existe_llave = $clientes->buscar_llave($data);

            if($existe_llave){       
                $cursos     = new Cursos;
                $data['id'] = $id;
                $curso      = $cursos->show($data);

                echo json_encode(
                                    [
                                    "status" => 200,
                                    "detalle" => $curso 
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

            return;

        }else{
            echo json_encode(
                [
                "status" => 404,
                "detalle" => 'error pass token not found' 
                ]
            );
        }


        echo json_encode(["detalle" => "Estas en la vista del cursos {$id}"]);
        return;
    }

    public function update($id){

        $data = array();

        parse_str(file_get_contents('php://input'),$data);

        # ****** limpiar datos *****

        foreach($data as $key => $valueDatos){

            if (isset($valueDatos) && !preg_match('/^[()\=\&\$\;\-\_\*\"\<\>\?\¿\!\¡\:\,\.\0-9a-zA-ZñÑáéíóúÁÉÍOU \'\\\]+$/u', $valueDatos)) {

                echo json_encode( [
                                    "status"  => 404,
                                    "detalle" => "Error en el campo {$key}"
                                    ] );
                return;                    
            }
            
        }

        if( isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW']) ){
            $data['PHP_AUTH_USER'] = $_SERVER['PHP_AUTH_USER'];
            $data['PHP_AUTH_PW'] = $_SERVER['PHP_AUTH_PW'];

            $clientes = new Clientes;
            $existe_llave = $clientes->buscar_llave($data);

            if($existe_llave){
                $data['id']          = $id;
                $data['titulo']      = htmlspecialchars(strip_tags($data['titulo']));
                $data['descripcion'] = htmlspecialchars($data['descripcion']);
                $data['instructor']  = htmlspecialchars($data['instructor']);
                $data['imagen']      = htmlspecialchars($data['imagen']);
                $data['precio']      = htmlspecialchars($data['precio']);
                $data['created_at']  = date('Y-m-d h:i:s');
                $data['updated_at']  = date('Y-m-d h:i:s');
                //validar que no exista otro, pero ignorar el id actual
                $curso = new Cursos();
                
                if( !$curso->curso_repetido_sin_mismo_id('titulo',$data['titulo'],$id) ) {
                    $update_curso = $curso->actualizar_curso($data);

                    if($update_curso == "ok"){
                        echo json_encode([
                            "detalle"       => "",
                            "status"        => "Se edito el curso",
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
            };
        return;
     }
     return;
    }

    public function delete($id){


        if( isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW']) ){
            $data['PHP_AUTH_USER'] = $_SERVER['PHP_AUTH_USER'];
            $data['PHP_AUTH_PW'] = $_SERVER['PHP_AUTH_PW'];

            $clientes = new Clientes;
            $existe_llave = $clientes->buscar_llave($data);

            if($existe_llave){
                $curso = new Cursos();
                $data['id'] = $id;
                $eliminar_curso = $curso->eliminar_curso($data);

                if($eliminar_curso == "ok"){
                    echo json_encode([
                        "detalle"       => "",
                        "status"        => "Se elimino el curso {$data['id']}",
                    ]);
                }

            }else{
                echo json_encode(
                    [
                    "status" => 404,
                    "detalle" => 'error pass token not found' 
                    ]
                );
            }
        }else{
            return;
        }
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
                $data['created_at']  = date('Y-m-d h:i:s');
                $data['updated_at']  = date('Y-m-d h:i:s');
                
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


