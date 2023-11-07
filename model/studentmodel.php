<?php
require "../config/cnx.php";
class Estudiante
{
    private $cnx;
    public function __construct()
    {
        $this->cnx = connection();
    }
    public function Listar()
    {
        $sql = "SELECT * FROM alumno INNER JOIN aula ON alumno.Id_Aula = aula.Id_Aula";
        $query = mysqli_query($this->cnx, $sql);
        mysqli_close($this->cnx);
        return $query;
    }
    public function Insertar($dni, $nombre, $apellido, $idaula, $imagenactual, $qr)
    {
        $sql = "INSERT INTO alumno(Dni_Alumno, Nom_Alumno, Id_Aula, Ape_Alumno, Foto_Alumno,Qr_Alumno) VALUES ('$dni','$nombre','$idaula','$apellido','$imagenactual','$qr')";
        $query = mysqli_query($this->cnx, $sql);
        mysqli_close($this->cnx);
        return $query;
    }
    public function Editar($id, $dni, $nombre, $apellido, $idaula, $imagenactual)
    {
        $sql = "UPDATE alumno SET Dni_Alumno='$dni',Nom_Alumno='$nombre',Id_Aula='$idaula',Ape_Alumno='$apellido', Foto_Alumno='$imagenactual' WHERE Id_Alumno = $id";
        $query = mysqli_query($this->cnx, $sql);
        mysqli_close($this->cnx);
        return $query;
    }
    public function Eliminar($id)
    {
        $sql = "DELETE FROM alumno WHERE Id_Alumno = $id";
        $query = mysqli_query($this->cnx, $sql);
        mysqli_close($this->cnx);
        return $query;
    }
    public function Mostrar($id)
    {
        $sql = "SELECT * FROM alumno INNER JOIN aula ON alumno.Id_Aula = aula.Id_Aula WHERE Id_Alumno  = $id";
        $query = mysqli_query($this->cnx, $sql);
        mysqli_close($this->cnx);
        return $query;
    }
    public function Buscar($dato)
    {
        $sql = "SELECT * FROM alumno INNER JOIN aula ON alumno.Id_Aula = aula.Id_Aula WHERE alumno.Dni_Alumno LIKE '$dato%' OR alumno.Nom_Alumno LIKE '$dato%'OR alumno.Ape_Alumno LIKE '$dato%' OR aula.Grado_Aula LIKE '$dato%' OR aula.Seccion_Aula LIKE '$dato%'";
        $query = mysqli_query($this->cnx, $sql);
        mysqli_close($this->cnx);
        return $query;
    }
    public function GenerarQR($dni, $qr)
    {
        $sql = "UPDATE alumno SET Qr_Alumno='$qr' WHERE Dni_Alumno= '$dni'";
        $query = mysqli_query($this->cnx, $sql);
        mysqli_close($this->cnx);
        return $query;
    }
    public function lastInsertId()
    {
        return mysqli_insert_id($this->cnx);
    }
}
