<?php

require_once "../../../controladores/cars.controlador.php";
require_once "../../../modelos/cars.modelo.php";
require_once "../../../controladores/sucursal.controlador.php";
require_once "../../../modelos/sucursal.modelo.php";

class imprimirCar{
	
public $guia;

public function traerImpresionCar(){

// TRAEMOS LA INFORMACION DE LA GUIA

$itemNguia = "nguia";
$valorNguia = $this->guia;
$orden = "id";

$respuestacar = ControladorCars::ctrMostrarCars($itemNguia, $valorNguia, $orden);

$codcli = $respuestacar["codcli"];
$nombre = $respuestacar["nombre"];
$sucadm = $respuestacar["id_sucadm"];
$nomrem = $respuestacar["nomrem"];
$nomdes = $respuestacar["nomdes"];

// $frecib = $respuestacar["frecib"];
// $fdeliv = $respuestacar["fdeliv"];
$frecib = date("d/m/Y", strtotime($respuestacar["frecib"]));
$fdeliv = date("d/m/Y", strtotime($respuestacar["fdeliv"]));
$pdfcar = $respuestacar["pdf"];
// cars/extenciones/tcpdf/pdf
if($respuestacar["pdf"] == ""){

	 $foto = "../../../";
	 $fotocar = $foto."vistas/img/cars/default/default.png";

}else{
	
	$foto = "../../../";
	$fotocar = $foto.$pdfcar;

}

$itemSuc = "id";
$valorSuc = $respuestacar["id_sucadm"];

$respuestasuc = ControladorSucursal::ctrMostrarSucursales($itemSuc, $valorSuc);

$domicilio = $respuestasuc["domicilio"];
$localidad = $respuestasuc["localidad"];
$telefono = $respuestasuc["telefono"];
$mail = $respuestasuc["email"];

$itemOrg = "id";
$valorOrg = $respuestacar["org"];

$respuestaorg = ControladorSucursal::ctrMostrarSucursales($itemOrg, $valorOrg);

$org = $respuestaorg["denom"];

$itemDst = "id";
$valorDst = $respuestacar["dst"];

$respuestadst = ControladorSucursal::ctrMostrarSucursales($itemDst, $valorDst);

$dst = $respuestadst["denom"];


require_once('tcpdf_include.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->startPageGroup();

$pdf->AddPage();

// ----------------------------------------

$bloque1 = <<<EOF

	<table>

		<tr>

			<td style="width:120px"><img src="images/logo-camio-grande.png"></td>

			<td style="width:10px"></td>
			<td style="background-color:white; width:140px">

				<div style="font-size:8.5px; text-align:left; line-height:15px; padding-left:10%">

					<br>
					C.U.I.T.: 33-53112259-9

					<br>
					Dirección: $respuestasuc[domicilio]
							   $respuestasuc[localidad]

				</div>

			</td>

			<td style="background-color:white; width:140px">

				<div style="font-size:8.5px; text-align:left; line-height:15px;">

					<br>
					Telefonos: $respuestasuc[telefono]

					<br>
					E-Mail: $respuestasuc[email]

				</div>

			</td>

			<td style="width:10px"></td>

			<td style="background-color:white; width:120px">
				
				<div style="text_align:center; color:red">
				
					<br>
				
					<br>
				
					Corresponde Guia

					<br>
					
					$valorNguia
				
				</div>
			
			</td>			

		</tr>

	</table>

EOF;

$pdf->writeHTML($bloque1, false, false, false, false, '');	

// ---------------------------------------

$bloque2 = <<<EOF

	<table>

		<tr>

			<td style="width:540px"><img src="images/back.jpg"></td>

		</tr>

	</table>

	<table style="font-size:10px; padding:5px 10px;">

		<tr>

			<td style="border: 1px solid #666; background-color:white; width:390px">

				Cliente: $respuestacar[codcli] - $respuestacar[nombre]

			</td>

			<td style="border: 1px solid #666; background-color:white; width:150px; text_aling: right">

				GUIA: $respuestacar[nguia]

			</td>

		</tr>

		<tr>

			<td style="border-bottom: 1px solid #666; background-color: white; width: 540px"></td>

		</tr>

	</table>

EOF;

$pdf->writeHTML($bloque2, false, false, false, false, '');

// ---------------------------------------
$bloque3 = <<<EOF

	<table style="font-size:10px; padding: 5px 10px">

		<tr>

			<td style="border: 1px solid #666; background-color: #D3D3D3; width: 135px; text-aling: center">Origen</td>

			<td style="border: 1px solid #666; background-color: white; width: 135px; text-aling: center">$org</td>

			<td style="border: 1px solid #666; background-color: #D3D3D3; width: 135px; text-aling: center">Destino</td>

			<td style="border: 1px solid #666; background-color: white; width: 135px; text-aling: center">$dst</td>

		</tr>
		
		<tr>

			<td style="border-bottom: 1px solid #666; background-color: white; width: 540px"></td>

		</tr>
	
	</table>

EOF;

$pdf->writeHTML($bloque3, false, false, false, false, '');

// -----------------------------------------
$bloque4 = <<<EOF

	<table style="font-size:10px; padding: 5px 10px">

		<tr>

			<td style="border: 1px solid #666; background-color: #D3D3D3; width: 135px; text-aling: center">Remitente</td>

			<td style="border: 1px solid #666; background-color: #D3D3D3; width: 135px; text-aling: center">Destinatario</td>

			<td style="border: 1px solid #666; background-color: #D3D3D3; width: 135px; text-aling: center">Fecha Guia</td>

			<td style="border: 1px solid #666; background-color: #D3D3D3; width: 135px; text-aling: center">Fecha Entrega</td>

		</tr>

	</table>

EOF;

$pdf->writeHTML($bloque4, false, false, false, false, '');

// ---------------------------------------

$bloque5 = <<<EOF

	<table style="font-size:10px; padding: 5px 10px">

		<tr>

			<td style="border: 1px solid #666; background-color: white; width: 135px; text-aling: center">$respuestacar[nomrem]</td>

			<td style="border: 1px solid #666; background-color: white; width: 135px; text-aling: center">$respuestacar[nomdes]</td>

			<td style="border: 1px solid #666; background-color: white; width: 135px; text-aling: center">$frecib</td>

			<td style="border: 1px solid #666; background-color: white; width: 135px; text-aling: center">$fdeliv</td>

		</tr>

		<tr>

			<td style="border-bottom: 1px solid #666; background-color: white; width: 540px"></td>

		</tr>

	</table>

EOF;

$pdf->writeHTML($bloque5, false, false, false, false, '');


// ---------------------------------------

$bloque6 = <<<EOF

	<table style="font-size:10px; padding: 5px 10px">

		<tr>

			<td style="background-color:white; width:540px">

				<div style="font-size:18.5px; text-align:center; line-height:15px; padding-left:10%">

					<br>

					IMAGEN DEL CAR CORRESPONDIENTE

					<br>

				</div>

			</td>			

		</tr>

		<tr>

			<td style="border-bottom: 1px solid #666; background-color: white; width: 540px"></td>

		</tr>

	</table>

EOF;

$pdf->writeHTML($bloque6, false, false, false, false, '');

// ---------------------------------------

$bloque7 = <<<EOF

	<table>

		<tr>

			<td style="background-color:white; width:540px">
				
				<div style="border: 2px solid #666; background-color:white; width:390px">
				
					<img src="$fotocar" style="width:390px; padding:0px 0px 0px 10px">

				</div>

			</td>	

		</tr>

	</table>
	
EOF;

$pdf->writeHTML($bloque7, false, false, false, false, '');

// ----------------------------------------
// SALIDA DEL ARCHIVO

$pdf->Output('car'.$_GET["guianro"].'.pdf');

}

}

$car = new imprimirCar;

$car -> guia = $_GET["guianro"];

$car -> traerImpresionCar();

