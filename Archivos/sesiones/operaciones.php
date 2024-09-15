<?php
include "../../global/conexion.php";
include '../../global/funtionG.php';

$id = isset($_POST['id']) ? limpiarDatos($_POST['id']) : "";
$idReunion = isset($_POST['idReunion']) ? limpiarDatos($_POST['idReunion']) : "";
$titulo = isset($_POST['titulo']) ? limpiarDatos($_POST['titulo']) : "";
$Fecha = isset($_POST['Fecha']) ? limpiarDatos($_POST['Fecha']) : "";
$estatusR = isset($_POST['estatusR']) ? limpiarDatos($_POST['estatusR']) : "";
$obsPase = isset($_POST['obsPase']) ? limpiarDatos($_POST['obsPase']) : "";

$idR = isset($_POST['idR']) ? limpiarDatos($_POST['idR']) : "";
$listTitulares = isset($_POST['listTitulares']) ? limpiarDatos($_POST['listTitulares']) : "";
$montoCobro = isset($_POST['montoCobro']) ? limpiarDatos($_POST['montoCobro']) : "";
$datos = array();
$options = "";
switch ($_GET["op"]) {
    case 'saveReuniones':
        try {
            // validamos si guardamos
            if ($idReunion == "") {
                $sqlSave = "INSERT INTO Reuniones(Fecha, Titulo, Estatus) VALUES (?,?,?)";
                $resultSqlSave = ejecutarInsert($sqlSave, [$Fecha, $titulo, $estatusR]);
                if (!$resultSqlSave) {
                    throw new Exception("Ocurrió un error al guardar la reunión. Por favor, intenta nuevamente o contacta al soporte técnico.", 409);
                }
                echo json_encode(
                    array(
                        "typeMessage" => array(
                            "type" => "success",
                            "title" => "Reunión guardada exitosamente",
                            "code" => 200,
                        ),
                        "description" => array(
                            "Message" => "La reunión ha sido guardada correctamente y está disponible en el sistema.",
                        ),
                        "data" => $resultSqlSave
                    ),
                    JSON_UNESCAPED_UNICODE
                );
            } else {
                // SQL para actualizar una reunión
                $sqlUpdate = "UPDATE Reuniones SET Fecha = ?, Titulo = ?, Estatus = ? WHERE ReunionID = ?";
                $resultSqlUpdate = ejecutarUpdate($sqlUpdate, [$Fecha, $titulo, $estatusR, $idReunion]);

                if (!$resultSqlUpdate) {
                    throw new Exception("Ocurrió un error al actualizar la reunión. Por favor, intenta nuevamente o contacta al soporte técnico." . $resultSqlUpdate, 409);
                }

                echo json_encode(
                    array(
                        "typeMessage" => array(
                            "type" => "success",
                            "title" => "Reunión actualizada exitosamente",
                            "code" => 200,
                        ),
                        "description" => array(
                            "Message" => "La reunión ha sido actualizada correctamente y los cambios están reflejados en el sistema.",
                        ),
                        "data" => $resultSqlUpdate
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
    case 'tblReuniones';
        $sqlReuniones = ejecutarConsulta("SELECT * FROM Reuniones");

        while ($fila = mysqli_fetch_object($sqlReuniones)) {
            $sqlCountPart = "SELECT COUNT(*) as count FROM Asistencias_Reuniones WHERE ReunionID=?";
            $resultsCount = ejecutarConsultaSimpleFila($sqlCountPart, [$fila->ReunionID]);
            $botones = '
                <button type="button" class="btn btn-success btn-sm mr-2" onclick="dataReuniones(' . $fila->ReunionID . ');"><i class="fas fa-edit"></i></button>
                ';
            if ($fila->Estatus == "Programada") {
                $status = '<div class="badge text-white bg-info">Programada</div>';
            } else if ($fila->Estatus == "En Curso") {
                $status = '<div class="badge text-white bg-secondary">En Curso</div>';
                $botones .= '
                <button type="button" class="btn btn-primary btn-sm mr-2" onclick="listTitulares();pasarIdR(' . $fila->ReunionID . ');"><i class="fas fa-user-check"></i></button>
                ';
                $botones .= $resultsCount['count'] > 0 ? '<a href="../Archivos/sesiones/asistenciasPdf.php?idList=' . base64_encode($fila->ReunionID) . '" target="_blank" rel="noopener noreferrer" type="button" class="btn btn-danger btn-sm mr-2" title="Reporte de asistencia"><i class="fas fa-file-pdf"></i></a>' : '';
            } else if ($fila->Estatus == "Concluida") {
                $status = '<div class="badge text-white bg-warning">Concluida</div>';
                $botones .= '
                <button type="button" class="btn btn-primary btn-sm mr-2" onclick="listTitulares();pasarIdR(' . $fila->ReunionID . ');"><i class="fas fa-user-check"></i></button>
                ';
                $botones .= $resultsCount['count'] > 0 ? '<a href="../Archivos/sesiones/asistenciasPdf.php?idList=' . base64_encode($fila->ReunionID) . '" target="_blank" rel="noopener noreferrer" type="button" class="btn btn-danger btn-sm mr-2" title="Reporte de asistencia"><i class="fas fa-file-pdf"></i></a>' : '';
                $botones .= '
                    <button type="button" class="btn btn-info btn-sm mr-2" onclick="solicitarPagoF(' . $fila->ReunionID . ')"><i class="fas fa-file-invoice-dollar"></i></button>
                ';
            } else if ($fila->Estatus == "Cancelada") {
                $status = '<div class="badge text-white bg-danger">Cancelada</div>';
            } else {
                $status = '<div class="badge text-white bg-danger">Inactivo</div>';
            }
            $datos[] = array(
                "0" => "<div class='text-left'>$fila->Titulo</div>",
                "1" => "<div class='text-center'>$fila->Fecha</div>",
                "2" => "<div class='text-center'>$status</div>",
                "3" => "<div class='btn-group-custom text-left'>$botones</div>",

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

    case 'listTitulares':
        try {
            $sqlSave = "SELECT TitularID, CONCAT(NombreTitular, ' ', ApellidoPaterno, ' ', ApellidoMaterno) AS NombreCompleto FROM Titulares WHERE EstatusTitular=?";
            $resultSqlSave = ejecutarConsulta($sqlSave, ["Activo"]);
            if (!$resultSqlSave) {
                throw new Exception("Ocurrió un error al consultar las direcciones", 409);
            }
            while ($fila = mysqli_fetch_object($resultSqlSave)) {
                $options .= "<option value='$fila->TitularID'>$fila->NombreCompleto</option>";
            }
            echo json_encode(
                array(
                    "typeMessage" => array(
                        "type" => "success",
                        "title" => "Guardado",
                        "code" => 200,
                    ),
                    "description" => array(
                        "Message" => "",
                    ),
                    "options" => $options
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
    case 'saveCheckList':
        try {
            // Validamos que ya no existe en la misma reunion el Titular
            $slqCount = "SELECT COUNT(*) AS count FROM Asistencias_Reuniones WHERE ReunionID=? AND TitularID=?";
            $resultSqlCount = ejecutarConsultaSimpleFila($slqCount, [$idR, $listTitulares]);
            if (!$resultSqlCount) {
                throw new Exception("Ocurrió un error al consultar el titular.", 409);
            }
            if ($resultSqlCount["count"] == 0) { // aun no existe
                $sqlSaveTitular = "INSERT INTO Asistencias_Reuniones(ReunionID, TitularID,descripcion) VALUES (?,?,?)";
                $resultSqlSave = ejecutarInsert($sqlSaveTitular, [$idR, $listTitulares, $obsPase]);
                if ($resultSqlSave) {
                    echo json_encode(
                        array(
                            "typeMessage" => array(
                                "type" => "success",
                                "title" => "Titular agregado con exito.",
                                "code" => 200,
                            ),
                            "description" => array(
                                "Message" => "El titular ha sido agregado correctamente y ya está disponible en el sistema.",
                            )
                        ),
                        JSON_UNESCAPED_UNICODE
                    );
                } else {
                    echo json_encode(
                        array(
                            "typeMessage" => array(
                                "type" => "warning",
                                "title" => "Error al guardar titular",
                                "code" => 201,
                            ),
                            "description" => array(
                                "Message" => "Hubo un error al intentar guardar al titular. Por favor, verifica los datos ingresados e intenta nuevamente. Si el problema persiste, contacta al administrador del sistema.",
                                "param" => $resultSqlSave
                            )
                        ),
                        JSON_UNESCAPED_UNICODE
                    );
                }
            } else {
                echo json_encode(
                    array(
                        "typeMessage" => array(
                            "type" => "warning",
                            "title" => "Titular ya existente",
                            "code" => 201,
                        ),
                        "description" => array(
                            "Message" => "El titular que estás intentando guardar ya existe. Por favor, verifica los datos ingresados e intenta con un nuevo titular. Si necesitas más ayuda o crees que esto es un error, contacta al administrador del sistema.",
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

    case 'dataListCheckT':
        try {
            $sqlSelect = "SELECT AR.idAsistencia,CONCAT(T.NombreTitular, ' ', T.ApellidoPaterno, ' ', T.ApellidoMaterno) AS NombreCompleto FROM Asistencias_Reuniones AR LEFT JOIN Titulares T ON (AR.TitularID=T.TitularID) WHERE AR.ReunionID=?; ";
            $resultSqlSelect = ejecutarConsulta($sqlSelect, [$id]);

            while ($fila = mysqli_fetch_object($resultSqlSelect)) {
                $options .= "<li class='list-group-item d-flex justify-content-between align-items-center'> $fila->NombreCompleto <button type='button' class='btn btn-danger btn-sm' onclick='deleteAsistencia($fila->idAsistencia,$id)'><i class='fas fa-times'></i></button>
</li>";
            }
            echo json_encode(
                array(
                    "typeMessage" => array(
                        "type" => "success",
                        "title" => "Guardado",
                        "code" => 200,
                    ),
                    "description" => array(
                        "Message" => "",
                    ),
                    "options" => $options
                ),
                JSON_UNESCAPED_UNICODE
            );
        } catch (\Throwable $th) {
            echo json_encode(
                array(
                    "typeMessage" => array(
                        "type" => "warning",
                        "title" => "Ocurrio un error al en la lista de asistencia",
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
    case 'dataReuniones':
        try {
            $sqlSelect = "SELECT Fecha, Titulo, Estatus FROM Reuniones WHERE ReunionID=?";
            $resultSelec = ejecutarConsultaSimpleFila($sqlSelect, [$idReunion]);
            if (!$resultSelec) {
                throw new Exception("Ocurrió un error al consultar datos de la reunion.", 409);
            }
            echo json_encode(
                array(
                    "typeMessage" => array(
                        "type" => "success",
                        "title" => "Consulta de datos exitosa",
                        "code" => 200,
                    ),
                    "description" => array(
                        "Message" => "Los datos de la reunion se han consultado con éxito. Ahora puede actualizar la información como sea necesario.",
                    ),
                    "data" => $resultSelec
                ),
                JSON_UNESCAPED_UNICODE
            );
        } catch (\Throwable $th) {
            echo json_encode(
                array(
                    "typeMessage" => array(
                        "type" => "warning",
                        "title" => "Ocurrio un error al consultar datos",
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
    case 'deleteAsistencia':
        try {
            $sqlDelete = "DELETE FROM Asistencias_Reuniones WHERE idAsistencia=?";
            $resultDelete = ejecutarDelete($sqlDelete, [$id]);

            if ($resultDelete > 0) {
                echo json_encode(
                    array(
                        "typeMessage" => array(
                            "type" => "success",
                            "title" => "Eliminación exitosa",
                            "code" => 200,
                        ),
                        "description" => array(
                            "Message" => "El titular ha sido eliminado exitosamente de la asistencia en la faena.",
                        )
                    ),
                    JSON_UNESCAPED_UNICODE
                );
            } else {
                echo json_encode(
                    array(
                        "typeMessage" => array(
                            "type" => "error",
                            "title" => "Error al eliminar",
                            "code" => 500,
                        ),
                        "description" => array(
                            "Message" => "Ocurrió un error al intentar eliminar al titular de la asistencia en la faena. Por favor, intente nuevamente. Si el problema persiste, contacte al administrador.",
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
                        "title" => "Ocurrio un error al consultar datos",
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
    case 'solicitarPF':
        try {
            // obtener fecha de la faena
            $sqlFechaF = "SELECT Fecha FROM Reuniones WHERE ReunionID=?;";
            $resultFechaF = ejecutarConsultaSimpleFila($sqlFechaF, [$id]);

            // consultamos los titulares activos
            $sqlTitulares = 'SELECT TitularID FROM Titulares WHERE EstatusTitular=?;';
            $resultTitulares = ejecutarConsulta($sqlTitulares, ['Activo']);

            while ($fila = mysqli_fetch_object($resultTitulares)) {
                // validamos si existe en la reunion o faena
                $sqlCountF = "SELECT COUNT(*) AS count FROM Asistencias_Reuniones WHERE TitularID = ? AND ReunionID = ?;";
                $resultCountT = ejecutarConsultaSimpleFila($sqlCountF, [$fila->TitularID, $id]);

                // Si no ha asistido, procedemos a verificar en la tabla Cooperaciones
                if ($resultCountT["count"] == 0) {
                    // Verificamos si ya existe un registro en la tabla Cooperaciones con los mismos datos y estatus Pendiente o Completada
                    $sqlCheckCooperation = "SELECT COUNT(*) AS count 
                                FROM Cooperaciones 
                                WHERE TitularID = ? 
                                AND Monto = ? 
                                AND Fecha = ? 
                                AND Concepto = ? 
                                AND Estatus IN ('Pendiente', 'Completada');";
                    $resultCheckCooperation = ejecutarConsultaSimpleFila($sqlCheckCooperation, [$fila->TitularID, $montoCobro, $resultFechaF["Fecha"], "PAGO DE FAENA"]);

                    // Si no existe el registro en Cooperaciones, procedemos a insertar
                    if ($resultCheckCooperation["count"] == 0) {
                        // insertamos la deuda al titular
                        $sqlInsertD = "INSERT INTO Cooperaciones(TitularID, Monto, Fecha, Estatus, Concepto) VALUES (?,?,?,?,?)";
                        $sqlResutlInsertD = ejecutarInsert($sqlInsertD, [$fila->TitularID, $montoCobro, $resultFechaF["Fecha"], "Pendiente", "PAGO DE FAENA"]);

                        if (!$sqlResutlInsertD) {
                            throw new Exception("Ocurrió un error al solicitar pago.", 409);
                        }
                    }
                }
            }

            // Mensaje final de éxito si los pagos fueron solicitados correctamente
            echo json_encode(
                array(
                    "typeMessage" => array(
                        "type" => "success",
                        "title" => "Solicitud de pago exitosa",
                        "code" => 200,
                    ),
                    "description" => array(
                        "Message" => "A los titulares que no asistieron se les aplicó el cargo correspondiente.",
                    )
                ),
                JSON_UNESCAPED_UNICODE
            );
        } catch (\Throwable $th) {
            echo json_encode(
                array(
                    "typeMessage" => array(
                        "type" => "warning",
                        "title" => "Ocurrio un error al consultar datos",
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
