<?php
include "../../global/conexion.php";
include '../../global/funtionG.php';
$salidaTransacciones = "";
$salidaPagos = "";
$totalTI = 0;
$totalTE = 0;
$totalPagos = 0;
$totalPendiente = 0;
//transacciones
$sqlSelectT = "SELECT * FROM Transacciones WHERE Estatus=? ORDER BY Fecha ASC; ";
$reutlSqlT = ejecutarConsulta($sqlSelectT, ["Activo"]);
while ($fila = mysqli_fetch_object($reutlSqlT)) {

    $totalTI += $fila->Tipo == "Ingreso" ? $fila->Monto : 0;
    $totalTE += $fila->Tipo == "Egreso" ? $fila->Monto : 0;

    $salidaTransacciones .= "
     <tr>
        <td class='lineaDebajoR W150'>$fila->Titulo</td>
        <td class='lineaDebajoR alineado W300'> $fila->Descripcion</td>
        <td class='lineaDebajoR W100 textCenter'>$fila->Fecha</td>
        <td class='lineaDebajoR W80 textLeft'>$fila->Tipo</td>
        <td class='lineaDebajoR W80 textRight'>$" . $fila->Monto . "</td>
     </tr>
    ";
}

$sqlPagosT = "SELECT CONCAT(T.NombreTitular, ' ', T.ApellidoPaterno, ' ', T.ApellidoMaterno) AS NombreCompleto,C.Concepto,C.Fecha,C.Monto,C.Estatus FROM Cooperaciones C LEFT JOIN Titulares T ON (C.TitularID=T.TitularID) WHERE C.Estatus=? OR C.Estatus=? ORDER BY C.Fecha ASC; ";
$reutlSqlPT = ejecutarConsulta($sqlPagosT, ['Completada', 'Pendiente']);
while ($fila = mysqli_fetch_object($reutlSqlPT)) {
    $totalPagos += $fila->Estatus == "Completada" ? $fila->Monto : 0;
    $totalPendiente += $fila->Estatus == "Pendiente" ? $fila->Monto : 0;
    $classColor = $fila->Estatus == "Pendiente" ? "colorO" : "";
    $salidaPagos .= "
     <tr class='$classColor'>
        <td class='lineaDebajoR W250'>$fila->NombreCompleto</td>
        <td class='lineaDebajoR W300'>$fila->Concepto</td>
        <td class='lineaDebajoR W80 textCenter'>$fila->Fecha</td>
        <td class='lineaDebajoR W85 textRight'>$" . number_format($fila->Monto, 2) . "</td>
     </tr>
    ";
}
ob_start();
?>

<style>
    .colorO {
        background-color: #f5b7b1;
    }

    .colorG {
        background-color: #abebc6;
    }

    .mb15 {
        margin-bottom: 15px;
    }

    .W25 {
        width: 25px;
    }

    .W80 {
        width: 80px;
    }

    .W85 {
        width: 83px;
    }

    .W100 {
        width: 100px;
    }

    .W100 {
        width: 100px;
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

    .W350 {
        width: 350px;
    }

    .W400 {
        width: 400px;
    }


    .lineaDebajo {
        border-bottom: 2px solid #f7ca46;
        padding-bottom: 5px;
        display: inline-block;
    }

    .lineaDebajoR {
        border-bottom: 2px solid black;
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

    <table border="0" align="center" cellspacing=0 cellpadding=0 class="mb15">
        <tr>
            <th class="W400 textLeft tam20">Reporte general de transacciones.</th>
        </tr>
    </table>

    <table border="0" align="left" cellspacing=0 cellpadding=0 class="mb15">
        <tr>
            <th class="textCenter W150 fondoA">Titulo</th>
            <th class="textCenter W300 fondoA">Descripción</th>
            <th class="textCenter W100 fondoA">Fecha</th>
            <th class="textCenter W80 fondoA">Tipo</th>
            <th class="textCenter W80 fondoA">Monto</th>
        </tr>
        <?php echo $salidaTransacciones; ?>
        <tr>
            <td colspan="4" class="textRight"><b>Total de ingresos:</b></td>
            <td class="textRight"><?php echo "$" . number_format($totalTI, 2); ?></td>
        </tr>
        <tr>
            <td colspan="4" class="textRight"><b>Total de egresos:</b></td>
            <td class="textRight"><?php echo "$" . number_format($totalTE, 2); ?></td>
        </tr>
        <tr>
            <td colspan="4" class="textRight"><b>Total:</b> </td>
            <td class="textRight"><?php echo "$" . number_format(($totalTI - $totalTE), 2); ?></td>
        </tr>
    </table>
    <table border="0" align="left" cellspacing=0 cellpadding=0 class="mb15">
        <tr>
            <td class="W80 colorO"></td>
            <td class="W25 textCenter">---></td>
            <td class="">Titulares con saldo pendiente</td>
        </tr>
    </table>
    <table border="0" align="left" cellspacing=0 cellpadding=0 class="mb15">
        <tr>
            <th class="textCenter W250 fondoA">Nombre</th>
            <th class="textCenter W300 fondoA">Concepto</th>
            <th class="textCenter W80 fondoA">Fecha</th>
            <th class="textCenter W85 fondoA">Monto</th>
        </tr>
        <?php echo $salidaPagos; ?>
        <tr>
            <td colspan="3" class="textRight"><b>Saldo pendiente:</b></td>
            <td class="textRight"><?php echo "$" . number_format($totalPendiente, 2); ?></td>
        </tr>
        <tr>
            <td colspan="3" class="textRight"><b>Saldo pagado:</b></td>
            <td class="textRight"><?php echo "$" . number_format($totalPagos, 2); ?></td>
        </tr>
        <tr>
            <td colspan="3" class="textRight"><b>Total:</b></td>
            <td class="textRight"><?php echo "$" . number_format(($totalPagos + $totalPendiente), 2); ?></td>
        </tr>
    </table>
    <table border="0" align="left" cellspacing=0 cellpadding=0 class="mb15">
        <tr>
            <td class="textRight"><b>Total de egresos:</b></td>
            <td class="W80 textRight"><?php echo "$" . number_format($totalTE, 2); ?></td>
        </tr>
        <tr>
            <td class="textRight"><b>Saldo pendiente:</b></td>
            <td class="W80 textRight"><?php echo "$" . number_format($totalPendiente, 2); ?></td>
        </tr>
        <tr class="colorG">
            <td class="textRight"><b>Total de ingresos:</b></td>
            <td class="W80 textRight"><?php echo "$" . number_format($totalTI, 2); ?></td>
        </tr>
        <tr class="colorG">
            <td class="textRight"><b>Saldo pagado:</b></td>
            <td class="W80 textRight"><?php echo "$" . number_format($totalPagos, 2); ?></td>
        </tr>
        <tr>
            <td class="textRight"><b>Total en caja:</b></td>
            <td class="W80 textRight"><?php echo " $" . number_format((($totalTI - $totalTE) + $totalPagos), 2); ?></td>
        </tr>
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