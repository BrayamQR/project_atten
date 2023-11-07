<?php
require "../config/cnx.php";

class Usuario
{
    private $cnx;
    public function __construct()
    {
        $this->cnx = connection();
    }
    public function Listar()
    {
        $sql = "SELECT * FROM usuario INNER JOIN tipousuario ON usuario.Id_TipoUsuario = tipousuario.Id_TipoUsuario";
        $query = mysqli_query($this->cnx, $sql);
        mysqli_close($this->cnx);
        return $query;
    }
    public function Insertar($codigo, $nombre, $apellido, $telefono, $email, $direccion, $user, $password, $idtipo)
    {
        $sql = "INSERT INTO usuario(Cod_Usuario, Nom_Usuario, Ape_Usuario, Tel_Usuario, Email_Usuario, Dir_Usuario, Id_TipoUsuario, User_Usuario, Pass_Usuario) VALUES ('$codigo', '$nombre', '$apellido', '$telefono', '$email', '$direccion', $idtipo, '$user', '$password')";
        $query =  mysqli_query($this->cnx, $sql);
        mysqli_close($this->cnx);
        return $query;
    }
    public function Editar($id, $codigo, $nombre, $apellido, $telefono, $email, $direccion, $user, $password, $idtipo)
    {
        $sql = "UPDATE usuario SET Cod_Usuario='$codigo',Nom_Usuario='$nombre',Ape_Usuario='$apellido',Tel_Usuario='$telefono',Email_Usuario='$email',Dir_Usuario='$direccion',Id_TipoUsuario=$idtipo,User_Usuario='$user',Pass_Usuario='$password' WHERE Id_Usuario = $id";
        $query =  mysqli_query($this->cnx, $sql);
        mysqli_close($this->cnx);
        return $query;
    }
    public function Eliminar($id)
    {
        $sql = "DELETE FROM usuario WHERE Id_Usuario = $id";
        $query = mysqli_query($this->cnx, $sql);
        mysqli_close($this->cnx);
        return $query;
    }
    public function Mostrar($id)
    {
        $sql = "SELECT * FROM usuario INNER JOIN tipousuario ON usuario.Id_TipoUsuario = tipousuario.Id_TipoUsuario WHERE Id_Usuario = $id";
        $query = mysqli_query($this->cnx, $sql);
        mysqli_close($this->cnx);
        return $query;
    }
    public function Buscar($dato)
    {
        $sql = "SELECT * FROM usuario INNER JOIN tipousuario ON usuario.Id_TipoUsuario = tipousuario.Id_TipoUsuario WHERE usuario.Nom_Usuario LIKE '$dato%' OR usuario.Ape_Usuario LIKE '$dato%' OR usuario.Cod_Usuario LIKE '$dato%' OR tipousuario.Desc_TipoUsuario LIKE '$dato%'";
        $query = mysqli_query($this->cnx, $sql);
        mysqli_close($this->cnx);
        return $query;
    }
}
