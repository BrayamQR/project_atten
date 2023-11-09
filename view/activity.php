<?php
include('../config/session.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Estudiantes | Sistema de Gestion</title>
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
                    <h1>ACTIVIDADES</h1>
                    <div class="content-info">
                        <div class="content-action">
                            <div class="content-search">
                                <form id="form_search">
                                    <button class="fa-solid fa-magnifying-glass btn-search" type="submit" title="Buscar"></button>
                                    <input type="text" placeholder="Buscar por:   Nombres | Apellidos | DNI | Grado | Sección" name="search_input" id="search_input">
                                </form>
                            </div>

                            <div class="content-btn">
                                <a href="activityform.php" class="fa-solid fa-plus" title="Agregar"></a>
                            </div>
                        </div>
                        <table id="tblDatos">
                            <thead>
                                <th>#</th>
                                <th>Fecha</th>
                                <th>Hora de ingreso</th>
                                <th>Motivo</th>
                                <th>Descripción</th>
                                <th>Acciones</th>
                            </thead>
                            <tbody id="tblbodylista">

                            </tbody>
                        </table>
                    </div>
                </div>
                <div id="paginador"></div>
            </div>
        </main>
    </div>


</body>
<?php
include("../config/global_script.php");
if (isset($_GET['exito']) && $_GET['exito'] === '1' && isset($_GET['msg'])) {
    $mensaje = urldecode($_GET['msg']);
    echo '<script>
                    Swal.fire(
                        "¡Felicidades!",
                        "' . $mensaje . '",
                        "success"
                    ).then(function() {
                        if (history.replaceState) {
                            history.replaceState({}, document.title, window.location.pathname);
                        }
                    });
            </script>';
}
?>
<script src="js/activity.js"></script>

</html>