<?php

session_start();

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

include("config.php");

$id_empleado = $_SESSION["id"];
$tipo = $_POST["tipo"];

/* Buscar último movimiento */

$stmt = $conexion->prepare(
    "SELECT tipo
     FROM movimientos
     WHERE id_empleado = ?
     ORDER BY fecha_hora DESC
     LIMIT 1"
);

$stmt->bind_param("i", $id_empleado);
$stmt->execute();

$resultado = $stmt->get_result();
$ultimo = $resultado->fetch_assoc();

/* Validar que no haya dos movimientos iguales seguidos */

if ($ultimo) {

    if ($ultimo["tipo"] == $tipo) {

        die(
            "No puedes registrar dos "
            . $tipo .
            " seguidos.<br><br>
            <a href='panel.php'>Volver al panel</a>"
        );
    }
}

/* Guardar movimiento */

$stmt = $conexion->prepare(
    "INSERT INTO movimientos
    (id_empleado, tipo)
    VALUES (?, ?)"
);

$stmt->bind_param(
    "is",
    $id_empleado,
    $tipo
);

if ($stmt->execute()) {

    header("Location: panel.php");
    exit();

} else {

    echo "Error al guardar: " . $stmt->error;
}

?>