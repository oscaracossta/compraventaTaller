<?php
include '../db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    
    $id_coche = $_POST['id_coche'];
    $id_usuario = $_SESSION['user_id'];

    $sql = "DELETE FROM cars WHERE id = '$id_coche' AND user_id = '$id_usuario'";

    if (mysqli_query($conexion, $sql)) {
        header("Location: panel.php?status=deleted");
    } else {
        echo "Error al eliminar: " .mysqli_error($conexion);
    }
} else {
    header("Location: ../compraventa.php");
}
?>