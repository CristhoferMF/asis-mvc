<?php
class Practicante
{
    private $dni;
    private $apePaterno;
    private $apeMaterno;
    private $nombre;
    private $fecNacimiento;
    private $sexo;
    private $codTurno_fk;
    private $descripcion;

    public function Practicante(){
        
    }
    public function verPracticantes(){
        $cn=new Cn();
        $mysqli=$cn->cn;
        $stm=$mysqli->prepare("call listaAlumnos()");
        /* QUERY */
        $stm->execute();
        $rs=$stm->get_result();
        while ($myrow = $rs->fetch_assoc()) {
            $array[]=$myrow;
        }
        return $array;
    }
    public function marcarAsistencia($accion){
        $cn=new Cn();
        $mysqli=$cn->cn;
        $stm=$mysqli->prepare("call marcarAsistencia(?,?)");
        $stm->bind_param("ss",$this->dni,$accion);
        $stm->execute();
        $rs=$stm->get_result();
        if(isset($stm->error)){
            echo $stm->error;
        }
        return true;
    }
    public function HorarioDia(){
        $cn=new Cn();
        $mysqli=$cn->cn;
        $stm=$mysqli->prepare("call horario_dia()");
        $stm->execute();
        $rs=$stm->get_result();
        $array=[];
        while ($myrow = $rs->fetch_assoc()) {
            $array[]=$myrow;
        }
        $json=json_encode($array,JSON_FORCE_OBJECT);
        return $json;
    }
    public function verificarAsistencia(){
        $cn=new Cn();
        $mysqli=$cn->cn;
        $stm=$mysqli->prepare("call verificar_asistencia($this->dni);");
        $stm->execute();
        $rs=$stm->get_result();
        $myrow = $rs->fetch_assoc();
        $array=[
            "entrada"=>"",
            "salida"=>"",
            "fecha" =>""
        ];
        if($rs->num_rows>0){
            if($myrow['conIngreso']==1){
                $array['entrada']="<button class='btn btn-default active col disabled' data-action='disable'>Ya Registró entrada</button>";
            }elseif($myrow['conIngreso']==0){
                $array['entrada']="<button class='btn btn-default active col ' data-action='enable'>Registrar Entrada</button>";
            }
            if($myrow['conSalida']==1){
                $array['salida']="<button class='btn btn-default active col disabled' data-action='disable'>Ya Registró salida</button>";
            }elseif($myrow['conSalida']==0){
                $array['salida']="<button class='btn btn-default active col ' data-action='enable'>Registrar salida</button>";
            }
            if(isset($myrow['fecha'])){
                $array["fecha"]=$myrow['fecha'];
            }
        }
            #print_r($rs->num_rows);
            $json=json_encode($array,JSON_FORCE_OBJECT);
            return $json;
    }

    /**
     * Get the value of dni
     */ 
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * Set the value of dni
     *
     * @return  self
     */ 
    public function setDni($dni)
    {
        $this->dni = $dni;

        return $this;
    }
}
