<?php
session_start();
include '../../global/conexion.php';
include '../../global/funtionG.php';

$User = isset($_POST['User']) ? limpiarDatos($_POST['User']) : "";
$Password = isset($_POST['Password']) ? limpiarDatos($_POST['Password']) : "";

switch ($_GET['op']) {
    case 'login':
        try {
            $sqlCount = "SELECT COUNT(*) as count FROM Usuarios WHERE Nombre = ?";
            $resultSqlCount = ejecutarConsultaSimpleFila($sqlCount, [$User]);
            if (!$resultSqlCount) {
                throw new Exception("Ocurrió un error al consultar datos.", 409);
            }
            if ($resultSqlCount["count"] == 0) {
                throw new Exception("Usuario no encontrado.", 409);
            } else {
                $dataUser = "SELECT Contrasena FROM Usuarios WHERE Nombre=?";
                $recultDataU = ejecutarConsultaSimpleFila($dataUser, [$User]);
                if (password_verify($Password, $recultDataU["Contrasena"])) {
                    $_SESSION['sesion'] = true;
                    echo json_encode(
                        array(
                            "typeMessage" => array(
                                "type" => "success",
                                "title" => "Success",
                                "code" => 200,
                            ),
                            "description" => array(
                                "message" => "",
                            )
                        ),
                        JSON_UNESCAPED_UNICODE
                    );
                } else {
                    throw new Exception("Contraseña incorrecta.", 409);
                }
            }
        } catch (\Throwable $th) {
            echo json_encode(
                array(
                    "typeMessage" => array(
                        "type" => "error",
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
    case 'logout':
        session_destroy();
        header('location: ../../index.php');
        break;
}
