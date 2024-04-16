<?php

require_once('config/database.php');
require_once('Models/Cursos.php');
require_once('Models/Clientes.php');

require_once('controllers/Rutas_controller.php');
require_once('controllers/Cursos_controller.php');
require_once('controllers/Clientes_controller.php');



use controllers\Rutas_controller;


$rutas = new Rutas_controller();

$rutas->index();




?>