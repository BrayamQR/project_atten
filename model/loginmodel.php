<?php
require "../config/cnx.php";
class Login
{
    private $cnx;
    public function __construct()
    {
        $this->cnx = connection();
    }
    public function ValidarUsuario($user, $password)
    {
        $sql = "SELECT * FROM usuario INNER JOIN tipousuario ON usuario.Id_TipoUsuario = tipousuario.Id_TipoUsuario INNER JOIN permiso ON permiso.Id_TipoUsuario = tipousuario.Id_TipoUsuario WHERE User_Usuario = '$user' AND Pass_Usuario = '$password' AND Vigente = 1;";
        $query = mysqli_query($this->cnx, $sql);
        mysqli_close($this->cnx);
        return $query;
    }
}
