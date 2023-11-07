<?php
session_start();
if (!$_SESSION['Id_Usuario']) {
    session_destroy();
    header("location: login.php");
}
$user_nombre = $_SESSION['Nom_Usuario'];
$user_rol = $_SESSION['Desc_TipoUsuario'];
