<?php
require('../fpdf185/fpdf.php');
include("../php/cnx.php");
$cnx = connection();
$fecha = $_POST['reporte'];

class PDF extends FPDF
{
// Cabecera de página
    function Header()
    {
        // Arial bold 15
        $this->SetFont('Arial','B',18);
        // Movernos a la derecha
        $this->Cell(35);
        // Título
        $this->Cell(120,10,'REPORTE DEL INGRESO DE PRODUCTOS',0,0,'C');
        // Salto de línea
        $this->Ln(20);
        $this->SetFont('Arial','B',12);
        $this->Cell(10,10,"#",1,0,'C',0);
        $this->Cell(20,10,utf8_decode("CÓDIGO"),1,0,'C',0);
        $this->Cell(35,10,"NOMBRE",1,0,'C',0);
        $this->Cell(25,10,"CANTIDAD",1,0,'C',0);
        $this->Cell(35,10,"PRE. COMPRA",1,0,'C',0);
        $this->Cell(30,10,"PRE. VENTA",1,0,'C',0);
        $this->Cell(30,10,"PROVEEDOR",1,1,'C',0);
    }

    // Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Número de página
        $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
    }
}

$sql = "SELECT producto.Cod_Producto, producto.Nom_Producto, stock.Can_Stock, stock.Pre_Compra, stock.Pre_Venta,proveedor.Nom_Proveedor FROM stock INNER JOIN producto ON stock.Id_Producto = producto.Id_Producto INNER JOIN proveedor ON stock.Id_Proveedor = proveedor.Id_Proveedor WHERE stock.Fech_Compra = '$fecha'";
$query = mysqli_query($cnx,$sql);

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);

$i = 0;
while($row = mysqli_fetch_assoc($query)){
    $i++;
    $pdf->Cell(10,10,$i,1,0,'C',0);
    $pdf->Cell(20,10,utf8_decode($row['Cod_Producto']),1,0,'C',0);
    $pdf->Cell(35,10,utf8_decode($row['Nom_Producto']),1,0,'C',0);
    $pdf->Cell(25,10,utf8_decode($row['Can_Stock']),1,0,'C',0);
    $pdf->Cell(35,10,utf8_decode($row['Pre_Compra']),1,0,'C',0);
    $pdf->Cell(30,10,utf8_decode($row['Pre_Venta']),1,0,'C',0);
    $pdf->Cell(30,10,utf8_decode($row['Nom_Proveedor']),1,1,'C',0);
}
$pdf->Output();
?>