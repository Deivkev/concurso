
<?php
include 'conexion.php';

if (isset($_GET['id'])) {
    $cita_id = $_GET['id'];

    // Cambiar el estado de la cita a "Atendido"
    $conn->query("UPDATE citas SET estado = 'Atendido' WHERE id = $cita_id");

    echo 'success'; // Retornar éxito si la actualización fue correcta
}
?>
