
<?php

session_start();
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role']; 
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Usuario o contraseña incorrectos";
        }
    }

    elseif (isset($_POST['register'])) {
        $newUsername = $_POST['new_username'];
        $newPassword = $_POST['new_password'];

        if (!empty($newUsername) && !empty($newPassword)) {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO usuarios (username, password, role) VALUES (?, ?, 'usuario')");
            $stmt->bind_param("ss", $newUsername, $hashedPassword);

            if ($stmt->execute()) {
                $successMessage = "Registro exitoso. Ahora puedes iniciar sesión.";
            } else {
                $error = "Error al registrar el usuario. Intenta de nuevo.";
            }
        } else {
            $error = "Por favor, completa todos los campos.";
        }
    }
}


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 600px;
            margin-top: 100px;
        }
        .form-container {
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .error, .success {
            color: red;
        }
    </style>
</head>
<body>

<div class="container">
  
    <div class="form-container">
        <h2 class="text-center">Iniciar Sesión</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="username" class="form-label">Usuario</label>
                <input type="text" name="username" id="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <button type="submit" name="login" class="btn btn-primary w-100">Iniciar sesión</button>
        </form>
        <hr>
        <p class="text-center">¿No tienes cuenta? <a href="#register" data-bs-toggle="collapse" data-bs-target="#registerForm">Regístrate aquí</a></p>
    </div>


    <div class="collapse" id="registerForm">
        <div class="form-container mt-4">
            <h2 class="text-center">Registro</h2>
            <?php if (isset($successMessage)): ?>
                <div class="alert alert-success"><?php echo $successMessage; ?></div>
            <?php endif; ?>
            <?php if (isset($error) && !isset($successMessage)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="new_username" class="form-label">Nuevo Usuario</label>
                    <input type="text" name="new_username" id="new_username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="new_password" class="form-label">Nueva Contraseña</label>
                    <input type="password" name="new_password" id="new_password" class="form-control" required>
                </div>
                <button type="submit" name="register" class="btn btn-primary w-100">Registrar</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
