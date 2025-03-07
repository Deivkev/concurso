<?php
session_start();
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $error = "Por favor, ingrese el nombre de usuario y la contraseña.";
    } else {
        if (!preg_match('/^(?=.*[!@#$%^&*(),.?":{}|<>]).{8,}$/', $password)) {
            $error = "La contraseña debe tener al menos 8 caracteres y contener un carácter especial.";
        } else {
            $username = htmlspecialchars($username);
            $query = "SELECT * FROM users WHERE username = ?";
            $stmt = $conn->prepare($query);

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
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Concurso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f7fc;
            font-family: 'Poppins', sans-serif;
        }
        header {
            background-color: #004aad;
            color: white;
            padding: 30px 0;
            text-align: center;
            border-bottom: 4px solid #003689;
        }
        .login-form {
            background-color: white;
            border-radius: 15px;
            padding: 60px 40px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: 90px auto;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .login-form:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
        }
        .login-form h2 {
            margin-bottom: 30px;
            font-weight: 600;
            color: #343a40;
            text-align: center;
            font-size: 26px;
        }
        .login-form input {
            margin-bottom: 20px;
            width: 100%;
            padding: 15px;
            border-radius: 10px;
            border: 1px solid #ced4da;
            font-size: 16px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        .login-form input:focus {
            border-color: #004aad;
            box-shadow: 0 0 5px rgba(0, 74, 173, 0.6);
            outline: none;
        }
        .login-form button {
            background-color: #004aad;
            color: white;
            padding: 15px;
            border-radius: 10px;
            border: none;
            font-size: 16px;
            width: 100%;
            transition: transform 0.3s ease;
        }
        .login-form button:hover {
            background-color: #003689;
            transform: scale(1.05);
        }
        .login-form .btn-link {
            color: #004aad;
            text-decoration: none;
            font-size: 14px;
            display: block;
            text-align: center;
            margin-top: 10px;
        }
        .login-form .btn-link:hover {
            text-decoration: underline;
        }
        footer {
            background-color: #004aad;
            color: white;
            padding: 15px;
            text-align: center;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
        .alert {
            margin-top: 15px;
            margin-bottom: 15px;
            text-align: center;
        }
    </style>
</head>
<body>

    <header>
        <h1><i class="fas fa-calendar-alt"></i> Sistema de Citas</h1>
    </header>

    <div class="login-form">
        <h2>Iniciar sesión</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Usuario" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Iniciar sesión</button>
        </form>
        <a href="register.php" class="btn btn-link">¿No tienes una cuenta? Regístrate</a><br>
        <a href="recuperar.php" class="btn btn-link">¿Olvidaste tu contraseña?</a>
    </div>

    <footer>
        <p>&copy; 2025 Sistema de Citas. Todos los derechos reservados.</p>
    </footer>

</body>
</html>
