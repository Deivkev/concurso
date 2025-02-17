
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
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php
       
            if (isset($_POST['atender'])) {
                $cita_id = $_POST['cita_id'];

                $query = "UPDATE citas SET estado = 'Atendida' WHERE id = '$cita_id'";

                if ($conn->query($query)) {
                  
                    echo "<script>
                            setTimeout(function() {
                                window.location.reload(); // Recarga la página después de 1 minuto.
                            }, 60000); // 60000 milisegundos = 1 minuto
                          </script>";
                } else {
                    echo "<script>alert('Error al actualizar el estado de la cita');</script>";
                }
            }

          
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
                        <td>";

             
                if ($row['estado'] != 'Atendida') {
                    echo "<form method='POST'>
                            <input type='hidden' name='cita_id' value='{$row['id']}'>
                            <button type='submit' name='atender' class='btn btn-success'>Atender</button>
                          </form>";
                }
                echo "</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <a href="dashboard.php" class="btn btn-secondary">Volver</a>
</body>
</html>

