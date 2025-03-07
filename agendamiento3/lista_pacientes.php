<?php 
include 'conexion.php';

if (isset($_GET['eliminar_id'])) {
    $id = $_GET['eliminar_id'];
    $sql = "DELETE FROM pacientes WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Paciente eliminado exitosamente.";
        header("Location: lista_pacientes.php");
    } else {
        echo "Error al eliminar el paciente: " . $conn->error;
    }
}

if (isset($_POST['editar_id'])) {
    $id = $_POST['editar_id'];
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];

    $sql = "UPDATE pacientes SET nombre = '$nombre', telefono = '$telefono', correo = '$correo' WHERE id = $id";
    
    if ($conn->query($sql) === TRUE) {
        echo "Paciente actualizado exitosamente.";
        header("Location: lista_pacientes.php");
    } else {
        echo "Error al actualizar el paciente: " . $conn->error;
    }
}

$result = $conn->query("SELECT * FROM pacientes");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Pacientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table th, .table td {
            vertical-align: middle;
        }
        .btn-action {
            min-width: 100px;
        }
        .modal-header {
            background-color: #007bff;
            color: white;
        }
        .modal-body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 1200px;
        }
    </style>
</head>
<body class="container py-5">
    <h2 class="text-center mb-4">Lista de Pacientes</h2>

    <?php if (isset($_GET['editar_id'])): ?>
        <?php
            $editar_id = $_GET['editar_id'];
            $result_edit = $conn->query("SELECT * FROM pacientes WHERE id = $editar_id");
            $row_edit = $result_edit->fetch_assoc();
        ?>
        <h3 class="text-center mb-3">Editar Paciente</h3>
        <form method="POST" class="shadow p-4 rounded bg-light">
            <input type="hidden" name="editar_id" value="<?= $row_edit['id'] ?>">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?= $row_edit['nombre'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" value="<?= $row_edit['telefono'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="correo" class="form-label">Correo</label>
                <input type="email" class="form-control" id="correo" name="correo" value="<?= $row_edit['correo'] ?>" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Actualizar Paciente</button>
            <a href="lista_pacientes.php" class="btn btn-secondary w-100 mt-2">Cancelar</a>
        </form>
        <hr>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Nombre</th>
                        <th>Teléfono</th>
                        <th>Correo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['nombre'] ?></td>
                            <td><?= $row['telefono'] ?></td>
                            <td><?= $row['correo'] ?></td>
                            <td>
                                <a href="lista_pacientes.php?editar_id=<?= $row['id'] ?>" class="btn btn-warning btn-sm btn-action">Editar</a>
                                <a href="lista_pacientes.php?eliminar_id=<?= $row['id'] ?>" class="btn btn-danger btn-sm btn-action" onclick="return confirm('¿Seguro que deseas eliminar este paciente?');">Eliminar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-between mt-4">
        <a href="dashboard.php" class="btn btn-secondary">Volver</a>
        <a href="agregar_paciente.php" class="btn btn-success">Agregar Paciente</a>
    </div>
</body>
</html>
