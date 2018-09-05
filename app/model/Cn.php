<?php

Class Cn{
    public $cn;
    private $host;
    private $password;
    private $user;
    private $db;

    public function Cn() {
        $this->host="localhost";
        $this->db="asistencia_2018_2";
        $this->user="root";
        $this->password="";
        $this->cn=new mysqli($this->host,$this->user,$this->password,$this->db);
        //var_dump($this->cn);
        $this->cn->set_charset("utf8");
        if($this->cn->{'connect_errno'}>0){
            return NULL;
        }else{
            return $this->cn;
        }
    }
}

?>
