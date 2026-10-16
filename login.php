<?php
session_start();
include("config.php");

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $dni = $_POST["dni"];
    $clave = $_POST["clave"];

    $stmt = $conexion->prepare(
        "SELECT * FROM empleados WHERE dni = ? AND activo = 1"
    );

    $stmt->bind_param("s", $dni);
    $stmt->execute();

    $resultado = $stmt->get_result();

    if ($resultado->num_rows == 1) {

        $empleado = $resultado->fetch_assoc();

        if (password_verify($clave, $empleado["clave"])) {

            $_SESSION["id"] = $empleado["id_empleado"];
            $_SESSION["nombre"] = $empleado["nombre"];

            header("Location: panel.php");
            exit();
        }
    }

    $error = "Usuario o contraseña incorrectos";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="/control_empleados/css/estilo.css">
</head>
<body>

    <h1>Control de Empleados</h1>

    <form method="POST">

        <label>DNI</label><br>
        <input type="text" name="dni" required>

        <br><br>

        <label>Contraseña</label><br>
        <input type="password" name="clave" required>

        <br><br>

        <button type="submit">
            Ingresar
        </button>

    </form>

    <p style="color:red;">
        <?php echo $error; ?>
    </p>

</body>
</html>