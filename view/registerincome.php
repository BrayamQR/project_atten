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
    <title>Registrar Asistencia | Colégio 17 Setiembre</title>

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
                            <div class="content-search" id="form-search-autocomplete">
                                <div class="content-search-text">
                                    <button class="fa-solid fa-magnifying-glass btn-search" title="Buscar" onclick="autocomplete()"></button>
                                    <input type="text" name="search_input" id="search_input" class="input-form">
                                    <label class="input-label" for="">Buscar por: DNI | Nombres | Apellidos</label>
                                    <div class="content-autocomplete">
                                        <ul id="lst-student">
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="content-scan" id="scan-qr-content">
                            <div class="content-qr-scan">
                                <h3>Pase tarjeta</h3>
                                <div class="content-img-scan">
                                    <a id="btn-scan-qr" href="#">
                                        <img src="../img/imgqr.png" class="img-scan">
                                    </a>
                                    <div class="content-canvas">
                                        <canvas hidden="" id="qr-canvas"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="content-info-scan" id="info-student-scan">
                                <h3>Información del alumno</h3>
                                <div class="info-scan">
                                    <div class="photo-student">
                                        <img src="../img/student.png" id="imagenmuestra">
                                    </div>
                                    <div class="content-student">
                                        <div class="info-student">
                                            <p><span>IDENTIFICADOR: </span> <span class="info-stu" id="identificador"></span></p>
                                            <p><span>NOMBRES: </span><span class="info-stu" id="nombre"></span></p>
                                            <p><span>APELLIDOS: </span> <span class="info-stu" id="apellido"></span></p>
                                            <div class="info-flex">
                                                <p><span>GRADO: </span><span class="info-stu" id="grado"></span></p>
                                                <p><span>SECCIÓN: </span><span class="info-stu" id="seccion"></span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="state-atten">
                                    <p class="state-check" id="msg-config-income"><i class="fa-solid fa-circle-check"></i><span>Asistencia registrada</span></p>
                                    <p class="state-warning" id="msg-exist-income"><i class="fa-solid fa-triangle-exclamation"></i><span>El alumno ya registró su asistencia</span></p>
                                </div>
                                <!--
                                <div class="action-state">
                                    <button class="btn-check"> Marcar asistencia</button>
                                    <button class="btn-justify"> Marcar justificación</button>
                                </div>
-->
                            </div>
                        </div>
                        <div class="action-btn">
                            <a href="income.php?rute=mincome">Volver</a>
                        </div>
                    </div>
                </div>
                <div id="paginador"></div>
            </div>
        </main>
    </div>

</body>
<script src="../js/qrcode.min.js"></script>
<?php
include("../config/global_script.php");
?>

<script src="js/income.js"></script>

<audio id="audioscaner" src="../src/sonido.mp3"></audio>

</html>