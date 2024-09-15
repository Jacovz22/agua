<?php
include "../../global/conexion.php";
include '../../global/funtionG.php';

$idTransaccion = isset($_POST['idTransaccion']) ? limpiarDatos($_POST['idTransaccion']) : "";
$titulo = isset($_POST['titulo']) ? limpiarDatos($_POST['titulo']) : "";
$fecha = isset($_POST['fecha']) ? limpiarDatos($_POST['fecha']) : "";
$tipoT = isset($_POST['tipoT']) ? limpiarDatos($_POST['tipoT']) : "";
$montoT = isset($_POST['montoT']) ? limpiarDatos($_POST['montoT']) : "";
$descipcionT = isset($_POST['descipcionT']) ? limpiarDatos($_POST['descipcionT']) : "";

$options = "";
$datos = array();
switch ($_GET["op"]) {
    case 'saveTransacciones':
        try {
            if (empty($montoT) || !is_numeric($montoT)) {
                throw new Exception("El valor del monto no es válido. Asegúrate de ingresar un número." . $montoT, 400);
            }

            if ($idTransaccion == "") { // insert
                $sqlSave = "INSERT INTO Transacciones(Titulo, Monto, Fecha, Tipo, Descripcion, Estatus) VALUES (?,?,?,?,?,?)";
                $resultSqlSave = ejecutarInsert($sqlSave, [$titulo, $montoT, $fecha, $tipoT, $descipcionT, 'Activo']);
                if (!$resultSqlSave) {
                    throw new Exception("Ocurrió un error al guardar la transacción.", 409);
                }
                echo json_encode(
                    array(
                        "typeMessage" => array(
                            "type" => "success",
                            "title" => "Transacción guardada",
                            "code" => 200,
                            "idSave" => $resultSqlSave
                        ),
                        "description" => array(
                            "Message" => "La transacción ha sido registrada con éxito y ya está disponible en el sistema.",
                        )
                    ),
                    JSON_UNESCAPED_UNICODE
                );
            } else { // update
                $sqlUpdate = "UPDATE Transacciones SET Titulo = ?, Monto = ?, Fecha = ?, Tipo = ?, Descripcion = ? WHERE TransaccionID = ?";
                $resultSqlUpdate = ejecutarUpdate($sqlUpdate, [$titulo, $montoT, $fecha, $tipoT, $descipcionT, $idTransaccion]);
                if (!$resultSqlUpdate) {
                    throw new Exception("Ocurrió un error al actualizar la transacción.", 409);
                }
                echo json_encode(
                    array(
                        "typeMessage" => array(
                            "type" => "success",
                            "title" => "Actualización exitosa",
                            "code" => 200
                        ),
                        "description" => array(
                            "Message" => "La transacción ha sido actualizada con éxito.",
                        )
                    ),
                    JSON_UNESCAPED_UNICODE
                );
            }
        } catch (\Throwable $th) {
            echo json_encode(
                array(
                    "typeMessage" => array(
                        "type" => "warning",
                        "title" => "",
                        "code" => 409,
                    ),
                    "description" => array(
                        "message" => $th->getMessage()
                    )
                ),
                JSON_UNESCAPED_UNICODE
            );
        }
        break;
    case 'listTransacciones':
        $sqlSelect = ejecutarConsulta("SELECT * FROM Transacciones WHERE 1");

        while ($fila = mysqli_fetch_object($sqlSelect)) {

            $status = "";
            if ($fila->Estatus == "Activo") {
                $status = '<div class="badge text-white bg-success">Activo</div>';
                $botones = '
                    <button type="button" class="btn btn-primary btn-sm mr-2" title="Modificar" onclick="dataTransaccion(' . $fila->TransaccionID . ')"><i class="fas fa-edit"></i></button>
                    <button type="button" class="btn btn-danger btn-sm mr-2" title="Baja" onclick="updateStatusB(' . $fila->TransaccionID . ')"><i class="fas fa-times"></i></button>
                    ';
            } else {
                $status = '<div class="badge text-white bg-danger">Inactivo</div>';
                $botones = '
                    <button type="button" class="btn btn-outline-success btn-sm mr-2" title="Activar" onclick="updateStatusA(' . $fila->TransaccionID . ')" ><i class="fas fa-check"></i></button>
                    ';
            }
            $datos[] = array(
                "0" => "<div class='text-left'>$fila->Titulo</div>",
                "1" => "<div class='text-center'>$fila->Fecha</div>",
                "2" => "<div class='text-center'>$fila->Tipo</div>",
                "3" => "<div class='text-center'>$$fila->Monto</div>",
                "4" => "<div class='text-center'>$status</div>",
                "5" => "<div class='btn-group-custom text-center'>$botones</div>",

            );
        }

        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($datos), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($datos), //enviamos el total registros a visualizar
            "aaData" => $datos
        );
        //Enviamos los datos de la tabla 
        echo json_encode($results);

        break;
    case 'dataTransaccion':
        try {
            $sqlSelect = "SELECT Titulo, Monto, Fecha, Tipo, Descripcion FROM Transacciones WHERE TransaccionID=?";
            $resultSelec = ejecutarConsultaSimpleFila($sqlSelect, [$idTransaccion]);
            if (!$resultSelec) {
                throw new Exception("Ocurrió un error al consultar datos del usuario.", 409);
            }
            echo json_encode(
                array(
                    "typeMessage" => array(
                        "type" => "success",
                        "title" => "Consulta de datos exitosa",
                        "code" => 200,
                    ),
                    "description" => array(
                        "Message" => "Los datos de la transaccion se han consultado con éxito. Ahora puede actualizar la información como sea necesario.",
                    ),
                    "data" => $resultSelec
                ),
                JSON_UNESCAPED_UNICODE
            );
        } catch (\Throwable $th) {
            echo json_encode(
                array(
                    "typeMessage" => array(
                        "type" => "error",
                        "title" => "Error",
                        "code" => 409,
                    ),
                    "description" => array(
                        "message" => $th->getMessage()
                    )
                ),
                JSON_UNESCAPED_UNICODE
            );
        }
        break;
    case 'updateStatusA':
        try {
            $sqlUpdateT = "UPDATE Transacciones SET Estatus=? WHERE TransaccionID=?";
            $resultSqlUpdateT = ejecutarUpdate($sqlUpdateT, ["Activo", $idTransaccion]);
            if ($resultSqlUpdateT > 0) {
                echo json_encode(
                    array(
                        "typeMessage" => array(
                            "type" => "success",
                            "title" => "Activación de titular",
                            "code" => 200,
                        ),
                        "description" => array(
                            "Message" => "El titular ha sido activado correctamente. Sus registros han sido actualizados.",
                        ),
                        "data" => $resultSqlPersonal
                    ),
                    JSON_UNESCAPED_UNICODE
                );
            } else {
                throw new Exception("Ocurrió un error al intentar activar al titular. Ningún cambio ha sido realizado. Por favor, intenta nuevamente o contacta al soporte técnico.", 409);
            }
        } catch (\Throwable $th) {
            echo json_encode(
                array(
                    "typeMessage" => array(
                        "type" => "error",
                        "title" => "Error",
                        "code" => 409,
                    ),
                    "description" => array(
                        "message" => $th->getMessage()
                    )
                ),
                JSON_UNESCAPED_UNICODE
            );
        }
        break;

    case 'updateStatusB':
        try {
            $sqlUpdateT = "UPDATE Transacciones SET Estatus=? WHERE TransaccionID=?";
            $resultSqlUpdateT = ejecutarUpdate($sqlUpdateT, ["Cancelado", $idTransaccion]);
            if ($resultSqlUpdateT > 0) {
                echo json_encode(
                    array(
                        "typeMessage" => array(
                            "type" => "success",
                            "title" => "Activación de titular",
                            "code" => 200,
                        ),
                        "description" => array(
                            "Message" => "El titular ha sido activado correctamente. Sus registros han sido actualizados.",
                        ),
                        "data" => $resultSqlPersonal
                    ),
                    JSON_UNESCAPED_UNICODE
                );
            } else {
                throw new Exception("Ocurrió un error al intentar activar al titular. Ningún cambio ha sido realizado. Por favor, intenta nuevamente o contacta al soporte técnico.", 409);
            }
        } catch (\Throwable $th) {
            echo json_encode(
                array(
                    "typeMessage" => array(
                        "type" => "error",
                        "title" => "Error",
                        "code" => 409,
                    ),
                    "description" => array(
                        "message" => $th->getMessage()
                    )
                ),
                JSON_UNESCAPED_UNICODE
            );
        }
        break;
}
