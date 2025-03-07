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
    <title>Recibo de Cita Médica</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f8fa;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }
        .recibo-container {
            max-width: 480px;
            margin: 40px auto;
            padding: 20px;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .logo {
            max-width: 100px;
            margin-bottom: 15px;
        }
        h2 {
            color: #007bff;
            font-weight: 700;
            font-size: 24px;
            margin-bottom: 15px;
        }
        .section-title {
            color: #333;
            font-weight: bold;
        }
        p {
            color: #555;
            font-size: 14px;
            line-height: 1.5;
        }
        .nota-importante {
            color: #e74c3c;
            font-weight: bold;
            font-size: 16px;
            margin-top: 15px;
        }
        .btn-custom {
            background-color: #28a745;
            color: white;
            font-size: 14px;
            padding: 8px 20px;
            border-radius: 25px;
            text-decoration: none;
        }
        .btn-custom:hover {
            background-color: #218838;
        }
        .btn-back {
            background-color: #6c757d;
            color: white;
            font-size: 14px;
            padding: 8px 20px;
            border-radius: 25px;
            margin-right: 10px;
        }
        .btn-back:hover {
            background-color: #5a6268;
        }
        @media (max-width: 600px) {
            .recibo-container {
                padding: 15px;
            }
            h2 {
                font-size: 20px;
            }
            .nota-importante {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="recibo-container">
            <img src="assets/logo.jpg" alt="Logo de la clínica" class="logo">
            <h2>Recibo de Cita Médica</h2>

            <div class="patient-info">
                <p><span class="section-title">Paciente:</span> <?php echo $cita['nombre']; ?></p>
                <p><span class="section-title">Teléfono:</span> <?php echo $cita['telefono']; ?></p>
                <p><span class="section-title">Correo:</span> <?php echo $cita['correo']; ?></p>
            </div>

            <div class="appointment-info">
                <p><span class="section-title">Fecha:</span> <?php echo $cita['fecha']; ?></p>
                <p><span class="section-title">Hora:</span> <?php echo $cita['hora']; ?></p>
                <p><span class="section-title">Sala:</span> <?php echo $cita['sala']; ?></p>
                <p><span class="section-title">Especialidad:</span> <?php echo $cita['servicio']; ?></p>
            </div>

            <p class="nota-importante">⚠️ Importante: Debe presentarse con 30 minutos de anticipación. ⚠️</p>

            <div class="d-flex justify-content-center mt-4">
                <a href="dashboard.php" class="btn btn-back">Volver</a>
                <button class="btn btn-custom" onclick="window.print();">Imprimir Recibo</button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
