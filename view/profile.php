<?php
include('../config/session.php')
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="shortcut icon" href="../img/logo.png">
    <title>Perfiles | Colégio 17 Setiembre</title>
</head>

<body>
    <div class="container">
        <?php
        include("../include/sidebar.php");
        ?>
        <main>
            <div class="main-content">
                <?php
                include("../include/welcome.php")
                ?>
                <div class="data-info">
                    <div class="content-info">
                        <div class="content-flex">
                            <div class="content-table">
                                <div class="formulario-perfil">
                                    <div class="form-input">
                                        <div class="formulario-grupo">
                                            <div class="input-content">
                                                <i class="fa-regular fa-id-badge"></i>
                                                <input type="text" class="input-form" name="perfil" id="perfil">
                                                <label class="input-label" for="">Perfil</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-action">
                                        <button type="button" onclick="InsertarPerfil()" class="fa-solid fa-plus" title="Agregar"></button>
                                    </div>
                                </div>
                                <table id="tblDatos">
                                    <thead>
                                        <th>#</th>
                                        <th>Perfil</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </thead>
                                    <tbody id="tblbodylista">

                                    </tbody>
                                </table>
                            </div>
                            <div class="content-lst-access" id="content-lst-access">
                                <h4>Asignar permisos</h4>
                                <form id="formulario">
                                    <div class="form-input">
                                        <input type="hidden" name="id" id="id">
                                        <input type="hidden" name="idtipo" id="idtipo">
                                        <ul>
                                            <li class="content-profile-padre">
                                                <input type="checkbox" name="student" id="student">
                                                <label for="student">Estudiante</label>
                                                <label for="student" class="profile-switch"></label>
                                            </li>
                                            <li class="content-profile-padre">
                                                <input type="checkbox" name="classroom" id="classroom">
                                                <label for="classroom">Aula</label>
                                                <label for="classroom" class="profile-switch"></label>
                                            </li>
                                            <li class="content-profile-padre">
                                                <input class="checkbox-padre" type="checkbox" name="income" id="income">
                                                <label for="income">Asistencia</label>
                                                <label for="income" class="profile-switch"></label>
                                            </li>
                                            <ul>
                                            </ul>
                                            <li class="content-profile-padre">
                                                <input class="checkbox-padre" type="checkbox" name="activity" id="activity">
                                                <label for="activity">Actividades</label>
                                                <label for="activity" class="profile-switch"></label>
                                            </li>
                                            <li class="content-profile-padre">
                                                <input class="checkbox-padre" type="checkbox" name="user" id="user">
                                                <label for="user">Usuarios</label>
                                                <label for="user" class="profile-switch"></label>
                                            </li>
                                            <li class="content-profile-padre">
                                                <input class="checkbox-padre" type="checkbox" name="profile" id="profile">
                                                <label for="profile">Perfiles</label>
                                                <label for="profile" class="profile-switch"></label>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="form-action">
                                        <a class="btn-enviar" onclick="HabilitarCampos()" id="btn-editar">Editar</a>
                                        <input type="submit" value="Grabar" name="submit" id="submit">
                                        <a class="btn-cerrar" onclick="OcultarFormulario()" id="btn-cerrar">Cerrar</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
<?php
include("../config/global_script.php");
?>
<script src="js/profile.js"></script>

</html>