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
    <title>Información del usuario | Colégio 17 Setiembre</title>
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
                                <div class="formulario-grupo" id="grupo-codigo">
                                    <div class="input-content">
                                        <i class="fa-solid fa-address-card"></i>
                                        <input class="input-form" type="text" id="codigo" name="codigo" value="" maxlength="8">
                                        <label class="input-label" for="">Código o DNI *</label>
                                        <i class="formulario-validacion-estado fa-solid fa-xmark"></i>
                                    </div>
                                    <p class="formulario-input-error">El Código solo debe contener numeros (8 caracteres max.)</p>
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
                                <div class="formulario-grupo" id="grupo-apellido">
                                    <div class="input-content">
                                        <i class="fa-solid fa-user-pen"></i>
                                        <input class="input-form" type="text" name="apellido" value="" id="apellido">
                                        <label class="input-label" for="">Apellidos *</label>
                                        <i class="formulario-validacion-estado fa-solid fa-xmark"></i>
                                    </div>
                                    <p class="formulario-input-error">El apellido solo debe contener letras y espacios.</p>
                                </div>
                                <div class="formulario-grupo" id="grupo-telefono">
                                    <div class="input-content">
                                        <i class="fa-solid fa-phone"></i>
                                        <input class="input-form" type="text" name="telefono" value="" id="telefono" maxlength="9">
                                        <label class="input-label" for="">Teléfono *</label>
                                        <i class="formulario-validacion-estado fa-solid fa-xmark"></i>
                                    </div>
                                    <p class="formulario-input-error">El celular solo debe contener numeros de un 6 a 9 digitos.</p>
                                </div>
                                <div class="formulario-grupo" id="grupo-email">
                                    <div class="input-content">
                                        <i class="fa-solid fa-at"></i>
                                        <input class="input-form" type="email" name="email" value="" id="email">
                                        <label class="input-label" for="">Email *</label>
                                        <i class="formulario-validacion-estado fa-solid fa-xmark"></i>
                                    </div>
                                    <p class="formulario-input-error">El correo no aceptado (Formato: example@example.com).</p>
                                </div>
                                <div class="formulario-grupo" id="grupo-direccion">
                                    <div class="input-content">
                                        <i class="fa-solid fa-location-dot"></i>
                                        <input class="input-form" type="text" name="direccion" value="" id="direccion">
                                        <label class="input-label" for="">Dirección *</label>
                                        <i class="formulario-validacion-estado fa-solid fa-xmark"></i>
                                    </div>
                                    <p class="formulario-input-error">la direccion solo debe contener letras y espacios.</p>
                                </div>
                                <div class="formulario-grupo" id="grupo-user">
                                    <div class="input-content">
                                        <i class="fa-solid fa-user-shield"></i>
                                        <input class="input-form" type="text" name="user" value="" id="user">
                                        <label class="input-label" for="">Usuario *</label>
                                        <i class="formulario-validacion-estado fa-solid fa-xmark"></i>
                                    </div>
                                    <p class="formulario-input-error">El usuario solo puede contener numeros, letras y guion bajo (De 4 a 16 caracteres).</p>
                                </div>
                                <div class="formulario-grupo" id="grupo-password">
                                    <div class="input-content">
                                        <i class="fa-solid fa-key"></i>
                                        <input class="input-form" type="password" name="password" id="password" value="">
                                        <label class="input-label" for="">Contraseña *</label>
                                        <i class="formulario-validacion-estado fa-solid fa-xmark"></i>
                                    </div>
                                    <p class="formulario-input-error">La contraseña tiene que ser de 4 a 12 caracteres.</p>
                                </div>
                                <div class="formulario-grupo" id="grupo-confipass">
                                    <div class="input-content">
                                        <i class="fa-solid fa-key"></i>
                                        <input class="input-form" type="password" name="confipass" id="confipass" value="">
                                        <label class="input-label" for="">Confirmar contraseña *</label>
                                        <i class="formulario-validacion-estado fa-solid fa-xmark"></i>
                                    </div>
                                    <p class="formulario-input-error">Ambas contraseñas deben ser iguales.</p>
                                </div>
                                <div class="formulario-grupo grupo-action" id="grupo-idtipo">
                                    <div class="grupo-input-action">
                                        <div class="input-content input-select input-action">
                                            <i class="fa-solid fa-users"></i>
                                            <select name="idtipo" class="select-option input-form" id="idtipo">
                                            </select>
                                            <label class="input-label" for="">Tipo de usuario *</label>
                                            <i class="formulario-validacion-estado fa-solid fa-xmark"></i>
                                        </div>
                                        <div class="btn-action">
                                            <a href="profile.php?rute=mprofile" for="btn-modal-mostrar" class="fa-solid fa-magnifying-glass label-search" title="ver perfiles de usuario"></a>
                                        </div>
                                    </div>
                                    <p class="formulario-input-error">Debe seleccionar una opcion.</p>
                                </div>

                            </div>
                            <div class="formulario-mensaje" id="formulario-mensaje">
                                <p><i class="fa-solid fa-triangle-exclamation"></i> <b>Error: </b>Todos los campos son obligatorios.</p>
                            </div>
                            <div class="form-action">
                                <input type="submit" value="Enviar" name="submit">
                                <a href="user.php?rute=muser">Volver</a>
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
<script src="js/user.js"></script>
<script>
    let id = "<?= isset($_GET['id']) ? $_GET['id'] : '' ?>";
    Mostrar(id);
</script>

</html>