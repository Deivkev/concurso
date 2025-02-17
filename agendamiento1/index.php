<?php
session_start();
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === "usuario" && $password === "contraseña") {
        $_SESSION['loggedin'] = true;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Concurso</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        header {
            background-color: #333;
            color: white;
            padding: 10px 0;
            text-align: center;
        }
        nav {
            background-color: #444;
            overflow: hidden;
        }
        nav a {
            color: white;
            padding: 14px 20px;
            text-decoration: none;
            float: left;
        }
        nav a:hover {
            background-color: #575757;
        }
        .content {
            padding: 20px;
        }
        footer {
            text-align: center;
            padding: 10px;
            background-color: #333;
            color: white;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        .login-form {
            margin: 20px;
            text-align: center;
        }
        .login-form input {
            padding: 10px;
            margin: 10px;
            font-size: 16px;
        }
        .login-form button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #333;
            color: white;
            border: none;
        }
        .login-form button:hover {
            background-color: #575757;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>

    <header>
        <h1>Bienvenido</h1>
    </header>

    <div class="login-form">
        <h2>Iniciar sesión</h2>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Usuario" required><br>
            <input type="password" name="password" placeholder="Contraseña" required><br>
            <button type="submit">Iniciar sesión</button>
        </form>
    </div>

    <nav id="navMenu" class="hidden">
        <a href="#inicio">Inicio</a>
        <a href="#servicios">Servicios</a>
    </nav>

    <div class="content">
        <h2 id="inicio">Inicio</h2>
        <p>Este es una pagina principal de clinica </p>

        <h2 id="servicios">Servicios</h2>
        <ul>
            <li>Agendamiento de citas</li>
        </ul>

    </div>

    <footer>
        <p>Derechos reservados 2025 2K</p>
    </footer>

</body>
</html>