<?php
session_start();
include 'conexion.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_username = $_POST['new_username'];
    $new_password = $_POST['new_password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $new_username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error = "El usuario ya existe.";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt->bind_param("ss", $new_username, $hashed_password);
        if ($stmt->execute()) {
            $success = "Registro exitoso. Ahora puedes iniciar sesión.";
        } else {
            $error = "Error al registrar el usuario.";
        }
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
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        header {
            background-color: #007BFF;
            color: white;
            padding: 20px 0;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .register-form {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            margin: 50px auto;
            padding: 30px;
            max-width: 400px;
            text-align: center;
        }
        .register-form h2 {
            margin-bottom: 20px;
            color: #333;
        }
        .register-form input {
            padding: 10px;
            margin: 10px 0;
            font-size: 16px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            width: calc(100% - 22px);
        }
        .register-form button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .register-form button:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            margin: 10px 0;
        }
        .success {
            color: green;
            margin: 10px 0;
        }
        .back-button {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .back-button:hover {
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
        <h1>Registro de Usuario</h1>
    </header>

    <div class="register-form">
        <h2>Registrarse</h2>
        <?php if ($error): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <?php if ($success): ?>
            <p class="success"><?php echo $success; ?></p>
            <!-- Botón para regresar al inicio -->
            <button class="back-button" onclick="window.location.href='index.php'">Volver al Inicio</button>
        <?php else: ?>
            <form method="POST" action="">
                <input type="text" name="new_username" placeholder="Nuevo Usuario" required><br>
                <input type="password" name="new_password" placeholder="Nueva Contraseña" required><br>
                <button type="submit">Registrarse</button>
            </form>
        <?php endif; ?>
    </div>

    <footer>
        <p>&copy; Derechos reservados 2025 2K</p>
    </footer>
</body>
</html>
