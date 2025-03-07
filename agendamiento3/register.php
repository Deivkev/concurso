<?php
session_start();
include 'conexion.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_username = $_POST['new_username'];
    $new_password = $_POST['new_password'];

    if (!preg_match('/^(?=.*[A-Z])(?=.*[\W_]).{8,}$/', $new_password)) {
        $error = "La contraseña debe tener al menos 8 caracteres, una mayúscula y un carácter especial.";
    } else {
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
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5;
        }
        .register-form {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: 50px auto;
        }
    </style>
</head>
<body>
    <div class="register-form">
        <h2>Registrarse</h2>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
            <a href="index.php" class="btn btn-primary w-100">Volver al Inicio</a>
        <?php else: ?>
            <form method="POST" action="">
                <input type="text" name="new_username" placeholder="Nuevo Usuario" class="form-control" required><br>
                <input type="password" name="new_password" placeholder="Nueva Contraseña" class="form-control" required><br>
                <button type="submit" class="btn btn-primary w-100">Registrarse</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
