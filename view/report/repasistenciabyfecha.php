<?php
require('../../lib/fpdf185/fpdf.php');
$reporteFecha = isset($_GET['reporte_fecha']) ? $_GET['reporte_fecha'] : null;
$fechainicio = isset($_GET['fechainicio']) ? $_GET['fechainicio'] : null;
$fechafin = isset($_GET['fechafin']) ? $_GET['fechafin'] : null;
class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        // Logo
        $this->Image('../../img/logo.png', 8, 8, 10);
        // Arial bold 15
        $this->SetFont('Arial', 'B', 15);

        // Título
        $this->Cell(0, 10, utf8_decode('REPORTE DE ASISTENCIAS POR FECHA'), 0, 1, 'C');
        // Salto de línea
        $this->Ln(20);
        $this->SetFont('Arial', 'B', 9);
        $this->SetFillColor(255, 0, 0);
        $this->Cell(10, 10, utf8_decode('N°'), 1, 0, 'C', 0);
        $this->Cell(30, 10, utf8_decode('Doc. Identidad'), 1, 0, 'C', 0);
        $this->Cell(30, 10, utf8_decode('Código'), 1, 0, 'C', 0);
        $this->Cell(80, 10, utf8_decode('Estudiante'), 1, 0, 'C', 0);
        $this->Cell(35, 10, utf8_decode('Grado y Sección'), 1, 0, 'C', 0);
        $this->Cell(25, 10, utf8_decode('Fecha'), 1, 0, 'C', 0);
        $this->Cell(30, 10, utf8_decode('Hora Ingreso'), 1, 0, 'C', 0);
        $this->Cell(30, 10, utf8_decode('Estado'), 1, 1, 'C', 0);
    }

    // Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(0, 10, utf8_decode('Página' . $this->PageNo() . '/{nb}'), 0, 0, 'C');
    }
}
$pdf = new PDF();

$pdf->AliasNbPages();
$pdf->AddPage("L", "A4");

require('../../config/cnx.php');
$cnx = connection();
if ($fechafin != null || $fechafin != '') {
    $sql = "SELECT * FROM alumno INNER JOIN aula ON alumno.Id_Aula = aula.Id_Aula INNER JOIN ingreso ON ingreso.Id_Alumno = alumno.Id_Alumno WHERE ingreso.Fecha_Ingreso >= '$fechainicio' AND ingreso.Fecha_Ingreso <= '$fechafin'";
} else {
    $sql = "SELECT * FROM alumno INNER JOIN aula ON alumno.Id_Aula = aula.Id_Aula INNER JOIN ingreso ON ingreso.Id_Alumno = alumno.Id_Alumno WHERE ingreso.Fecha_Ingreso = '$fechainicio'";
}
$query = mysqli_query($cnx, $sql);
$pdf->SetFont('Arial', '', 8);
$i = 0;
while ($row = $query->fetch_assoc()) {
    $i++;
    if ($row['Tipo_Ingreso'] == 1) {
        $estado = 'Asistio';
    } else {
        $estado = 'Tardanza';
    }
    $pdf->Cell(10, 10, utf8_decode($i), 1, 0, 'C', 0);
    $pdf->Cell(30, 10, utf8_decode($row['Doc_Alumno']), 1, 0, 'C', 0);
    $pdf->Cell(30, 10, utf8_decode($row['Cod_Alumno']), 1, 0, 'C', 0);
    $pdf->Cell(80, 10, utf8_decode($row['Nom_Alumno'] . " " . $row['Apa_Alumno'] . " " . $row['Ama_Alumno']), 1, 0, 'C', 0);
    $pdf->Cell(35, 10, utf8_decode($row['Grado_Aula'] . ' - ' . $row['Seccion_Aula']), 1, 0, 'C', 0);
    $pdf->Cell(25, 10, utf8_decode($row['Fecha_Ingreso']), 1, 0, 'C', 0);
    $pdf->Cell(30, 10, utf8_decode($row['Hora_Ingreso']), 1, 0, 'C', 0);
    $pdf->Cell(30, 10, utf8_decode($estado), 1, 1, 'C', 0);
}
$pdf->Output();
mysqli_close($cnx);
