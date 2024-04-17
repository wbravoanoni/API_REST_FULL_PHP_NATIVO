<?php

namespace Models;
use PDO;

require_once('Conexion.php');

class Cursos extends Conexion{
    protected $table = 'cursos';

    public function index(){
        return $this->get_all($this->table);
    }

    public function index_limit($data){
        return $this->get_all_limit($this->table,$data);
    }

    public function create_curso($data){

        $stmt = Conexion::conectar()->prepare(" INSERT INTO {$this->table} (titulo, descripcion, instructor,imagen, precio, created_at, updated_at) 
                                                VALUES (:titulo, :descripcion, :instructor, :imagen, :precio, :created_at, :updated_at)");

        $stmt->bindParam(":titulo", $data['titulo'], PDO::PARAM_STR);
        $stmt->bindParam(":descripcion", $data['descripcion'], PDO::PARAM_STR);
        $stmt->bindParam(":instructor", $data['instructor'], PDO::PARAM_STR);
        $stmt->bindParam(":imagen", $data['imagen'], PDO::PARAM_STR);
        $stmt->bindParam(":precio", $data['precio'], PDO::PARAM_INT);
        $stmt->bindParam(":created_at", $data['created_at'], PDO::PARAM_STR);
        $stmt->bindParam(":updated_at", $data['updated_at'], PDO::PARAM_STR);

        if($stmt->execute()){
            return "ok";
        }else{
            print_r(Conexion::conectar()->errorInfo());
            exit;
        }
    }

    
    public function actualizar_curso($data){
        $stmt = Conexion::conectar()->prepare(" UPDATE {$this->table} 
                                                SET titulo=:titulo, descripcion=:descripcion,instructor=:instructor,
                                                imagen=:imagen,precio=:precio,created_at=:created_at,updated_at=:updated_at
                                                WHERE  id=:id");

        $stmt->bindParam(":id", $data['id'], PDO::PARAM_STR);
        $stmt->bindParam(":titulo", $data['titulo'], PDO::PARAM_STR);
        $stmt->bindParam(":descripcion", $data['descripcion'], PDO::PARAM_STR);
        $stmt->bindParam(":instructor", $data['instructor'], PDO::PARAM_STR);
        $stmt->bindParam(":imagen", $data['imagen'], PDO::PARAM_STR);
        $stmt->bindParam(":precio", $data['precio'], PDO::PARAM_INT);
        $stmt->bindParam(":created_at", $data['created_at'], PDO::PARAM_STR);
        $stmt->bindParam(":updated_at", $data['updated_at'], PDO::PARAM_STR);

        if($stmt->execute()){
            return "ok";
        }else{
            print_r(Conexion::conectar()->errorInfo());
            exit;
        }
    }

    public function eliminar_curso($data){

        $stmt = Conexion::conectar()->prepare(" DELETE FROM {$this->table} WHERE id=:id ");
        $stmt->bindParam(":id", $data['id'], PDO::PARAM_STR);
        if($stmt->execute()){
            return "ok";
        }else{
            print_r(Conexion::conectar()->errorInfo());
            exit;
        }
    }

    public function curso_repetido($campo,$valor){
        return $this->campo_repetido($campo,$valor,$this->table);
    }

    public function curso_repetido_sin_mismo_id($campo,$valor,$id){
        return $this->campo_repetido_no_id_actual($campo,$valor,$id,$this->table);
    }

    public function show($data){
        $stmt = Conexion::conectar()->prepare("SELECT * FROM {$this->table} WHERE id = {$data['id']}");
        $stmt->execute();
        $response = $stmt->fetchAll(PDO::FETCH_CLASS);
        return $response;
    }
}


