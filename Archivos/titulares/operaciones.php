<?php
include "../../global/conexion.php";
include '../../global/funtionG.php';

$TitularID = isset($_POST['TitularID']) ? limpiarDatos($_POST['TitularID']) : "";
$nombre = isset($_POST['nombre']) ? limpiarDatos($_POST['nombre']) : "";
$apellidoP = isset($_POST['apellidoP']) ? limpiarDatos($_POST['apellidoP']) : "";
$apellidoM = isset($_POST['apellidoM']) ? limpiarDatos($_POST['apellidoM']) : "";
$tomaA = isset($_POST['tomaA']) ? limpiarDatos($_POST['tomaA']) : "";
$correo = isset($_POST['correo']) ? limpiarDatos($_POST['correo']) : "";
$celular = isset($_POST['celular']) ? limpiarDatos($_POST['celular']) : "";
$idDireccionTitular = isset($_POST['idDireccionTitular']) ? limpiarDatos($_POST['idDireccionTitular']) : "";
$idDireccionT = isset($_POST['idDireccionT']) ? limpiarDatos($_POST['idDireccionT']) : "";
$obs = isset($_POST['obs']) ? limpiarDatos($_POST['obs']) : "";

//direccion
$idDireccionN = isset($_POST['idDireccionN']) ? limpiarDatos($_POST['idDireccionN']) : "";
$cp = isset($_POST['cp']) ? limpiarDatos($_POST['cp']) : "";
$colonia = isset($_POST['colonia']) ? limpiarDatos($_POST['colonia']) : "";
$calle = isset($_POST['calle']) ? limpiarDatos($_POST['calle']) : "";
$nInterior = isset($_POST['nInterior']) ? limpiarDatos($_POST['nInterior']) : "";
$nExterior = isset($_POST['nExterior']) ? limpiarDatos($_POST['nExterior']) : "";

//Pagos
$idTitularP = isset($_POST['idTitularP']) ? limpiarDatos($_POST['idTitularP']) : "";
$idPago = isset($_POST['idPago']) ? limpiarDatos($_POST['idPago']) : "";
$concepto = isset($_POST['concepto']) ? limpiarDatos($_POST['concepto']) : "";
$fechaP = isset($_POST['fechaP']) ? limpiarDatos($_POST['fechaP']) : "";
$montoP = isset($_POST['montoP']) ? limpiarDatos($_POST['montoP']) : "";
$estatusP = isset($_POST['estatusP']) ? limpiarDatos($_POST['estatusP']) : "";

//Pagos parciales
$idPagoP = isset($_POST['idPagoP']) ? limpiarDatos($_POST['idPagoP']) : "";
$idPagoPar = isset($_POST['idPagoPar']) ? limpiarDatos($_POST['idPagoPar']) : "";
$conceptoPar = isset($_POST['conceptoPar']) ? limpiarDatos($_POST['conceptoPar']) : "";
$fechaPar = isset($_POST['fechaPar']) ? limpiarDatos($_POST['fechaPar']) : "";
$montoPar = isset($_POST['montoPar']) ? limpiarDatos($_POST['montoPar']) : "";
$metodoPP = isset($_POST['metodoPP']) ? limpiarDatos($_POST['metodoPP']) : "";
$estatusPP = isset($_POST['estatusPP']) ? limpiarDatos($_POST['estatusPP']) : "";

