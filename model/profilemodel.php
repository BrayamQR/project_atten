<?php
require "../config/cnx.php";
class Perfil
{
    private $cnx;
    public function __construct()
    {
        $this->cnx = connection();
    }
    public function Listar()
    {
        $sql = "SELECT * FROM tipousuario";
        $query = mysqli_query($this->cnx, $sql);
        mysqli_close($this->cnx);
        return $query;
    }
    public function CambiarEstado($id, $estado)
    {
        $sql = "UPDATE tipousuario SET Vigente=$estado WHERE Id_TipoUsuario = $id";
        $query = mysqli_query($this->cnx, $sql);
        mysqli_close($this->cnx);
        return $query;
    }
    public function InsertarPermisos($student, $classroom, $income, $activity, $user, $profile, $idtipo)
    {
        $sql = "INSERT INTO permiso( Act_Estudiante, Act_Aula, Act_Asistencia, Act_Actividad, Act_Usuarios, Act_Perfiles, Id_TipoUsuario) VALUES ($student,$classroom,$income,$activity,$user,$profile,$idtipo)";
        $query = mysqli_query($this->cnx, $sql);
        mysqli_close($this->cnx);
        return $query;
    }
    public function EditarPermisos($id, $student, $classroom, $income, $activity, $user, $profile)
    {
        $sql = "UPDATE permiso SET Act_Estudiante=$student,Act_Aula=$classroom,Act_Asistencia=$income,Act_Actividad=$activity,Act_Usuarios=$user,Act_Perfiles=$profile WHERE Id_Permiso = $id";
        $query = mysqli_query($this->cnx, $sql);
        mysqli_close($this->cnx);
        return $query;
    }
    public function MostrarPermisos($id)
    {
        $sql = "SELECT * FROM permiso WHERE Id_TipoUsuario = $id";
        $query = mysqli_query($this->cnx, $sql);
        mysqli_close($this->cnx);
        return $query;
    }
    public function InsertarPerfil($perfil)
    {
        $sql = "INSERT INTO tipousuario(Desc_TipoUsuario, Vigente) VALUES (upper('$perfil'),1)";
        $query = mysqli_query($this->cnx, $sql);
        mysqli_close($this->cnx);
        return $query;
    }
    public function ListarVigentes()
    {
        $sql = "SELECT * FROM tipousuario WHERE Vigente = 1";
        $query = mysqli_query($this->cnx, $sql);
        mysqli_close($this->cnx);
        return $query;
    }
    public function EliminarPerfil($id)
    {
        $sql = "DELETE FROM tipousuario WHERE Id_TipoUsuario = $id";
        $query = mysqli_query($this->cnx, $sql);
        mysqli_close($this->cnx);
        return $query;
    }
}
