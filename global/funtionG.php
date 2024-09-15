<?php
// Configurar la zona horaria
date_default_timezone_set('America/Mexico_City');

if (!function_exists('esLongitudExacta')) {
    function esLongitudExacta($palabra, $longitudDeseada)
    {
        return strlen($palabra) <= $longitudDeseada;
    }
}
if (!function_exists('truncate_number')) {
    function truncate_number($number, $decimals)
    {
        $factor = pow(10, $decimals);
        return floor($number * $factor) / $factor;
    }
}
if (!function_exists('recortar_cadena')) {
    function recortar_cadena($cadena, $longitud_maxima)
    {
        $cadena_con_br = nl2br($cadena);
        if (strlen($cadena_con_br) > $longitud_maxima) {
            $cadena_recortada = substr($cadena_con_br, 0, $longitud_maxima);
            $last_space_position = strrpos($cadena_recortada, ' ');
            if ($last_space_position !== false) {
                $cadena_recortada = substr($cadena_recortada, 0, $last_space_position);
            }
            return $cadena_recortada . "...";
        } else {
            return $cadena_con_br;
        }
    }
}

if (!function_exists('sanitizeInput')) {
    function sanitizeInput($input)
    {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
        return $input;
    }
}

if (!function_exists('fechaActual')) {
    function fechaActual()
    {
        $week_days = array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
        $months = array("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $year_now = date("Y");
        $month_now = date("n");
        $day_now = date("j");
        $week_day_now = date("w");
        $date = $week_days[$week_day_now] . ", " . $day_now . " de " . $months[$month_now] . " de " . $year_now;
        return $date;
    }
}

if (!function_exists('fechaEs')) {
    function fechaEs($fecha)
    {
        $fecha = substr($fecha, 0, 10);
        $numeroDia = date('d', strtotime($fecha));
        $dia = date('l', strtotime($fecha));
        $mes = date('F', strtotime($fecha));
        $anio = date('Y', strtotime($fecha));
        $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
        $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
        $nombredia = str_replace($dias_EN, $dias_ES, $dia);
        $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
        $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
        return "$nombredia, $numeroDia de $nombreMes de $anio";
    }
}

if (!function_exists('limpiarDatos')) {
    function limpiarDatos($data)
    {
        // Elimina espacios en blanco al inicio y al final
        $data = trim($data);

        // Elimina barras invertidas si las hay
        $data = stripslashes($data);

        // Convierte caracteres especiales en entidades HTML
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');

        return $data;
    }
}
