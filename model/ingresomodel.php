<?php
require "../config/cnx.php";
class Ingreso
{
    private $cnx;
    public function __construct()
    {
        $this->cnx = connection();
    }
    public function ListarIngreso()
    {
        $sql = "SELECT * FROM alumno INNER JOIN ingreso ON alumno.Id_Alumno = ingreso.Id_Alumno INNER JOIN aula ON alumno.Id_Aula = aula.Id_Aula";
        $query = mysqli_query($this->cnx, $sql);
        mysqli_close($this->cnx);
        return $query;
    }
    public function ElegirAlumno($doc)
    {
        $sql = "SELECT * FROM alumno INNER JOIN aula ON alumno.Id_Aula = aula.Id_Aula WHERE Doc_Alumno = '$doc' OR Cod_Alumno = '$doc'";
        $query = mysqli_query($this->cnx, $sql);
        mysqli_close($this->cnx);
        return $query;
    }
    public function ValidarIngreso($id)
    {
        $sql = "SELECT * FROM alumno INNER JOIN ingreso ON alumno.Id_Alumno = ingreso.Id_Alumno WHERE alumno.Id_Alumno = $id AND ingreso.Fecha_Ingreso = CURDATE()";
        $query = mysqli_query($this->cnx, $sql);
        mysqli_close($this->cnx);
        return $query;
    }
    public function RegistrarIngreso($id)
    {
        $sql = "CALL Insert_Ingreso($id,CURDATE(),CURTIME());";
        $query = mysqli_query($this->cnx, $sql);
        mysqli_close($this->cnx);
        return $query;
    }
    public function BuscarAlumno($dato)
    {
        $sql = "SELECT * FROM alumno WHERE Doc_Alumno LIKE '$dato%' OR Cod_Alumno LIKE '$dato%' OR Nom_Alumno LIKE '$dato%' OR Apa_Alumno LIKE '$dato%' OR Ama_Alumno LIKE '$dato%' LIMIT 0,5";
        $query = mysqli_query($this->cnx, $sql);
        mysqli_close($this->cnx);
        return $query;
    }
    public function Buscar($datotexto, $datofecha)
    {
        if ($datofecha == null || $datofecha == "") {
            $sql = "CALL Search_Ingreso('$datotexto',NULL)";
        } else {
            $sql = "CALL Search_Ingreso('$datotexto','$datofecha')";
        }
        $query = mysqli_query($this->cnx, $sql);
        mysqli_close($this->cnx);
        return $query;
    }
    public function ListarAulaVigente()
    {
        $sql = "SELECT * FROM aula";
        $query = mysqli_query($this->cnx, $sql);
        mysqli_close($this->cnx);
        return $query;
    }
}
