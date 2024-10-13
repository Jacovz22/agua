<?php
// Obtener los valores de las variables de entorno
$entorno = "development";
$host = "localhost";
$port = 3306;
$user = "root";
$password = "smr26";
$BD = "water";

if ($host && $user && $password && $BD && $port) {
    $conexion = new mysqli($host, $user, $password, $BD, $port);
    // Verificar la conexión
    if ($conexion->connect_error) {
        http_response_code(500); // Código de estado HTTP 500 Internal Server Error
        echo json_encode(array(
            "error" => true,
            "message" => "Error al conectar a la base de datos: " . $conexion->connect_error
        ), JSON_UNESCAPED_UNICODE);
        exit;
    }

    // Definir funciones (si no existen)
    if (!function_exists('ejecutarConsulta')) {
        function ejecutarConsulta($sql, $params = [])
        {
            global $conexion;

            try {
                $stmt = $conexion->prepare($sql);
                if (!$stmt) {
                    throw new Exception("Error al preparar la consulta: " . $conexion->error, 500);
                }

                if (!empty($params)) {
                    $types = str_repeat('s', count($params)); // Asumimos que todos los parámetros son de tipo string
                    $stmt->bind_param($types, ...$params);
                }

                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();

                return $result;
            } catch (Exception $e) {
                // Lanza la excepción con un código de error HTTP
                throw new Exception($e->getMessage(), $e->getCode());
            }
        }

        function ejecutarInsert($sql, $params = [])
        {
            global $conexion;

            try {
                $stmt = $conexion->prepare($sql);
                if (!$stmt) {
                    throw new Exception("Error al preparar la consulta: " . $conexion->error, 500);
                }

                if (!empty($params)) {
                    $types = str_repeat('s', count($params)); // Asumimos que todos los parámetros son de tipo string
                    $stmt->bind_param($types, ...$params);
                }

                $stmt->execute();
                $insert_id = $conexion->insert_id; // Obtiene el ID insertado
                $stmt->close();
                return $insert_id; // Devuelve el ID del nuevo registro insertado

            } catch (Exception $e) {
                // Lanza la excepción con un código de error HTTP
                throw new Exception($e->getMessage(), $e->getCode());
            }
        }

        function ejecutarUpdate($sql, $params = [])
        {
            global $conexion;

            try {
                $stmt = $conexion->prepare($sql);
                if (!$stmt) {
                    throw new Exception("Error al preparar la consulta: " . $conexion->error, 500);
                }

                if (!empty($params)) {
                    $types = str_repeat('s', count($params)); // Asumimos que todos los parámetros son de tipo string
                    $stmt->bind_param($types, ...$params);
                }

                $stmt->execute();
                $affected_rows = $stmt->affected_rows; // Obtiene el número de filas afectadas
                $stmt->close();
                return $affected_rows; // Devuelve el número de filas afectadas

            } catch (Exception $e) {
                // Lanza la excepción con un código de error HTTP
                throw new Exception($e->getMessage(), $e->getCode());
            }
        }


        function ejecutarConsultaSimpleFila($sql, $params = [])
        {
            global $conexion;

            try {
                $stmt = $conexion->prepare($sql);
                if (!$stmt) {
                    throw new Exception("Error al preparar la consulta: " . $conexion->error, 500);
                }

                if (!empty($params)) {
                    $types = str_repeat('s', count($params)); // Asumimos que todos los parámetros son de tipo string
                    $stmt->bind_param($types, ...$params);
                }

                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $stmt->close();

                return $row;
            } catch (Exception $e) {
                // Lanza la excepción con un código de error HTTP
                throw new Exception($e->getMessage(), $e->getCode());
            }
        }
        if (!function_exists('ejecutarDelete')) {
            function ejecutarDelete($sql, $params = [])
            {
                global $conexion;

                try {
                    $stmt = $conexion->prepare($sql);
                    if (!$stmt) {
                        throw new Exception("Error al preparar la consulta: " . $conexion->error, 500);
                    }

                    if (!empty($params)) {
                        $types = str_repeat('s', count($params)); // Asumimos que todos los parámetros son de tipo string
                        $stmt->bind_param($types, ...$params);
                    }

                    $stmt->execute();
                    $affected_rows = $stmt->affected_rows; // Obtiene el número de filas afectadas
                    $stmt->close();
                    return $affected_rows; // Devuelve el número de filas afectadas

                } catch (Exception $e) {
                    // Lanza la excepción con un código de error HTTP
                    throw new Exception($e->getMessage(), $e->getCode());
                }
            }
        }
    }
} else {
    http_response_code(500); // Código de estado HTTP 500 Internal Server Error
    echo json_encode(array(
        "error" => true,
        "message" => "Faltan variables de entorno para la conexión a la base de datos."
    ), JSON_UNESCAPED_UNICODE);
    exit;
}
