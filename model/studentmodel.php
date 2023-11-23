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
    public function Insertar($idtipodocumeto, $documento, $codigo, $nombre, $apaterno, $amaterno, $fechanacimiento, $idestado, $sexo, $idaula, $imagenactual, $qr)
    {
        $sql = "INSERT INTO alumno(Tipo_Documento, Doc_Alumno, Cod_Alumno, Apa_Alumno, Id_Aula, Foto_Alumno, Qr_Alumno, Ama_Alumno, Nom_Alumno, Sexo_Alumno, Fecha_Nacimiento, Est_Matricula) VALUES ($idtipodocumeto,UPPER('$documento'),'$codigo',UPPER('$apaterno'),$idaula,'$imagenactual','$qr',UPPER('$amaterno'),UPPER('$nombre'),UPPER('$sexo'),'$fechanacimiento',$idestado)";
        $query = mysqli_query($this->cnx, $sql);
        mysqli_close($this->cnx);
        return $query;
    }
    public function Editar($id, $idtipodocumeto, $documento, $codigo, $nombre, $apaterno, $amaterno, $fechanacimiento, $idestado, $sexo, $idaula, $imagenactual)
    {
        $sql = "UPDATE alumno SET Tipo_Documento=$idtipodocumeto,Doc_Alumno='$documento',Cod_Alumno='$codigo',Apa_Alumno=UPPER('$apaterno'),Id_Aula=$idaula,Foto_Alumno='$imagenactual',Ama_Alumno=UPPER('$amaterno'),Nom_Alumno=upper('$nombre'),Sexo_Alumno=upper('$sexo'),Fecha_Nacimiento='$fechanacimiento',Est_Matricula=$idestado WHERE Id_Alumno = $id";
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
        $sql = "SELECT * FROM alumno WHERE Id_Alumno = $id";
        $query = mysqli_query($this->cnx, $sql);
        mysqli_close($this->cnx);
        return $query;
    }
    public function Buscar($dato)
    {
        $sql = "SELECT * FROM alumno INNER JOIN aula ON alumno.Id_Aula = aula.Id_aula WHERE Doc_Alumno LIKE '$dato%' OR Cod_Alumno LIKE '$dato%' OR Apa_Alumno LIKE '$dato%' OR Ama_Alumno LIKE '$dato%' OR Nom_Alumno LIKE '$dato%'";
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
    public function GenerarQR($id, $qr)
    {
        $sql = "UPDATE alumno SET Qr_Alumno='$qr' WHERE Id_Alumno = $id";
        $query = mysqli_query($this->cnx, $sql);
        mysqli_close($this->cnx);
        return $query;
    }
}
