
<?php 
include 'conexion.php'; 

$servicios_result = $conn->query("SELECT * FROM servicios");


$salas_result = [
    'Sala de espera 1', 
    'Sala de espera 2', 
    'Consulta 1',
    'Consulta 2',
    'Consulta 3',
    'Consulta 4',
    'Consulta 5'
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $sala = $_POST['sala'];
    $servicio_id = $_POST['servicio'];


    $query = "SELECT * FROM citas WHERE fecha = '$fecha' AND hora = '$hora' AND sala = '$sala' AND estado = 'Pendiente'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        
        echo "<script>alert('El horario seleccionado ya está ocupado. Por favor, elige otro horario.');</script>";
    } else {
   
        $conn->query("INSERT INTO pacientes (nombre, telefono, correo) VALUES ('$nombre', '$telefono', '$correo')");
        $paciente_id = $conn->insert_id;

        $conn->query("INSERT INTO citas (paciente_id, fecha, hora, sala, servicio_id) VALUES ('$paciente_id', '$fecha', '$hora', '$sala', '$servicio_id')");

        echo "<script>alert('Cita agendada con éxito'); window.location.href='recibo.php?id={$paciente_id}';</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar Cita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Agendar Cita</h2>
    <form method="post">
        <div class="mb-3">
            <label class="form-label">Nombre:</label>
            <input type="text" class="form-control" name="nombre" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Teléfono:</label>
            <input type="text" class="form-control" name="telefono" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Correo:</label>
            <input type="email" class="form-control" name="correo" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Fecha:</label>
            <input type="date" class="form-control" name="fecha" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Hora:</label>
            <input type="time" class="form-control" name="hora" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Sala:</label>
            <select class="form-control" name="sala">
                <?php foreach ($salas_result as $sala_option): ?>
                    <option value="<?php echo $sala_option; ?>"><?php echo $sala_option; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Servicio:</label>
            <select class="form-control" name="servicio" required>
                <?php while ($servicio = $servicios_result->fetch_assoc()): ?>
                    <option value="<?php echo $servicio['id']; ?>"><?php echo $servicio['nombre']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Agendar</button>
        <a href="dashboard.php" class="btn btn-secondary">Volver</a>
    </form>
</body>
</html>
