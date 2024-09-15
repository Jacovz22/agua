<?php
$Credenciales = array();
// Cargamos los permisos del usuario
$permisos = ejecutarConsulta("SELECT * FROM permisos_user WHERE Id_Usuario='" . $_SESSION['Id_Usuario'] . "';");
while ($fila = mysqli_fetch_object($permisos)) {
    $Credenciales[$fila->Id_Permiso] = "Permiso_$fila->Id_Permiso";
}
?>
