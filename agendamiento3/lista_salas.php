<?php include 'conexion.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Salas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table th, .table td {
            vertical-align: middle;
        }
        .btn-back {
            margin-top: 20px;
        }
        .card-header {
            background-color: #007bff;
            color: white;
        }
        .card-body {
            padding: 1.5rem;
        }
    </style>
</head>
<body class="container mt-5">
    <h2 class="text-center mb-4">Lista de Salas</h2>

    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="card-title mb-0">Salas Disponibles</h5>
        </div>
        <div class="card-body">
            <table class="table table-striped table-hover table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = $conn->query("SELECT * FROM salas");
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['nombre']}</td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>
            <a href="dashboard.php" class="btn btn-secondary btn-back">Volver</a>
        </div>
    </div>
</body>
</html>
