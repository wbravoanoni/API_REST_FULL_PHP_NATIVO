<?php

namespace Models;

class Clientes extends Conexion{

    protected $table = 'Clientes';

    public function index($campo,$valor){
        return $this->campo_repetido($campo,$valor,$this->table);
    }

    public function create_cliente($data){
        return $this->create($this->table,$data);
    }

    public function buscar_llave($data){
        return $this->autorizacion($this->table,$data);
    }

}