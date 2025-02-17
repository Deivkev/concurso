<?php include 'conexion.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Salas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Lista de Salas</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sala</th>
                <th>Paciente</th>
                <th>Doctor</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = $conn->query("SELECT s.nombre AS sala, p.nombre AS paciente, d.nombre AS doctor
                                    FROM citas c
                                    JOIN salas s ON c.sala = s.nombre
                                    JOIN pacientes p ON c.paciente_id = p.id
                                    JOIN doctores d ON c.doctor_id = d.id");
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['sala']}</td>
                        <td>{$row['paciente']}</td>
                        <td>{$row['doctor']}</td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
    <a href="index.php" class="btn btn-secondary">Volver</a>
</body>
</html>
