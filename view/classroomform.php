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
    <title>Información del aula | Colégio 17 Setiembre</title>
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
                                <div class="formulario-grupo" id="grupo-grado">
                                    <div class="grupo-input-action">
                                        <div class="input-content input-select">
                                            <i class="fa-solid fa-user-graduate"></i>
                                            <select name="grado" class="select-option input-form" id="grado">
                                                <option value="" disabled selected></option>
                                                <option value="PRIMERO">PRIMERO</option>
                                                <option value="SEGUNDO">SEGUNDO</option>
                                                <option value="TERCERO">TERCERO</option>
                                                <option value="CUARTO">CUARTO</option>
                                                <option value="QUINTO">QUINTO</option>
                                                <option value="SEXTO">SEXTO</option>
                                            </select>
                                            <label class="input-label" for="">Grado *</label>
                                            <i class="formulario-validacion-estado fa-solid fa-xmark"></i>
                                        </div>
                                    </div>
                                    <p class="formulario-input-error">Debe seleccionar una opcion.</p>
                                </div>
                                <div class="formulario-grupo" id="grupo-seccion">
                                    <div class="grupo-input-action">
                                        <div class="input-content input-select">
                                            <i class="fa-solid fa-layer-group"></i>
                                            <select name="seccion" class="select-option input-form" id="seccion">
                                                <option value="" disabled selected></option>
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="C">C</option>
                                            </select>
                                            <label class="input-label" for="">Sección *</label>
                                            <i class="formulario-validacion-estado fa-solid fa-xmark"></i>
                                        </div>
                                    </div>
                                    <p class="formulario-input-error">Debe seleccionar una opcion.</p>
                                </div>
                                <div class="formulario-grupo" id="grupo-nivel">
                                    <div class="grupo-input-action">
                                        <div class="input-content input-select">
                                            <i class="fa-solid fa-book-open-reader"></i>
                                            <select name="nivel" class="select-option input-form" id="nivel">
                                                <option value="" disabled selected></option>
                                                <option value="PRIMARIA">PRIMARIA</option>
                                                <option value="SECUNDARIA">SECUNDARIA</option>
                                            </select>
                                            <label class="input-label" for="">Nivel académico *</label>
                                            <i class="formulario-validacion-estado fa-solid fa-xmark"></i>
                                        </div>
                                    </div>
                                    <p class="formulario-input-error">Debe seleccionar una opcion.</p>
                                </div>
                                <div class="formulario-grupo" id="grupo-tutor">
                                    <div class="input-content">
                                        <i class="fa-solid fa-person-chalkboard"></i>
                                        <input class="input-form" type="text" name="tutor" value="" id="tutor">
                                        <label class="input-label" for="">Docente a cargo *</label>
                                        <i class="formulario-validacion-estado fa-solid fa-xmark"></i>
                                    </div>
                                    <p class="formulario-input-error">El nombre del Tutor solo debe contener letras.</p>
                                </div>
                            </div>
                            <div class="formulario-mensaje" id="formulario-mensaje">
                                <p><i class="fa-solid fa-triangle-exclamation"></i> <b>Error: </b>Los campos con (*) son obligatorios.</p>
                            </div>
                            <div class="form-action">
                                <input type="submit" value="Enviar" name="submit">
                                <a href="classroom.php?rute=mclassroom">Volver</a>
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
<script src="js/classroom.js"></script>
<script>
    let id = "<?= isset($_GET['id']) ? $_GET['id'] : '' ?>";
    Mostrar(id);
</script>

</html>