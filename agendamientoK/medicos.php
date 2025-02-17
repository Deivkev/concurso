
<?php include 'conexion.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Médicos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2 class="text-center">Médicos Disponibles</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Especialidad</th>
                <th>Edad</th>
            </tr>
        </thead>
        <tbody>
            <?php

            $result = $conn->query("SELECT nombre, apellido, especialidad, edad FROM medicos"); 

            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['nombre']} {$row['apellido']}</td>
                        <td>{$row['especialidad']}</td>
                        <td>{$row['edad']}</td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
    
    <a href="dashboard.php" class="btn btn-secondary">Volver</a>
</body>
</html>