$options = "";
$datos = array();
switch ($_GET["op"]) {
    case 'saveTitular':
        try {
            if ($TitularID == "") { //Insert
                $sqlCount = "SELECT COUNT(*) AS count FROM Titulares WHERE NombreTitular=? AND ApellidoPaterno=? AND ApellidoMaterno=?";
                $resultSqlCount = ejecutarConsultaSimpleFila($sqlCount, [$nombre, $apellidoP, $apellidoM]);
                if (!$resultSqlCount) {
                    throw new Exception("Ocurrió un error al consultar el titular.", 409);
                }
                if ($resultSqlCount["count"] == 0) { // aun no existe
                    // Inicializa la consulta base
                    $sqlSaveTitular = "INSERT INTO Titulares(NombreTitular, ApellidoPaterno, ApellidoMaterno, Telefono, Email, TieneTomaAgua, Observaciones, EstatusTitular";

                    // Array para los valores de los parámetros
                    $params = [$nombre, $apellidoP, $apellidoM, $celular, $correo, $tomaA, $obs, "Activo"];

                    // Verifica si idDireccionTitular tiene valor
                    if (!empty($idDireccionTitular)) {
                        $sqlSaveTitular .= ", DireccionID";
                        $params[] = $idDireccionTitular;
                    }

                    // Verifica si idDireccionT tiene valor
                    if (!empty($idDireccionT)) {
                        $sqlSaveTitular .= ", DireccionTomaID";
                        $params[] = $idDireccionT;
                    }

                    // Completa la consulta
                    $sqlSaveTitular .= ") VALUES (" . str_repeat('?,', count($params) - 1) . "?)";

                    // Ejecuta la consulta
                    $resultSqlSave = ejecutarInsert($sqlSaveTitular, $params);

                    if ($resultSqlSave) {
                        echo json_encode(
                            array(
                                "typeMessage" => array(
                                    "type" => "success",
                                    "title" => "Titular creado exitosamente",
                                    "code" => 200,
                                ),
                                "description" => array(
                                    "Message" => "El titular ha sido creado correctamente y ya está disponible en el sistema.",
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
                                    "Message" => "Hubo un error al intentar crear al titular. Por favor, verifica los datos ingresados e intenta nuevamente. Si el problema persiste, contacta al administrador del sistema.",
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
                                "Message" => "El titular que estás intentando guardar ya existe en el sistema. Por favor, verifica los datos ingresados e intenta con un nuevo titular. Si necesitas más ayuda o crees que esto es un error, contacta al administrador del sistema.",
                            )
                        ),
                        JSON_UNESCAPED_UNICODE
                    );
                }
            } else { // Update
                // Inicializa la consulta base
                $sqlUpdateTitular = "UPDATE Titulares SET NombreTitular = ?, ApellidoPaterno = ?, ApellidoMaterno = ?, Telefono = ?, Email = ?, TieneTomaAgua = ?, Observaciones = ?";

                // Array para los valores de los parámetros
                $params = [$nombre, $apellidoP, $apellidoM, $celular, $correo, $tomaA, $obs];

                // Verifica si idDireccionTitular tiene valor
                if (!empty($idDireccionTitular)) {
                    $sqlUpdateTitular .= ", DireccionID = ?";
                    $params[] = $idDireccionTitular;
                }

                // Verifica si idDireccionT tiene valor
                if (!empty($idDireccionT)) {
                    $sqlUpdateTitular .= ", DireccionTomaID = ?";
                    $params[] = $idDireccionT;
                }

                // Añade la condición WHERE para identificar al titular
                $sqlUpdateTitular .= " WHERE TitularID = ?";
                $params[] = $TitularID; // Asegúrate de tener el ID del titular que estás actualizando

                // Ejecuta la consulta
                $resultSqlUpdate = ejecutarUpdate($sqlUpdateTitular, $params);

                if ($resultSqlUpdate) {
                    echo json_encode(
                        array(
                            "typeMessage" => array(
                                "type" => "success",
                                "title" => "Titular actualizado exitosamente",
                                "code" => 200,
                            ),
                            "description" => array(
                                "Message" => "El titular ha sido actualizado correctamente y los cambios ya están disponibles en el sistema.",

                            )
                        ),
                        JSON_UNESCAPED_UNICODE
                    );
                } else {
                    echo json_encode(
                        array(
                            "typeMessage" => array(
                                "type" => "warning",
                                "title" => "No se actualizo titular",
                                "code" => 500,
                            ),
                            "description" => array(
                                "Message" => "Hubo un error al intentar actualizar al titular. Por favor, verifica los datos ingresados e intenta nuevamente. Si el problema persiste, contacta al administrador del sistema.",

                            )
                        ),
                        JSON_UNESCAPED_UNICODE
                    );
                }
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
    case 'saveAdrress':
        try {
            // Validamos si existe la direccion
            if ($idDireccionN == "") { // insert
                $sqlSave = "INSERT INTO Direcciones(Calle, NumeroExterior, NumeroInterior, CodigoPostal, Colonia, Municipio, Estado, Pais) VALUES (?,?,?,?,?,?,?,?)";
                $resultSqlSave = ejecutarInsert($sqlSave, [$calle, $nExterior, $nInterior, $cp, $colonia, 'HUEYAPAN', 'PUEBLA', 'MEXICO']);
                if (!$resultSqlSave) {
                    throw new Exception("Ocurrió un error al guardar la dirección.", 409);
                }
                echo json_encode(
                    array(
                        "typeMessage" => array(
                            "type" => "success",
                            "title" => "Guardado",
                            "code" => 200,
                            "idSave" => $resultSqlSave
                        ),
                        "description" => array(
                            "Message" => "Dirección registrada con éxito.",

                        )
                    ),
                    JSON_UNESCAPED_UNICODE
                );
            } else { // update
                $sqlUpdate = "UPDATE Direcciones SET Calle=?,NumeroExterior=?,NumeroInterior=?,CodigoPostal=?,Colonia=? WHERE DireccionID=?";
                $resultSqlUpdate = ejecutarUpdate($sqlUpdate, [$calle, $nExterior, $nInterior, $cp, $colonia, $idDireccionN]);
                if (!$resultSqlUpdate) {
                    throw new Exception("No se encontraron actualizaciones.", 409);
                }
                echo json_encode(
                    array(
                        "typeMessage" => array(
                            "type" => "success",
                            "title" => "Actualizado",
                            "code" => 200,
                            "idSave" => $idDireccionN
                        ),
                        "description" => array(
                            "Message" => "Dirección fue actualizado con éxito.",

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
    case 'searchAddress':
        try {
            $options .= "<option value=''>-----------</option>";
            $sqlSave = "SELECT DireccionID,CONCAT_WS(' ', Calle, CONCAT('No.', NumeroExterior), IF(NumeroInterior IS NOT NULL AND NumeroInterior != '', CONCAT('Int.', NumeroInterior), NULL), Colonia, CodigoPostal, Municipio, Estado, Pais) AS DireccionCompleta FROM Direcciones;";
            $resultSqlSave = ejecutarConsulta($sqlSave);
            if (!$resultSqlSave) {
                throw new Exception("Ocurrió un error al consultar las direcciones", 409);
            }
            while ($fila = mysqli_fetch_object($resultSqlSave)) {
                $options .= "<option value='$fila->DireccionID'>$fila->DireccionCompleta</option>";
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
                        "options" => $options

                    )
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
    case 'searchAddressId':
        try {
            $sqlSelect = "SELECT Calle, NumeroExterior, NumeroInterior, CodigoPostal, Colonia FROM Direcciones WHERE DireccionID=?";
            $resultSqlSelect = ejecutarConsultaSimpleFila($sqlSelect, [$idDireccionN]);
            if (!$resultSqlSelect) {
                throw new Exception("Ocurrió un error al consultar las direcciones." . $idDireccionN, 409);
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
                        "resutl" => $resultSqlSelect

                    )
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
    case 'listTitulares';
        $sqlSelect = ejecutarConsulta("SELECT TitularID, UsuarioID, CONCAT(NombreTitular, ' ', ApellidoPaterno, ' ', ApellidoMaterno) AS NombreCompleto, Telefono,TieneTomaAgua, DireccionTomaID,EstatusTitular  FROM Titulares;");

        while ($fila = mysqli_fetch_object($sqlSelect)) {

            $iconStatusA = $fila->TieneTomaAgua == 1 ? '<i class="fas fa-check-double text-success"></i>' : '<i class="fas fa-times text-danger"></i>';
            if ($fila->EstatusTitular == "Activo") {
                $status = '<div class="badge text-white bg-success">Activo</div>';
                $botones = '
                    <button type="button" class="btn btn-primary btn-sm" title="Modificar" onclick="dataTitular(' . $fila->TitularID . ')"><i class="fas fa-user-edit"></i></button>
                    <button type="button" class="btn btn-danger btn-sm" title="Baja" onclick="updateStatusI(' . $fila->TitularID . ')"><i class="fas fa-user-times"></i></button>
                    <button type="button" class="btn btn-info btn-sm" title="Registrar pagos" onclick="modalPagos(' . $fila->TitularID . ')"><i class="fas fa-money-check-alt"></i></button>
                ';
            } else {
                $status = '<div class="badge text-white bg-danger">Inactivo</div>';
                $botones = '
                    <button type="button" class="btn btn-outline-success btn-sm" title="Reactivar Empleado" onclick="updateStatusA(' . $fila->TitularID . ')"><i class="fas fa-user-check"></i></button>
                ';
            }
            $botones .= '<a href="../Archivos/titulares/historialPdf.php?id=' . base64_encode($fila->TitularID) . '" target="_blank" rel="noopener noreferrer" type="button" class="btn btn-danger btn-sm mr-2" title="Reporte de asistencia"><i class="fas fa-file-pdf"></i></a>';

            $datos[] = array(
                "0" => "<div class='text-left'>$fila->NombreCompleto</div>",
                "1" => "<div class='text-left'>$fila->Telefono</div>",
                "2" => "<div class='text-center'>$iconStatusA</div>",
                "3" => "<div class='text-center'>$status</div>",
                "4" => "<div class='btn-group-custom text-center'>$botones</div>",
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
    case 'updateStatusI':
        try {
            $sqlUpdateT = "UPDATE Titulares SET EstatusTitular=? WHERE TitularID=?";
            $resultSqlUpdateT = ejecutarUpdate($sqlUpdateT, ["Inactivo", $TitularID]);
            if ($resultSqlUpdateT > 0) {
                echo json_encode(
                    array(
                        "typeMessage" => array(
                            "type" => "success",
                            "title" => "Baja de titular",
                            "code" => 200,
                        ),
                        "description" => array(
                            "Message" => "El titular han sido dados de baja correctamente. Sus registros han sido actualizados.",
                        ),
                        "data" => $resultSqlPersonal
                    ),
                    JSON_UNESCAPED_UNICODE
                );
            } else {
                throw new Exception("Ocurrió un error al intentar dar de baja al titular. Ningún cambio ha sido realizado. Por favor, intenta nuevamente o contacta al soporte técnico.", 409);
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
    case 'updateStatusA':
        try {
            $sqlUpdateT = "UPDATE Titulares SET EstatusTitular=? WHERE TitularID=?";
            $resultSqlUpdateT = ejecutarUpdate($sqlUpdateT, ["Activo", $TitularID]);
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
    case 'dataTitular':
        try {
            $sqlSelectUser = "SELECT NombreTitular, ApellidoPaterno, ApellidoMaterno, DireccionID, Telefono, Email, TieneTomaAgua, DireccionTomaID, Observaciones FROM Titulares WHERE TitularID=?";
            $resultSelectUser = ejecutarConsultaSimpleFila($sqlSelectUser, [$TitularID]);
            if (!$resultSelectUser) {
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
                        "Message" => "Los datos del titular se han consultado con éxito. Ahora puede actualizar la información como sea necesario.",
                    ),
                    "data" => $resultSelectUser
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
    case 'guardarPago':
        try {
            //Validamos si es un insert o update
            if ($idPago == "") {
                $sqlInsert = "INSERT INTO Cooperaciones(TitularID, Monto, Fecha, Estatus, Concepto) VALUES (?,?,?,?,?)";
                $resutlInsert = ejecutarInsert($sqlInsert, [$idTitularP, $montoP, $fechaP, $estatusP, $concepto]);

                if ($resutlInsert) {
                    echo json_encode(
                        array(
                            "typeMessage" => array(
                                "type" => "success",
                                "title" => "Pago registrado exitosamente",
                                "code" => 200,
                            ),
                            "description" => array(
                                "Message" => "El pago ha sido registrado correctamente y ya está disponible en el sistema.",
                            )
                        ),
                        JSON_UNESCAPED_UNICODE
                    );
                } else {
                    echo json_encode(
                        array(
                            "typeMessage" => array(
                                "type" => "warning",
                                "title" => "Error al registrar pago",
                                "code" => 201,
                            ),
                            "description" => array(
                                "Message" => "Hubo un error al intentar registrar el pago. Por favor, verifica los datos ingresados e intenta nuevamente. Si el problema persiste, contacta al administrador del sistema.",
                            )
                        ),
                        JSON_UNESCAPED_UNICODE
                    );
                }
            } else {
                $sqlUpdate = "UPDATE Cooperaciones SET Monto = ?, Fecha = ?, Estatus = ?, Concepto = ? WHERE CooperacionID = ?";
                $resultSqlUpdate = ejecutarUpdate($sqlUpdate, [$montoP, $fechaP, $estatusP, $concepto, $idPago]);

                if ($resultSqlUpdate > 0) {
                    echo json_encode(
                        array(
                            "typeMessage" => array(
                                "type" => "success",
                                "title" => "Pago actualizado exitosamente",
                                "code" => 200,
                            ),
                            "description" => array(
                                "Message" => "El pago ha sido actualizado correctamente en el sistema.",
                            )
                        ),
                        JSON_UNESCAPED_UNICODE
                    );
                } else {
                    echo json_encode(
                        array(
                            "typeMessage" => array(
                                "type" => "warning",
                                "title" => "Error al actualizar el pago",
                                "code" => 201,
                            ),
                            "description" => array(
                                "Message" => "No se realizó ningún cambio. Por favor, verifica los datos ingresados e intenta nuevamente. Si el problema persiste, contacta al administrador del sistema.",
                            )
                        ),
                        JSON_UNESCAPED_UNICODE
                    );
                }
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
    case 'listPagos':
        $sqlSelect = "SELECT * FROM Cooperaciones WHERE TitularID=?";
        $resultSelect = ejecutarConsulta($sqlSelect, [$TitularID]);

        while ($fila = mysqli_fetch_object($resultSelect)) {
            $botones = "";
            $status = "";
            if ($fila->Estatus == "Activa") {
                $status = '<div class="badge text-white bg-primary">Activa</div>';
                $botones = '
                    <button type="button" class="btn btn-primary btn-sm mr-2" title="Modificar" onclick="dataPagos(' . $fila->CooperacionID . ')"><i class="fas fa-edit"></i></button>
                    <button type="button" class="btn btn-info btn-sm" title="Registrar pagas" onclick="mostrarPagosPar(' . $fila->CooperacionID . ')"><i class="fas fa-hand-holding-usd"></i></button>
                    ';
            } else if ($fila->Estatus == "Pendiente") {
                $status = '<div class="badge text-white bg-secondary">Pendiente</div>';
                $botones = '
                    <button type="button" class="btn btn-primary btn-sm mr-2" title="Modificar" onclick="dataPagos(' . $fila->CooperacionID . ')"><i class="fas fa-edit"></i></button>
                    <button type="button" class="btn btn-info btn-sm" title="Registrar pagas" onclick="mostrarPagosPar(' . $fila->CooperacionID . ')"><i class="fas fa-hand-holding-usd"></i></button>
                    ';
            } else if ($fila->Estatus == "Completada") {
                $status = '<div class="badge text-white bg-success">Completada</div>';
                $botones = '
                    <button type="button" class="btn btn-primary btn-sm mr-2" title="Modificar" onclick="dataPagos(' . $fila->CooperacionID . ')"><i class="fas fa-edit"></i></button>
                    <button type="button" class="btn btn-info btn-sm" title="Registrar pagas" onclick="mostrarPagosPar(' . $fila->CooperacionID . ')"><i class="fas fa-hand-holding-usd"></i></button>
                    ';
            }
            $datos[] = array(
                "0" => "<div class='text-left'>$fila->Concepto</div>",
                "1" => "<div class='text-center'>$fila->Fecha</div>",
                "2" => "<div class='text-center'>$$fila->Monto</div>",
                "3" => "<div class='text-center'>$status</div>",
                "4" => "<div class='btn-group-custom text-center'>$botones</div>",

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
    case 'dataPagos':
        try {
            $sqlSelectPagos = "SELECT  Monto, Fecha, Estatus, Concepto FROM Cooperaciones WHERE CooperacionID=?";
            $resultSelectPagos = ejecutarConsultaSimpleFila($sqlSelectPagos, [$idPago]);
            if (!$resultSelectPagos) {
                throw new Exception("Ocurrió un error al consultar datos del pago.", 409);
            }
            echo json_encode(
                array(
                    "typeMessage" => array(
                        "type" => "success",
                        "title" => "Consulta de datos exitosa",
                        "code" => 200,
                    ),
                    "description" => array(
                        "Message" => "Los datos del pago se han consultado con éxito. Ahora puede actualizar la información como sea necesario.",
                    ),
                    "data" => $resultSelectPagos
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
    case 'guardarPagoPar':
        try {
            if ($idPagoPar == "") { // insert
                $sqlInsert = "INSERT INTO Pagos_Cooperacion(CooperacionID, Monto, Fecha, MetodoPago, Concepto, Estatus) VALUES (?,?,?,?,?,?)";
                $resutlInsert = ejecutarInsert($sqlInsert, [$idPagoP, $montoPar, $fechaPar, $metodoPP, $conceptoPar, $estatusPP]);

                if ($resutlInsert) {
                    echo json_encode(
                        array(
                            "typeMessage" => array(
                                "type" => "success",
                                "title" => "Pago parcial registrado exitosamente",
                                "code" => 200,
                            ),
                            "description" => array(
                                "Message" => "El pago parcial ha sido registrado correctamente y ya está disponible en el sistema.",
                            )
                        ),
                        JSON_UNESCAPED_UNICODE
                    );
                } else {
                    echo json_encode(
                        array(
                            "typeMessage" => array(
                                "type" => "warning",
                                "title" => "Error al registrar pago parcial",
                                "code" => 201,
                            ),
                            "description" => array(
                                "Message" => "Hubo un error al intentar registrar el pago parcial. Por favor, verifica los datos ingresados e intenta nuevamente. Si el problema persiste, contacta al administrador del sistema.",
                            )
                        ),
                        JSON_UNESCAPED_UNICODE
                    );
                }
            } else { // update
                $sqlUpdate = "UPDATE Pagos_Cooperacion SET Monto = ?, Fecha = ?, MetodoPago = ?, Concepto = ?, Estatus = ? WHERE PagoID = ?";
                $resultUpdate = ejecutarUpdate($sqlUpdate, [$montoPar, $fechaPar, $metodoPP, $conceptoPar, $estatusPP, $idPagoPar]);

                if ($resultUpdate) {
                    echo json_encode(
                        array(
                            "typeMessage" => array(
                                "type" => "success",
                                "title" => "Pago parcial actualizado exitosamente",
                                "code" => 200,
                            ),
                            "description" => array(
                                "Message" => "El pago parcial ha sido actualizado correctamente y ya está disponible en el sistema.",
                            )
                        ),
                        JSON_UNESCAPED_UNICODE
                    );
                } else {
                    echo json_encode(
                        array(
                            "typeMessage" => array(
                                "type" => "warning",
                                "title" => "Error al actualizar el pago parcial",
                                "code" => 201,
                            ),
                            "description" => array(
                                "Message" => "Hubo un error al intentar actualizar el pago parcial. Por favor, verifica los datos ingresados e intenta nuevamente. Si el problema persiste, contacta al administrador del sistema.",
                            )
                        ),
                        JSON_UNESCAPED_UNICODE
                    );
                }
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

    case 'listarPagosPar':
        $sqlSelect = "SELECT * FROM Pagos_Cooperacion WHERE CooperacionID=?";
        $resultSelect = ejecutarConsulta($sqlSelect, [$idPago]);

        while ($fila = mysqli_fetch_object($resultSelect)) {
            $botones = "";
            $status = "";
            if ($fila->Estatus == "Cancelado") {
                $status = '<div class="badge text-white bg-danger">Cancelado</div>';
            } else if ($fila->Estatus == "Pendiente") {
                $status = '<div class="badge text-white bg-secondary">Pendiente</div>';
            } else if ($fila->Estatus == "Completado") {
                $status = '<div class="badge text-white bg-success">Completado</div>';
            }
            $botones = '
                        <button type="button" class="btn btn-primary btn-sm mr-2" title="Modificar" onclick="dataPagosPar(' . $fila->PagoID . ')"><i class="fas fa-edit"></i></button>
                        ';
            $datos[] = array(
                "0" => "<div class='text-left'>$fila->Concepto</div>",
                "1" => "<div class='text-center'>$fila->Fecha</div>",
                "2" => "<div class='text-center'>$$fila->Monto</div>",
                "3" => "<div class='text-center'>$fila->MetodoPago</div>",
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
    case 'dataPagosPar':
        try {
            $sqlSelectUser = "SELECT Monto, Fecha, MetodoPago, Concepto, Estatus FROM Pagos_Cooperacion WHERE PagoID=?";
            $resultSelectUser = ejecutarConsultaSimpleFila($sqlSelectUser, [$idPagoPar]);
            if (!$resultSelectUser) {
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
                        "Message" => "Los datos del pago se han consultado con éxito. Ahora puede actualizar la información como sea necesario.",
                    ),
                    "data" => $resultSelectUser
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
}
