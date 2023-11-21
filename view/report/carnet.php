<?php
require('../../lib/fpdf185/fpdf.php');
$id = $_GET['id'];
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
        $this->Cell(0, 10, utf8_decode('CARNÉ DE IDENTIFICACIÓN'), 0, 1, 'C');
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
$sql = "SELECT * FROM alumno INNER JOIN aula ON alumno.Id_Aula = aula.Id_Aula WHERE Id_Alumno  = $id";
$query = mysqli_query($cnx, $sql);

$rspta = $query->fetch_assoc();

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage("L", "A5");

$pdf->Rect(20, 35, 35, 45);

$pdf->SetTextColor(255, 0, 0);
$pdf->SetFont('Arial', 'B', 12);

$pdf->SetX(70);
$pdf->Cell(60, 0, 'DOC. IDENTIDAD: ', 0, 0,);
$pdf->SetTextColor(0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(30, 0, $rspta['Doc_Alumno'], 0, 1);


$pdf->SetTextColor(255, 0, 0);
$pdf->SetFont('Arial', 'B', 12);

$pdf->SetX(70);
$pdf->Cell(60, 20, 'NOMBRES: ', 0, 0,);
$pdf->SetTextColor(0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 20, utf8_decode($rspta['Nom_Alumno']), 0, 1);


$pdf->SetX(70);
$pdf->SetTextColor(255, 0, 0);
$pdf->SetFont('Arial', 'B', 12);

$pdf->Cell(60, 0, 'APELLIDOS: ', 0, 0,);
$pdf->SetTextColor(0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 0, utf8_decode($rspta['Apa_Alumno'] . " " . $rspta['Ama_Alumno']), 0, 1);


$pdf->SetTextColor(255, 0, 0);
$pdf->SetFont('Arial', 'B', 12);

$pdf->SetX(70);
$pdf->Cell(30, 20, 'GRADO: ', 0, 0,);
$pdf->SetTextColor(0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 20, utf8_decode($rspta['Grado_Aula']), 0, 0);

$pdf->SetTextColor(255, 0, 0);
$pdf->SetFont('Arial', 'B', 12);

$pdf->SetX(130);
$pdf->Cell(30, 20, utf8_decode('SECCIÓN: '), 0, 0,);
$pdf->SetTextColor(0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 20, utf8_decode($rspta['Seccion_Aula']), 0, 1);

$pdf->Image('../../src/qr-student/' . $rspta['Qr_Alumno'], 72, 75, 60);

$pdf->Output();
mysqli_close($cnx);
