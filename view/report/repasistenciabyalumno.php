<?php
require('../../lib/fpdf185/fpdf.php');
$id = isset($_GET['id']) ? $_GET['id'] : null;
$reporteAula = isset($_GET['reporte_aula']) ? $_GET['reporte_aula'] : null;
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
        $this->Cell(0, 10, utf8_decode('REPORTE DE ASISTENCIAS POR ALUMNO'), 0, 1, 'C');
        // Salto de línea
        $this->Ln(20);
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
require('../../config/cnx.php');
$cnx = connection();
$sql = "SELECT * FROM alumno INNER JOIN aula ON alumno.Id_Aula = aula.Id_Aula WHERE alumno.Id_Alumno = $id";
$query = mysqli_query($cnx, $sql);

$rspta = $query->fetch_assoc();

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage("L", "A5");

$pdf->Rect(10, 35, 40, 50);
if ($rspta['Foto_Alumno'] == null || $rspta['Foto_Alumno'] == "") {
    $pdf->Image('../../img/student.png', 10, 35, 40, 50);
} else {
    $pdf->Image('../../src/img-stundet/' . $rspta['Foto_Alumno'], 10, 35, 40, 50);
}

$pdf->SetTextColor(255, 0, 0);
$pdf->SetFont('Arial', 'B', 12);

$pdf->SetX(60);
$pdf->Cell(40, 0, 'DOC. IDENTIDAD: ', 0, 0,);
$pdf->SetTextColor(0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(30, 0, $rspta['Doc_Alumno'], 0, 1);


$pdf->SetTextColor(255, 0, 0);
$pdf->SetFont('Arial', 'B', 12);

$pdf->SetX(60);
$pdf->Cell(40, 20, 'NOMBRES: ', 0, 0,);
$pdf->SetTextColor(0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 20, utf8_decode($rspta['Nom_Alumno']), 0, 1);


$pdf->SetX(60);
$pdf->SetTextColor(255, 0, 0);
$pdf->SetFont('Arial', 'B', 12);

$pdf->Cell(40, 0, 'APELLIDOS: ', 0, 0,);
$pdf->SetTextColor(0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 0, utf8_decode($rspta['Apa_Alumno'] . " " . $rspta['Ama_Alumno']), 0, 1);


$pdf->SetTextColor(255, 0, 0);
$pdf->SetFont('Arial', 'B', 12);

$pdf->SetX(60);
$pdf->Cell(40, 20, 'GRADO: ', 0, 0,);
$pdf->SetTextColor(0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 20, utf8_decode($rspta['Grado_Aula']), 0, 1);

$pdf->SetTextColor(255, 0, 0);
$pdf->SetFont('Arial', 'B', 12);

$pdf->SetX(60);
$pdf->Cell(40, 0, utf8_decode('SECCIÓN: '), 0, 0,);
$pdf->SetTextColor(0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 0, utf8_decode($rspta['Seccion_Aula']), 0, 1);

$pdf->Image('../../src/qr-student/' . $rspta['Qr_Alumno'], 150, 35, 50);
$pdf->Ln(15);

if ($fechafin != null || $fechafin != '') {
    $sql = "SELECT * FROM alumno INNER JOIN ingreso ON alumno.Id_Alumno = ingreso.Id_Alumno WHERE alumno.Id_Alumno = $id AND ingreso.Fecha_Ingreso >= '$fechainicio' AND ingreso.Fecha_Ingreso <= '$fechafin'";
} else {
    $sql = "SELECT * FROM alumno INNER JOIN ingreso ON alumno.Id_Alumno = ingreso.Id_Alumno WHERE alumno.Id_Alumno = $id AND ingreso.Fecha_Ingreso = '$fechainicio'";
}
$query = mysqli_query($cnx, $sql);
$pdf->SetX(25);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(15, 10, utf8_decode('#'), 1, 0, 'C', 0);
$pdf->Cell(50, 10, utf8_decode('Fecha'), 1, 0, 'C', 0);
$pdf->Cell(50, 10, utf8_decode('Hora Ingreso'), 1, 0, 'C', 0);
$pdf->Cell(50, 10, utf8_decode('Estado'), 1, 1, 'C', 0);

$i = 0;
while ($row = $query->fetch_assoc()) {
    $i++;
    if ($row['Tipo_Ingreso'] == 1) {
        $estado = 'Asistio';
    } else {
        $estado = 'Tardanza';
    }
    $pdf->SetX(25);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(15, 10, utf8_decode($i), 1, 0, 'C', 0);
    $pdf->Cell(50, 10, utf8_decode($row['Fecha_Ingreso']), 1, 0, 'C', 0);
    $pdf->Cell(50, 10, utf8_decode($row['Hora_Ingreso']), 1, 0, 'C', 0);
    $pdf->Cell(50, 10, utf8_decode($estado), 1, 1, 'C', 0);
}
$pdf->Output();
mysqli_close($cnx);
