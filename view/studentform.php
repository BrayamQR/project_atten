<?php
include("../config/session.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Información del estudiante | Sistema de registro</title>
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
                <?php if (isset($error)) echo $error; ?>
                <div class="data-info">
                    <h1>INFORMACIÓN DEL ESTUDIANTE</h1>

                    <div class="content-info">
                        <form id="formulario">
                            <div class="form-input">
                                <input type="hidden" name="id" value="" id="id">
                                <div class="formulario-grupo grupo-action" id="grupo-dni">
                                    <div class="grupo-input-action">
                                        <div class="input-content input-action">
                                            <i class="fa-solid fa-address-card"></i>
                                            <input class="input-form" type="text" id="dni" name="dni" value="" maxlength="8">
                                            <label class="input-label" for="">DNI</label>
                                            <i class="formulario-validacion-estado fa-solid fa-xmark"></i>
                                        </div>
                                        <div class="btn-action">
                                            <button type="button" id="buscarbydni" class="fa-solid fa-magnifying-glass label-search" title="Buscar..." onclick="SearchByDni()"></button>
                                        </div>
                                    </div>
                                    <p class="formulario-input-error ">El DNI solo debe contener numeros (8 caracteres)</p>
                                </div>
                                <div class="formulario-grupo" id="grupo-nombres">
                                    <div class="input-content">
                                        <i class="fa-solid fa-user-pen"></i>
                                        <input class="input-form" type="text" name="nombre" value="" id="nombre">
                                        <label class="input-label" for="">Nombres</label>
                                        <i class="formulario-validacion-estado fa-solid fa-xmark"></i>
                                    </div>
                                    <p class="formulario-input-error">El nombre solo debe contener letras y espacios.</p>
                                </div>
                                <div class="formulario-grupo" id="grupo-apellidos">
                                    <div class="input-content">
                                        <i class="fa-solid fa-user-pen"></i>
                                        <input class="input-form" type="text" name="apellido" value="" id="apellido">
                                        <label class="input-label" for="">Apellidos</label>
                                        <i class="formulario-validacion-estado fa-solid fa-xmark"></i>
                                    </div>
                                    <p class="formulario-input-error">El apellido solo debe contener letras y espacios.</p>
                                </div>
                                <div class="formulario-grupo  grupo-action" id="grupo-rol">
                                    <div class="grupo-input-action">
                                        <div class="input-content input-select select-action">
                                            <i class="fa-solid fa-landmark"></i>
                                            <select name="idaula" class="select-option input-form" id="idaula">
                                                <option disabled selected value=""></option>
                                                <option value="1">PRIMERO - UNICA</option>
                                            </select>
                                            <label class="input-label" for="">Grado y Sección</label>
                                            <i class="formulario-validacion-estado fa-solid fa-xmark"></i>
                                        </div>
                                        <div class="btn-action">
                                            <label for="btn-modal-mostrar" class="fa-solid fa-magnifying-glass label-search" title="Mostrar categorías de usuario"></label>

                                            <label for="btn-modal-add" class="fa-solid fa-plus label-add" title="Agregar nueva categoría"></label>
                                        </div>
                                    </div>
                                    <p class="formulario-input-error">Debe seleccionar una opcion.</p>
                                </div>
                                <div class="formulario-grupo-full formulario-image" id="grupo-foto">
                                    <div class="input-content">
                                        <input type="file" name="foto" id="foto" class="input-image">
                                        <input type="hidden" name="imagenactual" id="imagenactual" value="">
                                        <div class="content-photo">
                                            <button type="button" class="btn-image" onclick="document.getElementById('foto').click()"><i class="fa-solid fa-camera"></i> Subir una foto</button>
                                            <div class="content-image">
                                                <img src="../img/student.png" id="imagenmuestra">
                                            </div>
                                        </div>
                                        <div class="content-qr">
                                            <img src="" id="qrmuestra">
                                        </div>
                                        <input type="hidden" name="qr" id="qr" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="formulario-mensaje" id="formulario-mensaje">
                                <p><i class="fa-solid fa-triangle-exclamation"></i> <b>Error: </b>Todos los campos son obligatorios.</p>
                            </div>
                            <div class="form-action">
                                <input type="submit" value="Enviar" name="submit">
                                <a href="student.php">Volver</a>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </main>
    </div>
    <?php
    include("../config/global_script.php");
    ?>
    <script src="js/student.js"></script>
    <script>
        let id = "<?= isset($_GET['id']) ? $_GET['id'] : '' ?>";
        Mostrar(id);
    </script>
</body>

</html>