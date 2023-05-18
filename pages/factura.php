<?php
require_once("../assets/plantillas/conexionDB.php");

session_start();
/// Powered by Evilnapsis go to http://evilnapsis.com
include "../assets/fpdf/fpdf.php";

$pdf = new FPDF($orientation='P',$unit='mm');
$pdf->AddPage();
$pdf->SetFont('Arial','B',20);    
$textypos = 5;
$pdf->setY(12);
$pdf->setX(10);
//Datos de la empresa
$pdf->Cell(5,$textypos,"SimGreen");
$pdf->SetFont('Arial','B',10);    
$pdf->setY(30);$pdf->setX(10);
$pdf->Cell(5,$textypos,"DE:");
$pdf->SetFont('Arial','',10);    
$pdf->setY(35);$pdf->setX(10);
$pdf->Cell(5,$textypos,"SimGreen");
$pdf->setY(40);$pdf->setX(10);
$pdf->Cell(5,$textypos,"C/ La Paz 123");
$pdf->setY(45);$pdf->setX(10);
$pdf->Cell(5,$textypos,"+34 123 123 123");
$pdf->setY(50);$pdf->setX(10);
$pdf->Cell(5,$textypos,"simgreen@email.com");

//Creamos array datos para meter dentro el usuario y email del usuario conectado para poner después en la factura
$datos = [];
        $sql= "SELECT usuario, email from cuentas where usuario = '{$_SESSION['usuario']}'";
        $consulta = $conexion->query($sql);
        $totalFilas = $consulta->num_rows;
        for($j = 0; $j < $totalFilas; $j++){
            $fila = $consulta->fetch_assoc();
            
            foreach($fila as $indice => $valor){
                array_push($datos, $valor);
                
            }
        }
        
// Agregamos los datos del cliente
$pdf->SetFont('Arial','B',10);    
$pdf->setY(30);$pdf->setX(75);
$pdf->Cell(5,$textypos,"PARA:");
$pdf->SetFont('Arial','',10);    
$pdf->setY(35);$pdf->setX(75);
$pdf->Cell(5,$textypos,$datos[0]);
$pdf->setY(40);$pdf->setX(75);
$pdf->Cell(5,$textypos,$_SESSION["dir"]);
$pdf->setY(45);$pdf->setX(75);
$pdf->Cell(5,$textypos,$datos[1]);

/// Apartir de aqui empezamos con la tabla de productos
$pdf->setY(60);$pdf->setX(135);
    $pdf->Ln();
/////////////////////////////
//// Array de Cabecera

$products = [];

        //Si en la url está puesto el código (solo saldrá el código si se compra através de producto.php, lo hice así para que no interfiriera con el array de "misProductos") se imprimera está información
        if(isset($_GET["codigo"])){

            $sql= "SELECT nombre_producto, descripción, precio from productos where cod_producto = '{$_GET['codigo']}'";
            $consulta = $conexion->query($sql);
            $totalFilas = $consulta->num_rows;
            $producto = [];

            for($j = 0; $j < $totalFilas; $j++){
                $fila = $consulta->fetch_assoc();
                
                foreach($fila as $indice => $valor){
                    array_push($producto, $valor);
                    
                }
                
                
            }
            $consulta->free();
            array_push($products, $producto);

        } else {
            
            for($i = 0; $i < sizeof($_SESSION["misProductos"]); $i++){

                $sql= "SELECT nombre_producto, descripción, precio from productos where cod_producto = '{$_SESSION['misProductos'][$i]}'";
                $consulta = $conexion->query($sql);
                $totalFilas = $consulta->num_rows;
                $producto = [];

                for($j = 0; $j < $totalFilas; $j++){
                    $fila = $consulta->fetch_assoc();
                    
                    foreach($fila as $indice => $valor){
                        array_push($producto, $valor);
                        
                    }
                    
                    
                }
                $consulta->free();
                array_push($products, $producto);

            }
        }
    




$header = array("Nombre Producto", "Descripcion","Precio");
//// Arrar de Productos

    // Ancho columnas
    $w = array(50, 115, 15);
    // Header
    for($i=0;$i<count($header);$i++)
        $pdf->Cell($w[$i],7,$header[$i],1,0,'C');
    $pdf->Ln();
    // Data
    $total = 0;
    foreach($products as $row)
    {
        $pdf->Cell($w[0],6,utf8_decode($row[0]),1);
        $pdf->Cell($w[1],6,utf8_decode($row[1]),1);
        $pdf->Cell($w[2],6,"$ ".number_format($row[2],2,".",","),'1',0,'R');

        $pdf->Ln();
        $total+=$row[2];

    }
/////////////////////////////
//// Apartir de aqui esta la tabla con los subtotales y totales
$yposdinamic = 60 + (count($products)*10);

$pdf->setY($yposdinamic);
$pdf->setX(235);
    $pdf->Ln();
/////////////////////////////
$header = array("", "");
$data2 = array(
	array("Total", $total),
);
    // Ancho columnas
    $w2 = array(40, 40);
    // Header

    $pdf->Ln();
    // Data
    foreach($data2 as $row)
    {
$pdf->setX(110);
        $pdf->Cell($w2[0],6,$row[0],1);
        $pdf->Cell($w2[1],6,"$ ".number_format($row[1], 2, ".",","),'1',0,'R');

        $pdf->Ln();
    }
/////////////////////////////

$pdf->Cell(5,$textypos,"Powered by Evilnapsis");


$pdf->output();