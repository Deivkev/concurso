<?php include 'conexion.php'; ?>

<?php
if (isset($_GET['id'])) {
    $paciente_id = $_GET['id'];
 
    $cita_result = $conn->query("SELECT c.id, p.nombre, p.telefono, p.correo, c.fecha, c.hora, c.sala, s.nombre AS servicio
                                 FROM citas c
                                 JOIN pacientes p ON c.paciente_id = p.id
                                 JOIN servicios s ON c.servicio_id = s.id
                                 WHERE p.id = '$paciente_id'");
    $cita = $cita_result->fetch_assoc();
} else {
    echo "<script>alert('No se ha encontrado la cita.'); window.location.href='index.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo de Cita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .recibo {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
    </style>
</head>
<body class="container mt-5">
    <div class="recibo">
        <h2 class="text-center">Recibo de Cita Médica</h2>
        <p><strong>Paciente:</strong> <?php echo $cita['nombre']; ?></p>
        <p><strong>Teléfono:</strong> <?php echo $cita['telefono']; ?></p>
        <p><strong>Correo:</strong> <?php echo $cita['correo']; ?></p>
        <p><strong>Fecha:</strong> <?php echo $cita['fecha']; ?></p>
        <p><strong>Hora:</strong> <?php echo $cita['hora']; ?></p>
        <p><strong>Sala de espera:</strong> <?php echo $cita['sala']; ?></p>
        <p><strong>Especialidad:</strong> <?php echo $cita['servicio']; ?></p>

        <a href="index.php" class="btn btn-primary">Volver</a>
        <button class="btn btn-success" onclick="window.print();">Imprimir Recibo</button>
    </div>
</body>
</html>
