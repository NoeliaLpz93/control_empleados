<?php

session_start();

if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
}

include("config.php");

$id_empleado = $_SESSION["id"];

$stmt = $conexion->prepare(
    "SELECT *
     FROM movimientos
     WHERE id_empleado = ?
     ORDER BY fecha_hora DESC
     LIMIT 1"
);

$stmt->bind_param("i", $id_empleado);
$stmt->execute();

$ultimo = $stmt->get_result()->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Panel de Empleado</title>

  <link rel="stylesheet" href="/control_empleados/css/estilo.css">
  
</head>

<body>

    <div class="contenedor">

        <h1>
            Bienvenido <?php echo $_SESSION["nombre"]; ?>
        </h1>

        <?php if ($ultimo) { ?>

            <p>
                Tu último registro fue:
                <strong>
                    <?php echo strtoupper($ultimo["tipo"]); ?>
                </strong>
                a las
                <?php echo $ultimo["fecha_hora"]; ?>
            </p>

        <?php } else { ?>

            <p>
                Todavía no tienes movimientos registrados.
            </p>

        <?php } ?>

        <form action="registrar.php" method="POST">

            <button
                type="submit"
                name="tipo"
                value="ingreso">
                Registrar Ingreso
            </button>

            <button
                type="submit"
                name="tipo"
                value="egreso">
                Registrar Egreso
            </button>

        </form>

        <a href="logout.php">
            Cerrar sesión
        </a>

    </div>

</body>

</html>