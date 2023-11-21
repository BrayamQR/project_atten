<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="shortcut icon" href="../img/logo.png">
    <title>Iniciar Sesión | Colégio 17 Setiembre</title>
</head>

<body>
    <div class="container-login">
        <form id="formulario">
            <h2>INICIAR SESIÓN</h2>
            <img src="../img/logo.png" alt="">
            <div class="content-login-input">
                <i class="fa-solid fa-user-shield"></i>
                <input class="input-form" type="text" name="user" id="user">
                <label class="input-label" for="">Usuario</label>
            </div>
            <div class="content-login-input">
                <i class="fa-solid fa-key"></i>
                <input class="input-form" type="password" name="password" id="password">
                <label class="input-label" for="">Contraseña</label>
            </div>
            <div class="content-login-action">
                <input type="submit" value="Ingresar" name="submit">
            </div>
        </form>
    </div>
</body>
<?php
include("../config/global_script.php");
?>
<script src="js/login.js"></script>

</html>