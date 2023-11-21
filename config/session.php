<?php
session_start();
if (!$_SESSION['Id_Usuario']) {
    session_destroy();
    header("location: login.php");
}
$user_nombre = $_SESSION['Nom_Usuario'];
$user_rol = $_SESSION['Desc_TipoUsuario'];
$user_tipo = $_SESSION['Id_TipoUsuario'];
$act_estudiante = $_SESSION['Act_Estudiante'];
$act_asistencia = $_SESSION['Act_Asistencia'];
$act_actividad = $_SESSION['Act_Actividad'];
$act_usuarios = $_SESSION['Act_Usuarios'];
$act_perfiles = $_SESSION['Act_Perfiles'];
$act_aula = $_SESSION['Act_Aula'];
