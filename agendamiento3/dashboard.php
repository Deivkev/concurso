<?php include 'conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendamiento de Citas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        body {
            background: #f0f4f8;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
        }

        .card {
            width: 100%;
            max-width: 500px;
            padding: 40px 40px;
            border-radius: 15px;
            background-color: #ffffff;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-10px);
        }

        .card h2 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #0056b3;
            margin-bottom: 30px;
        }

        .btn {
            font-size: 18px;
            padding: 14px 30px;
            border-radius: 50px;
            text-transform: uppercase;
            font-weight: 600;
            transition: transform 0.3s, background-color 0.3s;
            width: 100%;
        }

        .btn:hover {
            transform: scale(1.05);
        }

        .btn-primary {
            background-color: #0069d9;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .btn-info {
            background-color: #17a2b8;
            border: none;
        }

        .btn-info:hover {
            background-color: #117a8b;
        }

        .btn-warning {
            background-color: #ffc107;
            border: none;
        }

        .btn-warning:hover {
            background-color: #e0a800;
        }

        .logout-btn {
    position: fixed;
    bottom: 20px; /* Distancia ajustada del borde inferior */
    right: 20px; /* Distancia ajustada del borde derecho */
    background-color: #dc3545;
    padding: 8px 12px; /* Reducido el padding para que sea más pequeño */
    border-radius: 50%; /* Mantiene el borde circular */
    font-size: 18px; /* Reducido el tamaño del icono */
    color: white;
    text-decoration: none;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Sombra más sutil */
    transition: background-color 0.3s, transform 0.3s;
    width: 45px; /* Tamaño del botón más pequeño */
    height: 45px; /* Mantiene la proporción del círculo */
    display: flex;
    justify-content: center;
    align-items: center; /* Centra el icono dentro del botón */
}

.logout-btn i {
    font-size: 18px; /* Ajuste de tamaño del icono */
}

.logout-btn:hover {
    background-color: #c82333;
    transform: scale(1.1); /* Ligera animación en hover */
}

        .d-grid {
            gap: 20px;
        }

     

        .btn:focus, .btn:active {
            outline: none;
        }

        .card .row {
            margin-bottom: 20px;
        }

    </style>
</head>
<body>

    <div class="card">
        <h2>📅 Agendamiento de Citas</h2>
        <div class="d-grid gap-4">
            <a href="agendar.php" class="btn btn-primary">
                <i class="fas fa-pencil-alt"></i> Agendar Cita
            </a>
            <a href="citas.php" class="btn btn-success">
                <i class="fas fa-clipboard-list"></i> Ver Citas
            </a>
            <a href="lista_pacientes.php" class="btn btn-info">
                <i class="fas fa-users"></i> Lista de Pacientes
            </a>
            <a href="lista_salas.php" class="btn btn-warning">
                <i class="fas fa-hospital"></i> Lista de Salas
            </a>
        </div>
    </div>

    <a href="index.php" class="btn logout-btn">
        <i class="fas fa-sign-out-alt"></i>
    </a>

</body>
</html>
