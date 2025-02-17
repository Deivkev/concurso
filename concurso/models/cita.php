<?php
class Cita {
    public function agregarCita($id_usuario, $id_doctor, $fecha_hora, $estado, $descripcion, $id_servicio) {
        global $conn;
        $sql = "INSERT INTO citas (id_usuario, id_doctor, fecha_hora, estado, descripcion, id_servicio) 
                VALUES ('$id_usuario', '$id_doctor', '$fecha_hora', '$estado', '$descripcion', '$id_servicio')";
        return $conn->query($sql);
    }

    public function eliminarCita($id_cita) {
        global $conn;
        $sql = "DELETE FROM citas WHERE id_cita = '$id_cita'";
        return $conn->query($sql);
    }

    public function editarCita($id_cita, $id_usuario, $id_doctor, $fecha_hora, $estado, $descripcion, $id_servicio) {
        global $conn;
        $sql = "UPDATE citas SET 
                id_usuario = '$id_usuario', 
                id_doctor = '$id_doctor', 
                fecha_hora = '$fecha_hora', 
                estado = '$estado', 
                descripcion = '$descripcion', 
                id_servicio = '$id_servicio'
                WHERE id_cita = '$id_cita'";
        return $conn->query($sql);
    }
}
?>
