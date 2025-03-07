<?php include 'conexion.php'; ?>
<?php
date_default_timezone_set('America/Mexico_City'); 
$hora_actual = date("H:i");
$fecha_actual = date("Y-m-d");

$servicios_result = $conn->query("SELECT * FROM servicios");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $sala = $_POST['sala'];
    $servicio_id = $_POST['servicio'];

    // Validación de teléfono
    if (!preg_match('/^\d{10}$/', $telefono)) {
        echo "<script>alert('El teléfono debe tener 10 dígitos.'); window.history.back();</script>";
        exit;
    }

    // Validación de fecha y hora (no puedes seleccionar una hora pasada)
    if ($fecha < $fecha_actual || ($fecha == $fecha_actual && $hora < $hora_actual)) {
        echo "<script>alert('No puedes seleccionar una hora pasada.'); window.history.back();</script>";
        exit;
    }

    // Verificar si ya existe una cita en la misma hora y especialidad
    $stmt = $conn->prepare("SELECT id FROM citas WHERE fecha = ? AND hora = ? AND sala = ? AND servicio_id = ?");
    $stmt->bind_param("sssi", $fecha, $hora, $sala, $servicio_id);
    $stmt->execute();
    $stmt->store_result();

    // Si ya existe una cita con la misma hora, especialidad y sala
    if ($stmt->num_rows > 0) {
        echo "<script>alert('Ya existe una cita con esta especialidad en la misma sala y horario. Elija otra hora, sala o especialidad.'); window.history.back();</script>";
        exit;  // Detener el proceso si ya existe una cita
    }

    // Insertar nuevo paciente
    $stmt = $conn->prepare("INSERT INTO pacientes (nombre, telefono, correo) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nombre, $telefono, $correo);
    $stmt->execute();
    $paciente_id = $stmt->insert_id;

    // Insertar cita
    $stmt = $conn->prepare("INSERT INTO citas (paciente_id, fecha, hora, sala, servicio_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("isssi", $paciente_id, $fecha, $hora, $sala, $servicio_id);
    $stmt->execute();
    echo "<script>alert('Cita agendada con éxito'); window.location.href='recibo.php?id={$paciente_id}';</script>";
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar Cita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        body {
            background: #f7f9fc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding-top: 50px;
        }

        .container {
            max-width: 800px;
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            font-weight: bold;
            margin-bottom: 40px;
        }

        .form-label {
            font-weight: 600;
            color: #555;
        }

        .form-control {
            border-radius: 10px;
            border: 1px solid #ddd;
            padding: 15px;
            font-size: 16px;
            margin-bottom: 20px;
        }

        .form-control:focus {
            border-color: #74ebd5;
            box-shadow: 0 0 5px rgba(116, 235, 213, 0.5);
        }

        .btn {
            width: 100%;
            padding: 15px;
            border-radius: 25px;
            font-size: 18px;
            font-weight: bold;
        }

        .btn-primary {
            background-color: #0069d9;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-secondary {
            background-color: #6c757d;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .btn:focus {
            outline: none;
        }

        .mb-3 {
            margin-bottom: 20px;
        }

        .back-btn {
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }

        .logout-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background-color: #dc3545;
            padding: 18px 25px;
            border-radius: 50%;
            font-size: 25px;
            color: white;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .logout-btn:hover {
            background-color: #c82333;
        }

        .alert {
            margin-top: 20px;
        }

        .select2-container {
            width: 100% !important;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>📅 Agendar Cita</h2>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label" for="nombre">Nombre:</label>
                <input type="text" class="form-control" name="nombre" id="nombre" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="telefono">Teléfono:</label>
                <input type="text" class="form-control" name="telefono" id="telefono" required maxlength="10">
            </div>
            <div class="mb-3">
                <label class="form-label" for="correo">Correo:</label>
                <input type="email" class="form-control" name="correo" id="correo" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="fecha">Fecha:</label>
                <input type="date" class="form-control" name="fecha" id="fecha" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="hora">Hora:</label>
                <input type="text" class="form-control" name="hora" id="hora" required placeholder="Ej. 15:30">
            </div>
            <div class="mb-3">
                <label class="form-label" for="sala">Sala:</label>
                <select class="form-control" name="sala" id="sala">
                    <option value="Sala de espera 1">Sala de espera 1</option>
                    <option value="Sala de espera 2">Sala de espera 2</option>
                    <option value="Consulta 1">Consulta 1</option>
                    <option value="Consulta 2">Consulta 2</option>
                    <option value="Consulta 3">Consulta 3</option>
                    <option value="Consulta 4">Consulta 4</option>
                    <option value="Consulta 5">Consulta 5</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label" for="servicio">Servicio:</label>
                <select class="form-control" name="servicio" id="servicio" required>
                    <?php while ($servicio = $servicios_result->fetch_assoc()): ?>
                        <option value="<?php echo $servicio['id']; ?>"><?php echo $servicio['nombre']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Agendar</button>
        </form>

        <div class="back-btn">
            <a href="dashboard.php" class="btn btn-secondary">Volver</a>
        </div>
    </div>

    <a href="index.php" class="logout-btn">
        <i class="fas fa-sign-out-alt"></i>
    </a>
</body>
</html>
