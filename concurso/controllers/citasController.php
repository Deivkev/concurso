<?php
require_once('../models/cita.php');

class CitasController {
    public function agregarCita($id_usuario, $id_doctor, $fecha_hora, $estado, $descripcion, $id_servicio) {
        $cita = new Cita();
        $cita->agregarCita($id_usuario, $id_doctor, $fecha_hora, $estado, $descripcion, $id_servicio);
    }

    public function eliminarCita($id_cita) {
        $cita = new Cita();
        $cita->eliminarCita($id_cita);
    }

    public function editarCita($id_cita, $id_usuario, $id_doctor, $fecha_hora, $estado, $descripcion, $id_servicio) {
        $cita = new Cita();
        $cita->editarCita($id_cita, $id_usuario, $id_doctor, $fecha_hora, $estado, $descripcion, $id_servicio);
    }
}
?>
