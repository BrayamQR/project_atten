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
    <link rel="shortcut icon" href="../img/logo.png">
    <title>Estudiantes | Colégio 17 Setiembre</title>
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
                        <div class="content-action">
                            <div class="content-search" id="form_search">
                                <div class="content-search-text">
                                    <button class="fa-solid fa-magnifying-glass btn-search" title="Buscar" onclick="Buscar()"></button>
                                    <input type="text" name="search_input" id="search_input">
                                    <label class="input-label" for="">Buscar por: Nombre | Doc. Identidad | Código</label>
                                </div>

                            </div>

                            <div class="content-btn">
                                <a href="studentform.php?rute=astudent" class="fa-solid fa-plus" title="Agregar"></a>
                            </div>
                        </div>
                        <table id="tblDatos">
                            <thead>
                                <th>#</th>
                                <th>Doc. Identidad</th>
                                <th>Código</th>
                                <th>Nombres y Apellidos</th>
                                <th>Fech. Nacimiento</th>
                                <th>Estado Matricula</th>
                                <th>Aula</th>
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
<script src="js/student.js"></script>

</html>