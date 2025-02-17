<?php
session_start();
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);  // Usar $conn para la conexión

    if ($stmt) {
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['loggedin'] = true;
                header("Location: dashboard.php");
                exit;
            } else {
                $error = "Usuario o contraseña incorrectos";
            }
        } else {
            $error = "Usuario o contraseña incorrectos";
        }
    } else {
        $error = "Error al ejecutar la consulta: " . $conn->error;
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
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #e9ecef;
        }
        header {
            background-color: #007BFF;
            color: white;
            padding: 15px 0;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .login-form {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            margin: 50px auto;
            padding: 20px;
            max-width: 350px;
            text-align: center;
        }
        .login-form h2 {
            margin-bottom: 15px;
            color: #333;
        }
        .login-form input {
            padding: 10px;
            margin: 10px 0;
            font-size: 14px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            width: calc(100% - 22px);
        }
        .login-form button {
            padding: 10px 20px;
            font-size: 14px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .login-form button:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            margin: 10px 0;
        }
        .register-button {
            margin-top: 10px;
            padding: 10px 20px;
            font-size: 14px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .register-button:hover {
            background-color: #218838;
        }
        footer {
            text-align: center;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            position: fixed;
            bottom: 0;
            width: 100%;
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
        <button class="register-button" onclick="window.location.href='register.php'">Registrarse</button>
    </div>
    <div class="content">
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

