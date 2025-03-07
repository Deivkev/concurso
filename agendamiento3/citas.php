<?php
include 'conexion.php'; 

// Eliminar una cita
if (isset($_GET['eliminar'])) {
    $cita_id = intval($_GET['eliminar']);
    
    if ($conn->query("DELETE FROM citas WHERE id = $cita_id")) {
        header("Location: citas.php?msg=deleted");
        exit();
    } else {
        echo "<script>alert('Error al eliminar la cita: " . $conn->error . "'); window.location.href='citas.php';</script>";
    }
}

// Editar una cita
if (isset($_POST['editar'])) {
    $cita_id = intval($_POST['id']);
    $fecha = $conn->real_escape_string($_POST['fecha']);
    $hora = $conn->real_escape_string($_POST['hora']);
    $sala = $conn->real_escape_string($_POST['sala']);
    $servicio_id = intval($_POST['servicio_id']);

    // Validar que la fecha y hora no sean pasadas
    $fecha_actual = date('Y-m-d');
    $hora_actual = date('H:i');

    if ($fecha < $fecha_actual || ($fecha == $fecha_actual && $hora <= $hora_actual)) {
        echo "<script>alert('No se puede editar una cita a una fecha o hora pasada.'); window.location.href='citas.php';</script>";
    } else {
        if ($conn->query("UPDATE citas SET fecha = '$fecha', hora = '$hora', sala = '$sala', servicio_id = '$servicio_id' WHERE id = $cita_id")) {
            header("Location: citas.php?msg=updated");
            exit();
        } else {
            echo "<script>alert('Error al actualizar la cita: " . $conn->error . "'); window.location.href='citas.php';</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Citas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="container py-5">
    <h2 class="text-center mb-4">Citas Agendadas</h2>
    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Paciente</th>
                        <th>Teléfono</th>
                        <th>Correo</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Sala</th>
                        <th>Servicio</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Consulta SQL ordenada por fecha y hora
                    $result = $conn->query("SELECT c.id, p.nombre, p.telefono, p.correo, c.fecha, c.hora, c.sala, s.nombre AS servicio, c.estado 
                                            FROM citas c 
                                            JOIN pacientes p ON c.paciente_id = p.id
                                            JOIN servicios s ON c.servicio_id = s.id
                                            ORDER BY c.fecha DESC, c.hora DESC");

                    while ($row = $result->fetch_assoc()) {
                        $cita_id = $row['id'];
                        $estado_button = $row['estado'] === 'Pendiente' ? 
                                         "<a href='#' class='btn btn-warning btn-sm' onclick='cambiarEstado($cita_id)'>Marcar como Atendido</a>" : 
                                         "<span class='text-success'>Atendido</span>";

                        echo "<tr id='cita_$cita_id'>
                                <td>{$row['nombre']}</td>
                                <td>{$row['telefono']}</td>
                                <td>{$row['correo']}</td>
                                <td>{$row['fecha']}</td>
                                <td>{$row['hora']}</td>
                                <td>{$row['sala']}</td>
                                <td>{$row['servicio']}</td>
                                <td id='estado_$cita_id'>{$row['estado']}</td>
                                <td>
                                    <button type='button' class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#editarModal{$cita_id}'>Editar</button>
                                    <a href='?eliminar=$cita_id' class='btn btn-danger btn-sm' onclick='return confirm(\"¿Estás seguro de que deseas eliminar esta cita?\");'>Eliminar</a>
                                    $estado_button
                                </td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <a href="dashboard.php" class="btn btn-secondary mt-3">Volver</a>

    <!-- Modal de edición -->
    <?php
    $result = $conn->query("SELECT c.id, p.nombre, c.fecha, c.hora, c.sala, s.id AS servicio_id, s.nombre AS servicio 
                            FROM citas c 
                            JOIN pacientes p ON c.paciente_id = p.id
                            JOIN servicios s ON c.servicio_id = s.id");

    while ($row = $result->fetch_assoc()) {
        $cita_id = $row['id'];
        ?>
        <div class="modal fade" id="editarModal<?php echo $cita_id; ?>" tabindex="-1" aria-labelledby="editarModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editarModalLabel">Editar Cita</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="citas.php" method="POST">
                            <input type="hidden" name="id" value="<?php echo $cita_id; ?>">
                            <div class="mb-3">
                                <label for="fecha" class="form-label">Fecha</label>
                                <input type="date" class="form-control" name="fecha" value="<?php echo $row['fecha']; ?>" required min="<?php echo date('Y-m-d'); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="hora" class="form-label">Hora</label>
                                <input type="time" class="form-control" name="hora" value="<?php echo $row['hora']; ?>" required min="<?php echo date('H:i'); ?>">
                            </div>
                            <div class="mb-3">
                                <label for="sala" class="form-label">Sala</label>
                                <input type="text" class="form-control" name="sala" value="<?php echo $row['sala']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="servicio" class="form-label">Servicio</label>
                                <select class="form-select" name="servicio_id" required>
                                    <?php
                                    $servicios_result = $conn->query("SELECT * FROM servicios");
                                    while ($servicio = $servicios_result->fetch_assoc()) {
                                        $selected = ($row['servicio_id'] === $servicio['id']) ? 'selected' : '';
                                        echo "<option value='{$servicio['id']}' $selected>{$servicio['nombre']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <button type="submit" name="editar" class="btn btn-primary w-100">Guardar cambios</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>

    <script>
    function cambiarEstado(cita_id) {
        $.ajax({
            url: 'cambiar_estado.php',
            method: 'GET',
            data: { id: cita_id },
            success: function(response) {
                if (response.trim() === 'success') {
                    $('#estado_' + cita_id).html('Atendido');
                    $('a[onclick="cambiarEstado(' + cita_id + ')"]').replaceWith('<span class="text-success">Atendido</span>');
                } else {
                    alert('Error al actualizar el estado.');
                }
            }
        });
    }
    </script>
</body>
</html>
