<?php

namespace Controllers;

use Models\CLientes;

class Clientes_controller{

    public function index(){
        echo json_encode(["detalle" => "vista de clientes"]);
        return;
    }

    public function create(){

        $data = array("primer_nombre" => $_POST['primer_nombre'], "primer_apellido" => $_POST['primer_apellido'], "email" => $_POST['email']);

        $repetido = new Clientes;

        if( isset ($data['primer_nombre']) && !preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/' , $data["primer_nombre"]) ){
            echo json_encode(   [
                                'detalle' => 'Error en el campo nombre, solo se permiten letas',
                                'status' => 404    
                                ]
                            );
            return;
        }else if( isset ($data['primer_apellido']) && !preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/' , $data["primer_apellido"]) ){
            echo json_encode(   [
                                'detalle' => 'Error en el campo apellido, solo se permiten letas',
                                'status'  => 404 
                                ]
                            );
            return;
        }else if( isset ($data['email']) && !preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/', $data["email"]) ){
            echo json_encode(   [
                                'detalle' => 'Error en el campo email, no tiene formato de correo',
                                'status'  => 404
                                ]
                            );
            return;
        }elseif( $repetido->index('email', $data["email"]) ){
            echo json_encode(   [
                'detalle' => 'Error en el campo email, el email ya se encuentra registrado',
                'status'  => 404
                ]
            );
        }else{
            //Generar credenciales del cliente

            $data['id_cliente']    = str_replace('$','c',crypt( $data['primer_nombre'] . $data['primer_apellido'] . $data['email'], '$2a$07$afartwetsdAD52356FEDGsfhsd$') );
            $data['llave_secreta'] = str_replace('$','c', crypt( $data['email'] . $data['primer_apellido'] . $data['primer_nombre'], '$2a$07$afartwetsdAD52356FEDGsfhsd$') );
            $data['created_at']    = date("Y-m-d H:i:s");
            $data['updated_at']    = date("Y-m-d H:i:s");

            $insertar = new Clientes;
            $create = $insertar->create_cliente($data);

            if($create == "ok"){
                echo json_encode([
                    "detalle"       => "",
                    "status"        => "Se genero sus credenciales",
                    "id_cliente"    => $data['id_cliente'],
                    "llave_secreta" => $data['llave_secreta']
                ]);
            }
        }
    }
}