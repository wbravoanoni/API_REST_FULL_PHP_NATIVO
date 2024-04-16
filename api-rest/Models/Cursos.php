<?php

namespace Models;
use PDO;

require_once('Conexion.php');

class Cursos extends Conexion{
    protected $table = 'cursos';

    public function index(){
        return $this->get_all($this->table);
    }

    public function create_curso($data){

        $stmt = Conexion::conectar()->prepare(" INSERT INTO {$this->table} (titulo, descripcion, instructor,imagen, precio) 
                                                VALUES (:titulo, :descripcion, :instructor, :imagen, :precio)");

        $stmt->bindParam(":titulo", $data['titulo'], PDO::PARAM_STR);
        $stmt->bindParam(":descripcion", $data['descripcion'], PDO::PARAM_STR);
        $stmt->bindParam(":instructor", $data['instructor'], PDO::PARAM_STR);
        $stmt->bindParam(":imagen", $data['imagen'], PDO::PARAM_STR);
        $stmt->bindParam(":precio", $data['precio'], PDO::PARAM_INT);

       

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
}


