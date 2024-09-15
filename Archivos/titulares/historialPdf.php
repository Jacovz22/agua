<?php
include "../../global/conexion.php";
include '../../global/funtionG.php';
$salida = "";
$salidaPagos = "";
$salidaFaenas = "";
$totalPagado = 0;
$totalPendiente = 0;
$idTitular = isset($_GET['id']) ? base64_decode($_GET['id']) : 0;
$sqlSelect = ejecutarConsultaSimpleFila("SELECT t.*, CONCAT_WS(' ', dt.Calle, CONCAT('No.', dt.NumeroExterior), IF(dt.NumeroInterior IS NOT NULL AND dt.NumeroInterior != '', CONCAT('Int.', dt.NumeroInterior), NULL), dt.Colonia, dt.CodigoPostal, dt.Municipio, dt.Estado, dt.Pais ) AS DireccionTomaCompleta, CONCAT_WS(' ', d.Calle, CONCAT('No.', d.NumeroExterior), IF(d.NumeroInterior IS NOT NULL AND d.NumeroInterior != '', CONCAT('Int.', d.NumeroInterior), NULL), d.Colonia, d.CodigoPostal, d.Municipio, d.Estado, d.Pais ) AS DireccionTitularCompleta FROM Titulares t LEFT JOIN Direcciones dt ON t.DireccionTomaID = dt.DireccionID LEFT JOIN Direcciones d ON t.DireccionID = d.DireccionID WHERE t.TitularID = ?;", [$idTitular]);
$sqlPagos = "SELECT * FROM `Cooperaciones` WHERE TitularID=?;";
$resultPagos = ejecutarConsulta($sqlPagos, [$idTitular]);
$selectFaenas = "SELECT R.Titulo,R.Fecha,AR.descripcion FROM Asistencias_Reuniones AR LEFT JOIN Reuniones R ON (AR.ReunionID=R.ReunionID) WHERE TitularID=? ORDER BY R.Fecha ASC";
$reultFaenas = ejecutarConsulta($selectFaenas, [$idTitular]);
while ($fila = mysqli_fetch_object($resultPagos)) {
    $totalPagado += $fila->Estatus == "Completada" ? $fila->Monto : 0;
    $totalPendiente += $fila->Estatus == "Pendiente" ? $fila->Monto : 0;
    $salidaPagos .= "
     <tr>
        <td class='height20'>$fila->Concepto</td>
        <td class='height20 textCenter'>$fila->Fecha</td>
        <td class='height20 textCenter'>$$fila->Monto</td>
        <td class='height20 textLeft'>$fila->Estatus</td>
     </tr>
    ";
}
while ($fila = mysqli_fetch_object($reultFaenas)) {
    $salidaFaenas .= "
     <tr>
        <td class='height20'>$fila->Titulo</td>
        <td class='height20 textCenter'>$fila->Fecha</td>
        <td class='height20 textCenter'>$fila->descripcion</td>
     </tr>
    ";
}
ob_start();
?>

<style>
    .mb15 {
        margin-bottom: 15px;
    }

    .W150 {
        width: 150px;
    }

    .W200 {
        width: 200px;
    }

    .W250 {
        width: 250px;
    }

    .W300 {
        width: 300px;
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

    .textLeft {
        text-align: left;
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

    .tam20 {
        font-size: 20px;
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
                    <h4>Comite de agua de Atmoloni, Hueyapan, Puebla</h4>
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

    <table border="0" align="center" cellspacing=0 cellpadding=0 class="mb15">
        <tr>
            <th class="W400 textLeft tam20">Reporte de pagos y participación en faenas.</th>
        </tr>
    </table>

    <table border="0" align="left" cellspacing=0 cellpadding=0 class="mb15">
        <tr>
            <th class="W150 textRight">Nombre:</th>
            <td class="W200"><?php echo $sqlSelect['NombreTitular']; ?></td>
            <th class="W200 textRight">¿Cuenta con toma de agua?:</th>
            <td class="W200"><?php echo $sqlSelect['TieneTomaAgua'] == 1 ? "SI" : "NO"; ?></td>
        </tr>
        <tr>
            <th class="W150 textRight">Apellido paterno:</th>
            <td class="W200"><?php echo $sqlSelect['ApellidoPaterno']; ?></td>
            <th class="W200 textRight">Estatus:</th>
            <td class="W200"><?php echo $sqlSelect['EstatusTitular']; ?></td>
        </tr>
        <tr>
            <th class="W150 textRight">Apellido materno:</th>
            <td class="W200"><?php echo $sqlSelect['ApellidoMaterno']; ?></td>
            <th class="W150 textRight">Telefono:</th>
            <td class="W200"><?php echo $sqlSelect['Telefono'] != "" ? $sqlSelect['Telefono'] : "----------------------------"; ?></td>
        </tr>
        <tr>
            <th class="W150 textRight">Correo:</th>
            <td class="W200"><?php echo $sqlSelect['Email'] != "" ? $sqlSelect['Email'] : "----------------------------"; ?></td>
            <th class="W200 textRight"></th>
        </tr>
        <tr>
            <th class="W150 textRight">Dirección:</th>
            <td class="" colspan="3"><?php echo $sqlSelect['DireccionTitularCompleta'] != "" ? $sqlSelect['DireccionTitularCompleta'] : "----------------------------"; ?></td>
        </tr>
        <tr>
            <th class="W150 textRight">Dirección de toma:</th>
            <td class="" colspan="3"><?php echo $sqlSelect['DireccionTomaCompleta'] != "" ? $sqlSelect['DireccionTomaCompleta'] : "----------------------------"; ?></td>
        </tr>
        <tr>
            <th class="W150 textRight">Observaciones:</th>
            <td class="W200" colspan="3"><?php echo $sqlSelect['Observaciones'] != "" ? $sqlSelect['Observaciones'] : "----------------------------"; ?></td>
        </tr>
    </table>

    <table border="0" align="left" cellspacing=0 cellpadding=0 class="mb15">
        <tr>
            <th class="W400 textLeft tam20">Historial de pagos.</th>
        </tr>
    </table>

    <table border="0" align="left" cellspacing=0 cellpadding=0 class="mb15">
        <tr>
            <th class="textCenter W300 fondoA">Concepto</th>
            <th class="textCenter W150 fondoA">Fecha</th>
            <th class="textCenter W150 fondoA">Monto</th>
            <th class="textCenter W150 fondoA">Estatus</th>

        </tr>
        <?php echo $salidaPagos; ?>
        <tr>
            <td></td>
            <td class="textRight"><b>Total pendiente:</b></td>
            <td class="textRight"><?php echo "$" . $totalPendiente; ?></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td class="textRight"><b>Total pagado:</b></td>
            <td class="textRight"><?php echo "$" . $totalPagado; ?></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td class="textRight"><b>Total:</b></td>
            <td class="textRight"><?php echo "$" . ($totalPagado + $totalPendiente); ?></td>
            <td></td>
        </tr>
    </table>
    <table border="0" align="left" cellspacing=0 cellpadding=0 class="mb15">
        <tr>
            <th class="W400 textLeft tam20">Participación en faenas.</th>
        </tr>
    </table>
    <table border="0" align="left" cellspacing=0 cellpadding=0 class="mb15">
        <tr>
            <th class="textCenter W300 fondoA">Titulo</th>
            <th class="textCenter W150 fondoA">Fecha</th>
            <th class="textCenter W300 fondoA">Observaciones</th>
        </tr>
        <?php echo $salidaFaenas; ?>
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