<?php 
require_once 'app/model/Cn.php';
require_once 'app/model/Practicante.php';
$obj= new Practicante();
$totPracticantes=$obj->verPracticantes();
require_once 'app/view/home.php';