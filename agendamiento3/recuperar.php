<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    
    if (empty($username)) {
        $error = "Por favor, ingrese su nombre de usuario.";
    } else {
        $query = "SELECT email FROM users WHERE username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $email = $user['email'];
            
            $token = bin2hex(random_bytes(50));
            $expira = date("Y-m-d H:i:s", strtotime("+1 hour"));
            
            $query = "INSERT INTO password_resets (username, token, expira) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('sss', $username, $token, $expira);
            $stmt->execute();
            
            $reset_link = "http://tu-sitio.com/reset_password.php?token=$token";
            $subject = "Recuperación de contraseña";
            $message = "Haga clic en el siguiente enlace para restablecer su contraseña: $reset_link";
            $headers = "From: no-reply@tu-sitio.com";
            
            mail($email, $subject, $message, $headers);
            
            $success = "Se ha enviado un enlace de recuperación a su correo electrónico.";
        } else {
            $error = "El usuario no existe.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5;
        }
        .form-container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: 50px auto;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Recuperar Contraseña</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Ingrese su usuario" class="form-control" required><br>
            <button type="submit" class="btn btn-primary w-100">Enviar
