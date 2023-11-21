<?php
require "../config/cnx.php";
class Aula
{
    private $cnx;
    public function __construct()
    {
        $this->cnx = connection();
    }
    public function Listar()
    {
        $sql = "SELECT * FROM aula";
        $query = mysqli_query($this->cnx, $sql);
        mysqli_close($this->cnx);
        return $query;
    }
    public function Insertar($grado, $seccion, $tutor, $nivel)
    {
        $sql = "INSERT INTO aula(Grado_Aula, Seccion_Aula, Tutor_Aula, Nivel_Aula) VALUES (UPPER('$grado'),UPPER('$seccion'),UPPER('$tutor'),UPPER('$nivel'))";
        $query = mysqli_query($this->cnx, $sql);
        mysqli_close($this->cnx);
        return $query;
    }
    public function Editar($id, $grado, $seccion, $tutor, $nivel)
    {
        $sql = "UPDATE aula SET Grado_Aula=UPPER('$grado'),Seccion_Aula=UPPER('$seccion'),Tutor_Aula=UPPER('$tutor'),Nivel_Aula=UPPER('$nivel') WHERE Id_Aula = $id";
        $query = mysqli_query($this->cnx, $sql);
        mysqli_close($this->cnx);
        return $query;
    }
    public function Eliminar($id)
    {
        $sql = "DELETE FROM aula WHERE Id_Aula = $id";
        $query = mysqli_query($this->cnx, $sql);
        mysqli_close($this->cnx);
        return $query;
    }
    public function Mostrar($id)
    {
        $sql = "SELECT * FROM aula WHERE Id_Aula = $id";
        $query = mysqli_query($this->cnx, $sql);
        mysqli_close($this->cnx);
        return $query;
    }
    public function Buscar($dato)
    {
        $sql = "SELECT * FROM aula WHERE Grado_Aula LIKE '$dato%' OR Seccion_Aula LIKE '$dato%' OR Tutor_Aula LIKE '$dato%' OR Nivel_Aula LIKE '$dato%'";
        $query = mysqli_query($this->cnx, $sql);
        mysqli_close($this->cnx);
        return $query;
    }
}
