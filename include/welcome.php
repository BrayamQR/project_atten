<?php
date_default_timezone_set('America/Lima');
$fech = date('d-m-Y');
if (isset($_GET['rute'])) {
    switch ($_GET['rute']) {
        case 'astudent':
            $tittle = 'Información del Estudiante';
            break;
        case 'mstudent':
            $tittle = 'Mantenimiento del Estudiante';
            break;
        case 'aincome':
            $tittle = 'Marcar Asistencia';
            break;
        case 'mincome':
            $tittle = 'Asistencias';
            break;
        case 'aactivity':
            $tittle = 'Información de la Actividad';
            break;
        case 'mactivity':
            $tittle = 'Mantenimiento de la Actividad';
            break;
        case 'auser':
            $tittle = 'Información del Usuario';
            break;
        case 'muser':
            $tittle = 'Mantenimiento del Usuario';
            break;
        case 'mprofile':
            $tittle = 'Mantenimiento del Perfíl';
            break;
        case 'aclassroom':
            $tittle = 'Información del Aula';
            break;
        case 'mclassroom':
            $tittle = 'Mantenimiento del Aula';
            break;
    }
} else {
    $tittle = 'Bienvenido al sistema';
}
?>
<div class="wellcome-content">
    <i class="fa-solid fa-bars btn-menu" id="btn-menu"></i>
    <div class="date-content">
        <p>Fecha actual del sistema: <span><?php echo $fech; ?></span></p>
    </div>
    <h3><?php echo $tittle; ?></h3>
</div>