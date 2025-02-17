<?php include 'conexion.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Citas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Citas Agendadas</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Paciente</th>
                <th>Teléfono</th>
                <th>Correo</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Sala</th>
                <th>Servicio</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = $conn->query("SELECT c.id, p.nombre, p.telefono, p.correo, c.fecha, c.hora, c.sala, s.nombre AS servicio, c.estado 
                                    FROM citas c 
                                    JOIN pacientes p ON c.paciente_id = p.id
                                    JOIN servicios s ON c.servicio_id = s.id");
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['nombre']}</td>
                        <td>{$row['telefono']}</td>
                        <td>{$row['correo']}</td>
                        <td>{$row['fecha']}</td>
                        <td>{$row['hora']}</td>
                        <td>{$row['sala']}</td>
                        <td>{$row['servicio']}</td>
                        <td>{$row['estado']}</td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
    <a href="index.php" class="btn btn-secondary">Volver</a>
</body>
</html>
