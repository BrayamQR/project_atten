<?php
require "../config/cnx.php";

class Actividad
{
    private $cnx;
    public function __construct()
    {
        $this->cnx = connection();
    }
    public function Listar()
    {
        $sql = "SELECT * FROM actividad";
        $query = mysqli_query($this->cnx, $sql);
        mysqli_close($this->cnx);
        return $query;
    }
    public function Insertar($tipoactividad, $fechainicio, $fechafin, $hora, $descripcion, $motivo)
    {
        $sql = "CALL Insert_Actividad($tipoactividad,'$fechainicio','$fechafin','$descripcion','$hora','$motivo');";
        $query = mysqli_query($this->cnx, $sql);
        mysqli_close($this->cnx);
        return $query;
    }
    public function Editar($id, $fechainicio, $descripcion, $hora, $motivo)
    {
        $sql = "UPDATE actividad SET Fecha_Actividad='$fechainicio',Dia_Actividad=DAYOFWEEK('$fechainicio'),Desc_Actividad='$descripcion',Hora_Ingreso='$hora',Mot_Actividad='$motivo' WHERE Id_Actividad = $id";
        $query = mysqli_query($this->cnx, $sql);
        mysqli_close($this->cnx);
        return $query;
    }
    public function Eliminar($id)
    {
        $sql = "DELETE FROM actividad WHERE Id_Actividad =$id";
        $query = mysqli_query($this->cnx, $sql);
        mysqli_close($this->cnx);
        return $query;
    }
    public function Mostrar($id)
    {
        $sql = "SELECT * FROM actividad WHERE Id_Actividad =$id";
        $query = mysqli_query($this->cnx, $sql);
        mysqli_close($this->cnx);
        return $query;
    }
    public function Buscar()
    {
        $sql = "";
        $query = mysqli_query($this->cnx, $sql);
        mysqli_close($this->cnx);
        return $query;
    }
}
