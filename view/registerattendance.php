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
    <title>Registrar Asistencia | Sistema de Gestion</title>

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
                    <h1>REGISTRAR ASISTENCIA</h1>
                    <div class="content-info">
                        <div class="content-action">
                            <div class="content-search">
                                <form id="form_search">
                                    <button class="fa-solid fa-magnifying-glass btn-search" type="submit" title="Buscar"></button>
                                    <input type="text" placeholder="Buscar por:   Nombres | Apellidos | DNI " name="search_input" id="search_input">
                                </form>
                            </div>
                        </div>
                        <div class="content-scan">
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
                            <div class="content-info-scan">
                                <h3>Informacion del alumno</h3>
                                <div class="info-scan">
                                    <div class="photo-student">
                                        <img src="../img/student.png" alt="">
                                    </div>
                                    <div class="content-student">
                                        <div class="info-student">
                                            <p><span>DNI: </span> <span class="info-stu"> 74499797</span></p>
                                            <p><span>NOMBRES: </span><span class="info-stu">Brayam Ruben</span> </p>
                                            <p><span>APELLIDOS: </span> <span class="info-stu">Quispe Ramos</span></p>
                                            <div class="info-flex">
                                                <p><span>GRADO: </span><span class="info-stu">Primero</span> </p>
                                                <p><span>SECCIÓN: </span><span class="info-stu">UNICA</span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="state-atten">
                                    <p class="state-check"><i class="fa-solid fa-circle-check"></i><span>Asistencia registrada</span></p>
                                    <p class="state-warning"><i class="fa-solid fa-triangle-exclamation"></i><span>El alumno ya registró su asistencia</span></p>
                                </div>
                                <div class="action-state">
                                    <button class="btn-check"> Marcar asistencia</button>
                                    <button class="btn-justify"> Marcar justificación</button>
                                </div>
                            </div>
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

<script src="js/attendance.js"></script>

<audio id="audioscaner" src="../src/sonido.mp3"></audio>

</html>