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
    <title>Información de la actividad | Colégio 17 Setiembre</title>
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
                                <div class="formulario-grupo-full grupo-radio" id="grupo-radio">
                                    <h3>Seleccione el tipo de actividad *</h3>
                                    <div class="input-content grupo-radio-input">
                                        <input type="radio" class="input-radio" name="tipoactividad" id="periodica" value="1">
                                        <label class="label-radio" for="periodica">Clases semanales</label>
                                        <input type="radio" class="input-radio" name="tipoactividad" id="programada" value="2">
                                        <label class="label-radio" for="programada">Actividad programada</label>
                                    </div>
                                    <p class="formulario-input-error">Elija una opción</p>
                                </div>

                                <div class="formulario-grupo" id="grupo-fecha">
                                    <div class="input-content input-datetime">
                                        <i class="fa-solid fa-calendar-days"></i>
                                        <input type="date" class="input-form-date" name="fechainicio" id="fechainicio">
                                        <label class="input-label input-label-date" for="">Fecha de inicio *</label>
                                        <i class="formulario-validacion-estado fa-solid fa-xmark"></i>
                                    </div>
                                    <p class="formulario-input-error">Seleccione una fecha</p>
                                </div>

                                <div class="formulario-grupo" id="grupo-dni">
                                    <div class="input-content input-datetime">
                                        <i class="fa-solid fa-calendar-days"></i>
                                        <input type="date" class="input-form-date" id="fechafin" name="fechafin" value="">
                                        <label class="input-label input-label-date" for="">Fecha de fin</label>
                                        <i class="formulario-validacion-estado fa-solid fa-xmark"></i>
                                    </div>
                                    <p class="formulario-input-error">Seleccione una fecha</p>
                                </div>
                                <div class="formulario-grupo" id="grupo-hora">
                                    <div class="input-content input-datetime">
                                        <i class="fa-solid fa-clock"></i>
                                        <input type="time" class="input-form-date" name="hora" value="" id="hora">
                                        <label class="input-label input-label-date" for="">Hora de ingreso *</label>
                                        <i class="formulario-validacion-estado fa-solid fa-xmark"></i>
                                    </div>
                                    <p class="formulario-input-error">Debe rellenar la Hora.</p>
                                </div>
                                <div class="formulario-grupo" id="grupo-nombres">
                                    <div class="input-content">
                                        <i class="fa-solid fa-comment"></i>
                                        <input type="text" class="input-form" name="motivo" value="" id="motivo">
                                        <label class="input-label" for="">Motivo *</label>
                                        <i class="formulario-validacion-estado fa-solid fa-xmark"></i>
                                    </div>
                                    <p class="formulario-input-error formulario-input-error-area">El nombre solo debe contener letras y espacios.</p>
                                </div>
                                <div class="formulario-grupo formulario-grupo-full" id="grupo-nombres">
                                    <div class="input-content">
                                        <i class="fa-solid fa-comment"></i>
                                        <textarea class="input-form" name="descripcion" id="descripcion"></textarea>
                                        <label class="input-label" for="">Descripción</label>
                                        <i class="formulario-validacion-estado fa-solid fa-xmark"></i>
                                    </div>
                                    <p class="formulario-input-error">El nombre solo debe contener letras y espacios.</p>
                                </div>
                            </div>
                            <div class="formulario-mensaje" id="formulario-mensaje">
                                <p><i class="fa-solid fa-triangle-exclamation"></i> <b>Error: </b>Todos los campos son obligatorios.</p>
                            </div>
                            <div class="form-action">
                                <input type="submit" value="Enviar" name="submit">
                                <a href="activity.php?rute=mactivity">Volver</a>
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
<script src="js/activity.js"></script>
<script>
    let id = "<?= isset($_GET['id']) ? $_GET['id'] : '' ?>";
    Mostrar(id);
</script>

</html>