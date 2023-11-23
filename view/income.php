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
    <title>Asistencias | Colégio 17 Setiembre</title>
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
                                    <button class="fa-solid fa-magnifying-glass btn-search" type="submit" onclick="Buscar()"></button>
                                    <input type="text" class="input-form" name="search_input" id="search_input">
                                    <label class="input-label" for="">Buscar por: Doc. Identidad | Código | Estudiante</label>
                                </div>
                                <div class="content-search-date">
                                    <input type="date" class="input-form" id="search_date">
                                    <label class="input-label input-label-date" for="">Fecha</label>
                                </div>
                                <div class="content-btn-default-search">
                                    <a onclick="QuitarFiltro()">Quitar Filtro</a>
                                </div>
                            </div>

                            <div class="content-btn">
                                <a for="btn-modal-export" class="fa-regular fa-file-pdf" title="Generar Reporte" onclick="ShowModal()" id="btn-show-modal-export"></a>
                                <a href="registerincome.php?rute=aincome" class="fa-solid fa-plus" title="Agregar"></a>
                            </div>
                        </div>
                        <div class="content-info-table">
                            <table id="tblDatos">
                                <thead>
                                    <th>#</th>
                                    <th>Identificador</th>
                                    <th>Estudiante</th>
                                    <th>Grado y sección</th>
                                    <th>Fecha ingreso</th>
                                    <th>Hora ingreso</th>
                                    <th>Estado</th>
                                </thead>
                                <tbody id="tblbodylista">

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal" id="modal-export">
                        <div class="content-modal">
                            <div class="modal-title">
                                <h5>GENERAR REPORTE</h5>
                                <a class="fa-solid fa-xmark btn-close-model" onclick="CloseModal()"></a>
                            </div>
                            <div class="cont-modal">
                                <h6>Información del Reporte</h6>
                                <form id="formulario-modal" class="formulario">
                                    <div class="content-input-modal">
                                        <div class="form-input">
                                            <div class="formulario-grupo formulario-grupo-full grupo-action" id="grupo-tiporeporte">
                                                <div class="grupo-input-action">
                                                    <div class="input-content input-select">
                                                        <i class="fa-solid fa-file-pdf"></i>
                                                        <select name="tiporeporte" class="select-option input-form" id="tiporeporte">
                                                            <option value="" disabled selected></option>
                                                            <option value="1">AULA</option>
                                                            <option value="2">FECHA</option>
                                                            <option value="3">ALUMNO</option>
                                                        </select>
                                                        <label class="input-label" for="">Generar por</label>
                                                        <i class="formulario-validacion-estado fa-solid fa-xmark"></i>
                                                    </div>
                                                </div>
                                                <p class="formulario-input-error">Debe seleccionar una opcion.</p>
                                            </div>
                                            <div class="content-form-reporte" id="report-aula">
                                                <h6>Rerpote por aula</h6>
                                                <div class="formulario-grupo-full grupo-radio" id="grupo-radio">
                                                    <h3>Seleccione una opción</h3>
                                                    <div class="input-content grupo-radio-input">
                                                        <input type="radio" class="input-radio input-radio_aula" name="tipo_generacion_aula" id="programada_aula" value="1">
                                                        <label class="label-radio" for="programada_aula">Rango de Fechas</label>
                                                        <input type="radio" class="input-radio input-radio_aula" name="tipo_generacion_aula" id="periodica_aula" value="2">
                                                        <label class="label-radio" for="periodica_aula">Fecha Puntual
                                                        </label>
                                                    </div>
                                                    <p class="formulario-input-error">Elija una opción</p>
                                                </div>
                                                <div class="formulario-grupo formulario-grupo-full grupo-action" id="grupo-idaula">
                                                    <div class="grupo-input-action">
                                                        <div class="input-content input-select">
                                                            <i class="fa-solid fa-school"></i>
                                                            <select name="idaula" class="select-option input-form" id="idaula">
                                                            </select>
                                                            <label class="input-label" for="">Grado y Sección *</label>
                                                            <i class="formulario-validacion-estado fa-solid fa-xmark"></i>
                                                        </div>
                                                    </div>
                                                    <p class="formulario-input-error">Debe seleccionar una opcion.</p>
                                                </div>
                                                <div class="formulario-grupo formulario-grupo-full" id="grupo-fechainicio">
                                                    <div class="input-content input-datetime">
                                                        <i class="fa-solid fa-calendar-days"></i>
                                                        <input type="date" class="input-form-date" name="fechainicio_aula" id="fechainicio_aula">
                                                        <label class="input-label input-label-date" for="">Fecha Inicio *</label>
                                                        <i class="formulario-validacion-estado fa-solid fa-xmark"></i>
                                                    </div>
                                                    <p class="formulario-input-error">Debe ingresar una fecha</p>
                                                </div>
                                                <div class="formulario-grupo formulario-grupo-full" id="grupo-fechafin">
                                                    <div class="input-content input-datetime">
                                                        <i class="fa-solid fa-calendar-days"></i>
                                                        <input type="date" class="input-form-date" name="fechafin_aula" id="fechafin_aula">
                                                        <label class="input-label input-label-date" for="">Fecha Fin</label>
                                                        <i class="formulario-validacion-estado fa-solid fa-xmark"></i>
                                                    </div>
                                                    <p class="formulario-input-error">Debe ingresar una fecha</p>
                                                </div>
                                                <div class="content-btn-action">
                                                    <a id="generar_reporte_aula">Generar</a>
                                                </div>
                                            </div>
                                            <div class="content-form-reporte" id="report-fecha">
                                                <h6>Reporte por fecha</h6>

                                                <div class="formulario-grupo-full grupo-radio" id="grupo-radio">
                                                    <h3>Seleccione una opción</h3>
                                                    <div class="input-content grupo-radio-input">
                                                        <input type="radio" class="input-radio input-radio_fecha" name="reporte_fecha" id="programada_fecha" value="1">
                                                        <label class="label-radio" for="programada_fecha">Rango de Fechas</label>
                                                        <input type="radio" class="input-radio input-radio_fecha" name="reporte_fecha" id="periodica_fecha" value="2">
                                                        <label class="label-radio" for="periodica_fecha">Fecha Puntual</label>
                                                    </div>
                                                    <p class="formulario-input-error">Elija una opción</p>
                                                </div>
                                                <div class="formulario-grupo formulario-grupo-full" id="grupo-fechainicio">
                                                    <div class="input-content input-datetime">
                                                        <i class="fa-solid fa-calendar-days"></i>
                                                        <input type="date" class="input-form-date" name="fechainicio_fecha" id="fechainicio_fecha">
                                                        <label class="input-label input-label-date" for="">Fecha Inicio *</label>
                                                        <i class="formulario-validacion-estado fa-solid fa-xmark"></i>
                                                    </div>
                                                    <p class="formulario-input-error">Debe ingresar una fecha</p>
                                                </div>
                                                <div class="formulario-grupo formulario-grupo-full" id="grupo-fechafin">
                                                    <div class="input-content input-datetime">
                                                        <i class="fa-solid fa-calendar-days"></i>
                                                        <input type="date" class="input-form-date" name="fechafin_fecha" id="fechafin_fecha">
                                                        <label class="input-label input-label-date" for="">Fecha Fin</label>
                                                        <i class="formulario-validacion-estado fa-solid fa-xmark"></i>
                                                    </div>
                                                    <p class="formulario-input-error">Debe ingresar una fecha</p>
                                                </div>
                                                <div class="content-btn-action">
                                                    <a id="generar_reporte_fecha">Generar</a>
                                                </div>
                                            </div>
                                            <div class="content-form-reporte" id="report-alumno">
                                                <h6>Reporte por alumno</h6>

                                                <div class="formulario-grupo-full grupo-radio" id="grupo-radio">
                                                    <h3>Seleccione una opción</h3>
                                                    <div class="input-content grupo-radio-input">
                                                        <input type="radio" class="input-radio input-radio_alumno" name="reporte_alumno" id="programada_alumno" value="1">
                                                        <label class="label-radio" for="programada_alumno">Rango de Fechas</label>
                                                        <input type="radio" class="input-radio input-radio_alumno" name="reporte_alumno" id="periodica_alumno" value="2">
                                                        <label class="label-radio" for="periodica_alumno">Fecha Puntual</label>
                                                    </div>
                                                    <p class="formulario-input-error">Elija una opción</p>
                                                </div>
                                                <div class="formulario-grupo formulario-grupo-full" id="grupo-autocomplete-student">
                                                    <div class="input-content">
                                                        <input type="hidden" name="idstundent" id="idstudent">
                                                        <i class="fa-solid fa-calendar-days"></i>
                                                        <input type="text" name="search_student" id="search_student" class="input-form" autocomplete="off">
                                                        <label class="input-label" for="">Buscar por: DNI | Nombres | Apellidos *</label>
                                                        <div class="content-autocomplete">
                                                            <ul id="lst-student">
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="formulario-grupo formulario-grupo-full" id="grupo-fechainicio">
                                                    <div class="input-content input-datetime">
                                                        <i class="fa-solid fa-calendar-days"></i>
                                                        <input type="date" class="input-form-date" name="fechainicio_alumno" id="fechainicio_alumno">
                                                        <label class="input-label input-label-date" for="">Fecha Inicio *</label>
                                                        <i class="formulario-validacion-estado fa-solid fa-xmark"></i>
                                                    </div>
                                                    <p class="formulario-input-error">Debe ingresar una fecha</p>
                                                </div>
                                                <div class="formulario-grupo formulario-grupo-full" id="grupo-fechafin">
                                                    <div class="input-content input-datetime">
                                                        <i class="fa-solid fa-calendar-days"></i>
                                                        <input type="date" class="input-form-date" name="fechafin_alumno" id="fechafin_alumno">
                                                        <label class="input-label input-label-date" for="">Fecha Fin</label>
                                                        <i class="formulario-validacion-estado fa-solid fa-xmark"></i>
                                                    </div>
                                                    <p class="formulario-input-error">Debe ingresar una fecha</p>
                                                </div>
                                                <div class="content-btn-action">
                                                    <a id="generar_reporte_alumno">Generar</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="paginador"></div>
            </div>
        </main>
    </div>


</body>
<?php
include("../config/global_script.php");
?>
<script src="js/income.js"></script>

</html>