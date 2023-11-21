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
    <link rel="shortcut icon" href="../img/logo.png">
    <title>Información del estudiante | Colégio 17 Setiembre</title>
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

                    <div class="content-info">
                        <form id="formulario">
                            <div class="form-input">
                                <input type="hidden" name="id" value="" id="id">
                                <div class="formulario-grupo grupo-action" id="grupo-idtipodocumeto">
                                    <div class="grupo-input-action">
                                        <div class="input-content input-select">
                                            <i class="fa-regular fa-address-card"></i>
                                            <select name="idtipodocumeto" class="select-option input-form" id="idtipodocumeto">
                                                <option value="" disabled selected></option>
                                                <option value="1">DNI</option>
                                                <option value="2">PASAPORTE</option>
                                            </select>
                                            <label class="input-label" for="">Tipo de documento</label>
                                            <i class="formulario-validacion-estado fa-solid fa-xmark"></i>
                                        </div>
                                    </div>
                                    <p class="formulario-input-error">Debe seleccionar una opcion.</p>
                                </div>
                                <div class="formulario-grupo grupo-action" id="grupo-documento">
                                    <div class="grupo-input-action">
                                        <div class="input-content input-action">
                                            <i class="fa-solid fa-address-card"></i>
                                            <input class="input-form" type="text" id="documento" name="documento" value="" maxlength="11">
                                            <label class="input-label" for="">Doc. de Identidad</label>
                                            <i class="formulario-validacion-estado fa-solid fa-xmark"></i>
                                        </div>
                                        <div class="btn-action">
                                            <button type="button" id="buscarbydni" class="fa-solid fa-magnifying-glass label-search" title="Buscar..." onclick="SearchByDni()"></button>
                                        </div>
                                    </div>
                                    <p class="formulario-input-error">El Documento solo debe contener numeros (8 a 11 caracteres)</p>
                                </div>
                                <div class="formulario-grupo" id="grupo-codigo">
                                    <div class="input-content">
                                        <i class="fa-solid fa-user-shield"></i>
                                        <input class="input-form" type="text" name="codigo" value="" id="codigo" maxlength="14">
                                        <label class="input-label" for="">Código del Estudiante *</label>
                                        <i class="formulario-validacion-estado fa-solid fa-xmark"></i>
                                    </div>
                                    <p class="formulario-input-error">El código solo debe contener numeros (8 a 14 caracteres).</p>
                                </div>
                                <div class="formulario-grupo" id="grupo-nombre">
                                    <div class="input-content">
                                        <i class="fa-solid fa-user-pen"></i>
                                        <input class="input-form" type="text" name="nombre" value="" id="nombre">
                                        <label class="input-label" for="">Nombres *</label>
                                        <i class="formulario-validacion-estado fa-solid fa-xmark"></i>
                                    </div>
                                    <p class="formulario-input-error">El nombre solo debe contener letras y espacios.</p>
                                </div>
                                <div class="formulario-grupo" id="grupo-apaterno">
                                    <div class="input-content">
                                        <i class="fa-solid fa-user-pen"></i>
                                        <input class="input-form" type="text" name="apaterno" value="" id="apaterno">
                                        <label class="input-label" for="">Apellido Paterno *</label>
                                        <i class="formulario-validacion-estado fa-solid fa-xmark"></i>
                                    </div>
                                    <p class="formulario-input-error">El apellido solo debe contener letras</p>
                                </div>
                                <div class="formulario-grupo" id="grupo-amaterno">
                                    <div class="input-content">
                                        <i class="fa-solid fa-user-pen"></i>
                                        <input class="input-form" type="text" name="amaterno" value="" id="amaterno">
                                        <label class="input-label" for="">Apellido Materno *</label>
                                        <i class="formulario-validacion-estado fa-solid fa-xmark"></i>
                                    </div>
                                    <p class="formulario-input-error">El apellido solo debe contener letras</p>
                                </div>
                                <div class="formulario-grupo" id="grupo-fechanacimiento">
                                    <div class="input-content input-datetime">
                                        <i class="fa-solid fa-calendar-days"></i>
                                        <input type="date" class="input-form-date" name="fechanacimiento" id="fechanacimiento">
                                        <label class="input-label input-label-date" for="">Fecha de Nacimiento *</label>
                                        <i class="formulario-validacion-estado fa-solid fa-xmark"></i>
                                    </div>
                                    <p class="formulario-input-error">Debe ingresar una fecha</p>
                                </div>
                                <div class="formulario-grupo grupo-action" id="grupo-idestado">
                                    <div class="grupo-input-action">
                                        <div class="input-content input-select">
                                            <i class="fa-solid fa-user-graduate"></i>
                                            <select name="idestado" class="select-option input-form" id="idestado">
                                                <option value="" disabled selected></option>
                                                <option value="1">DEFINITIVA</option>
                                                <option value="2">TRASLADADO</option>
                                            </select>
                                            <label class="input-label" for="">Estado de Matricula *</label>
                                            <i class="formulario-validacion-estado fa-solid fa-xmark"></i>
                                        </div>
                                    </div>
                                    <p class="formulario-input-error">Debe seleccionar una opcion.</p>
                                </div>
                                <div class="formulario-grupo grupo-action" id="grupo-sexo">
                                    <div class="grupo-input-action">
                                        <div class="input-content input-select">
                                            <i class="fa-solid fa-restroom"></i>
                                            <select name="sexo" class="select-option input-form" id="sexo">
                                                <option value="" disabled selected></option>
                                                <option value="M">MASCULINO</option>
                                                <option value="F">FEMENINO</option>
                                            </select>
                                            <label class="input-label" for="">Sexo *</label>
                                            <i class="formulario-validacion-estado fa-solid fa-xmark"></i>
                                        </div>
                                    </div>
                                    <p class="formulario-input-error">Debe seleccionar una opcion.</p>
                                </div>
                                <div class="formulario-grupo grupo-action" id="grupo-idaula">
                                    <div class="grupo-input-action">
                                        <div class="input-content input-select input-action">
                                            <i class="fa-solid fa-school"></i>
                                            <select name="idaula" class="select-option input-form" id="idaula">
                                            </select>
                                            <label class="input-label" for="">Grado y Sección</label>
                                            <i class="formulario-validacion-estado fa-solid fa-xmark"></i>
                                        </div>
                                        <div class="btn-action">
                                            <a href="classroom.php?rute=mclassroom" for="btn-modal-mostrar" class="fa-solid fa-magnifying-glass label-search" title="Ver aulas"></a>
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
                                <a href="student.php?rute=mstudent">Volver</a>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </main>
    </div>
</body>
<?php
include("../config/global_script.php");
?>
<script src="js/student.js"></script>
<script>
    let id = "<?= isset($_GET['id']) ? $_GET['id'] : '' ?>";
    Mostrar(id);
</script>

</html>