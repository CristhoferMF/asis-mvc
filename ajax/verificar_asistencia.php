<?php 
require_once '../app/model/Cn.php';
require_once '../app/model/Practicante.php';
$obj= new Practicante();
$obj->setDni($_POST['codigo']);
echo $obj->verificarAsistencia();