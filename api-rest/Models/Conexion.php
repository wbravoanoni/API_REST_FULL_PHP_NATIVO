<?php

namespace Models;

use PDO;

class Conexion{
    static public function conectar(){
        $link = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME."",DB_USER,DB_PASS);
        $link->exec("set names utf8");
        return $link;
    }

    public function get_all($tabla){
        $stmt = Conexion::conectar()->prepare("SELECT * FROM {$tabla}");
        $stmt->execute();
        $response = $stmt->fetchAll(PDO::FETCH_CLASS);
        return $response;
    }

    public function campo_repetido($campo,$valor,$tabla){
        $stmt = Conexion::conectar()->prepare("SELECT 1 FROM {$tabla} where {$campo} = '{$valor}' ");
        $stmt->execute();
        
        return $stmt->rowCount() > 0 ? true: false;
    }

    public function autorizacion($tabla,$data){

        $key = "{$data['PHP_AUTH_USER']}:{$data['PHP_AUTH_PW']}";

        $stmt = Conexion::conectar()->prepare("SELECT 1 FROM {$tabla} where CONCAT_WS(':',id_cliente,llave_secreta) = '{$key}' ");
        $stmt->execute();
        
        return $stmt->rowCount() > 0 ? true: false;
    }

    public function create($table,$data){

        $stmt = Conexion::conectar()->prepare("INSERT INTO {$table} (primer_nombre, primer_apellido, email, id_cliente, llave_secreta, created_at, updated_at) 
                                            VALUES (:nombre, :apellido, :email, :id_cliente, :llave_secreta, :created_at, :updated_at)");

        $stmt->bindParam(":nombre", $data['primer_nombre'], PDO::PARAM_STR);
        $stmt->bindParam(":apellido", $data['primer_apellido'], PDO::PARAM_STR);
        $stmt->bindParam(":email", $data['email'], PDO::PARAM_STR);
        $stmt->bindParam(":id_cliente", $data['id_cliente'], PDO::PARAM_STR);
        $stmt->bindParam(":llave_secreta", $data['llave_secreta'], PDO::PARAM_STR);
        $stmt->bindParam(":created_at", $data['created_at'], PDO::PARAM_STR);
        $stmt->bindParam(":updated_at", $data['updated_at'], PDO::PARAM_STR);

        if($stmt->execute()){
            return "ok";
        }else{
            print_r(Conexion::conectar()->errorInfo());
        }
    }
}