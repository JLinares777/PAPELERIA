<?php
session_start();

// Conectar a MySQL
$servidor = "localhost";
$usuario = "root";
$clave = "";
$baseDeDatos = "formulario";

// Crear conexión inicial sin especificar la base de datos
$enlace = mysqli_connect($servidor, $usuario, $clave);

// Comprobar conexión
if (!$enlace) {
    die("Error en la conexión: " . mysqli_connect_error());
}

// Crear la base de datos si no existe
$queryCrearBD = "CREATE DATABASE IF NOT EXISTS $baseDeDatos";
if (!mysqli_query($enlace, $queryCrearBD)) {
    die("Error al crear la base de datos: " . mysqli_error($enlace));
}

// Conectar a la base de datos `ejemplo`
mysqli_select_db($enlace, $baseDeDatos);

// Crear la tabla `registros` si no existe
$queryCrearTabla = "
    CREATE TABLE IF NOT EXISTS registros (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(50),
        apellido VARCHAR(50),
        correo VARCHAR(20),
        contrasena VARCHAR(20)
    )
";
if (!mysqli_query($enlace, $queryCrearTabla)) {
    die("Error al crear la tabla: " . mysqli_error($enlace));
}

// Función para insertar un registro
function insertarRegistro($nombre, $apellido, $correo, $contrasena) {
    global $enlace;
    $query = "INSERT INTO registros (nombre, apellido, correo, contrasena) VALUES ('$nombre', '$apellido', '$correo', '$contrasena')";
    return mysqli_query($enlace, $query);
}

// Procesar el formulario de registro
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registrar'])) {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];
    if (insertarRegistro($nombre, apellido: $apellido, correo: $correo, contrasena: $contrasena)) {
        $message = 'Registro realizado con éxito';
    } else {
        $message = 'Error al registrar: ' . mysqli_error($enlace);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #eef2f3;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 600px;
            margin: 2em auto;
            background: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 1.5em;
            border-radius: 8px;
        }

        h1 {
            text-align: center;
            color: #444444;
        }

        p.message {
            text-align: center;
            font-size: 1em;
            color: #28a745;
        }

        form {
            display: grid;
            gap: 1em;
        }

        label {
            font-weight: bold;
        }

        input {
            padding: 0.6em;
            border: 1px solid #cccccc;
            border-radius: 4px;
            width: 100%;
        }

        button {
            padding: 0.8em;
            background-color: #007bff;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
        }

        button:hover {
            background-color: #0056b3;
        }

        .list {
            margin-top: 2em;
        }

        .list ul {
            list-style: none;
            padding: 0;
        }

        .list li {
            background: #f9f9f9;
            margin: 0.5em 0;
            padding: 0.7em;
            border: 1px solid #dddddd;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Formulario de Registro</h1>
        <?php if (isset($message)) echo "<p class='message'>$message</p>"; ?>
        <form method="POST">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" required>
            <label for="apellido">Apellido:</label>
            <input type="text" name="apellido" id="apellido" required>
            <label for="correo">Correo:</label>
            <input type="text" name="correo" id="correo" required>
            <label for="contrasena">Contraseña:</label>
            <input type="text" name="contrasena" id="contrasena" required>
            <button type="submit" name="registrar">Registrar</button>
        </form>

       
    </div>
</body>
</html>


