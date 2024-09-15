<?php
include "../../global/conexion.php";
include '../../global/funtionG.php';
$salida = "";
$count = 0;
$idList = isset($_GET['idList']) ? base64_decode($_GET['idList']) : 0;
$sqlSelect = "SELECT CONCAT(T.NombreTitular, ' ', T.ApellidoPaterno, ' ', T.ApellidoMaterno) AS NombreCompleto, AR.descripcion
FROM Asistencias_Reuniones AR
LEFT JOIN Titulares T ON (AR.TitularID=T.TitularID)
WHERE AR.ReunionID=?
ORDER BY NombreCompleto ASC; ";
$resultSqlSelect = ejecutarConsulta($sqlSelect, [$idList]);
$sqlSelectDataR = "SELECT * FROM Reuniones where ReunionID=?";
$resultSelectDataR = ejecutarConsultaSimpleFila($sqlSelectDataR, [$idList]);


while ($fila = mysqli_fetch_object($resultSqlSelect)) {
    $count++;
    $salida .= "
     <tr>
        <td class='W250 alineado height20'>$count.- $fila->NombreCompleto</td>
        <td class='W400 alineado height20'>$fila->descripcion</td>
     </tr>
    ";
}
ob_start();
?>

<style>
    .mb15 {
        margin-bottom: 15px;
    }

    .W200 {
        width: 200px;
    }

    .W250 {
        width: 250px;
    }

    .W400 {
        width: 400px;
    }

    .lineaDebajo {
        border-bottom: 2px solid #f7ca46;
        padding-bottom: 5px;
        display: inline-block;
    }

    .textCenter {
        text-align: center;
    }

    .textRight {
        text-align: right;
    }

    .fondoA {
        background-color: #213846;
        color: white;
    }

    .alineado {
        vertical-align: middle;
    }

    .height20 {
        height: 20px;
    }

    .tam15 {
        font-size: 12px;
    }

    table {
        font-family: Arial, sans-serif;
    }
</style>

<page backtop="50mm" backbottom="10mm" backleft="0mm" backright="0mm">
    <page_header>
        <table border="0" align="left" cellspacing=0 cellpadding=0 class="mb15">
            <tr>
                <th class="W150 lineaDebajo" rowspan="2">
                    <img src="../../img/logoAgua.png" alt="Logo" width="150">
                </th>
                <th class="W400 lineaDebajo textCenter" rowspan="2">
                    <h4>Comite de agua potable de Atmoloni, Hueyapan, Puebla</h4>
                </th>
                <th class="W200 textRight">
                    Página [[page_cu]] / [[page_nb]]
                </th>
            </tr>
            <tr>
                <th class="W200 lineaDebajo textRight tam15"><?php echo fechaActual(); ?></th>
            </tr>
        </table>
    </page_header>
    <table border="0" align="left" cellspacing=0 cellpadding=0 class="mb15">
        <tr>
            <th colspan="3" class="textCenter W746">
                <h2>LISTA DE ASISTENCIA</h2>
            </th>
        </tr>
        <tr>
            <th colspan="3" class="textDerecha"><?php echo $resultSelectDataR["Titulo"] . " CON FECHA DEL " . $resultSelectDataR["Fecha"] . " "; ?></th>
        </tr>
        <tr>
            <th colspan="3" class="textDerecha"><?php echo "N° " . $idList; ?></th>
        </tr>
    </table>

    <table border="0" align="left" cellspacing=0 cellpadding=0 class="mb15">
        <tr>
            <th class="textCenter W200 fondoA">Nombre</th>
            <th class="textCenter W400 fondoA">Descripción</th>
        </tr>
        <?php echo $salida; ?>
    </table>
</page>

<?php
$content = ob_get_clean();
require '../../Library/vendorPdf/vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;

$html2pdf = new Html2Pdf('P', 'LETTER', 'es', 'true', 'UTF-8');
$html2pdf->writeHTML($content);
$html2pdf->output('resporte_de_asistencia.pdf');
?>