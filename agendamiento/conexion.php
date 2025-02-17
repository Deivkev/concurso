<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "agendamiento";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$conn = new mysqli($host, $user, $pass, $dbname);
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    error_log("Error de conexión: " . $conn->connect_error);
    die("Hubo un problema con la conexión a la base de datos.");
}
?>
