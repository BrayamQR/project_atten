<?php
require "../config/cnx.php";
class TipoUsuario
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
    public function Insertar($descripcion)
    {
        $sql = "INSERT INTO tipousuario(Desc_TipoUsuario) VALUES ('$descripcion')";
        $query = mysqli_query($this->cnx, $sql);
        mysqli_close($this->cnx);
        return $query;
    }
    public function Editar($id, $descripcion)
    {
        $sql = "UPDATE tipousuario SET Desc_TipoUsuario='$descripcion' WHERE Id_TipoUsuario =$id";
        $query = mysqli_query($this->cnx, $sql);
        mysqli_close($this->cnx);
        return $query;
    }
    public function Eliminar($id)
    {
        $sql = "DELETE FROM tipousuario WHERE Id_TipoUsuario = $id";
        $query = mysqli_query($this->cnx, $sql);
        mysqli_close($this->cnx);
        return $query;
    }
    public function Mostrar($id)
    {
        $sql = "SELECT * FROM tipousuario WHERE Id_TipoUsuario = $id";
        $query = mysqli_query($this->cnx, $sql);
        mysqli_close($this->cnx);
        return $query;
    }
    public function Buscar($dato)
    {
        $sql = "SELECT * FROM tipousuario WHERE Desc_TipoUsuario LIKE '$dato%'";
        $query = mysqli_query($this->cnx, $sql);
        mysqli_close($this->cnx);
        return $query;
    }
}
