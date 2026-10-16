<?php

$conexion = new mysqli(
    "localhost",
    "root",
    "251293",
    "control_empleados"
);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

?>