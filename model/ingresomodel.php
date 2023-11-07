<?php
require "../config/cnx.php";
class Ingreso
{
    private $cnx;
    public function __construct()
    {
        $this->cnx = connection();
    }
    public function Listar()
    {
        $sql = "SELECT * FROM ingreso INNER JOIN alumno ON ingreso.Id_Alumno = alumno.Id_Alumno";
        $query = mysqli_query($this->cnx, $sql);
        mysqli_close($this->cnx);
        return $query;
    }
    public function Insertar($fechahora, $idalumno)
    {
        $sql = "INSERT INTO ingreso(Fecha_Hora, Id_Alumno) VALUES ('$fechahora','$idalumno')";
        $query = mysqli_query($this->cnx, $sql);
        mysqli_close($this->cnx);
        return $query;
    }
    public function Editar($id, $fechahora, $idalumno)
    {
        $sql = "UPDATE ingreso SET Fecha_Hora='$fechahora',Id_Alumno='$idalumno' WHERE Id_Ingreso = $id";
        $query = mysqli_query($this->cnx, $sql);
        mysqli_close($this->cnx);
        return $query;
    }
    public function Eliminar($id)
    {
        $sql = "DELETE FROM ingreso WHERE Id_Ingreso = $id";
        $query = mysqli_query($this->cnx, $sql);
        mysqli_close($this->cnx);
        return $query;
    }
    public function Mostrar($id)
    {
        $sql = "SELECT * FROM ingreso INNER JOIN alumno ON ingreso.Id_Alumno = alumno.Id_Alumno WHERE Id_Ingreso  = $id";
        $query = mysqli_query($this->cnx, $sql);
        mysqli_close($this->cnx);
        return $query;
    }
    public function Buscar($dato)
    {
        $sql = "SELECT * FROM ingreso INNER JOIN alumno ON ingreso.Id_Alumno = alumno.Id_Alumno WHERE alumno.Dni_Alumno LIKE '$dato%' OR alumno.Nom_Alumno LIKE '$dato%' OR alumno.Ape_Alumno LIKE '$dato%' OR ingreso.Fecha_Hora LIKE '$dato%'";
        $query = mysqli_query($this->cnx, $sql);
        mysqli_close($this->cnx);
        return $query;
    }
}
