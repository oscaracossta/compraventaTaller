<?php
include '../db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    
    $id_coche = $_POST['id_coche'];
    $id_usuario = $_SESSION['user_id'];

    $sql_busqueda = "SELECT status FROM cars WHERE id = '$id_coche' AND user_id = '$id_usuario'";
    $resultado = mysqli_query($conexion, $sql_busqueda);

    if (mysqli_num_rows($resultado) > 0) {
        $fila = mysqli_fetch_assoc($resultado);
        $estado_actual = $fila['status'];

        $nuevo_estado = ($estado_actual == 'Público') ? 'Privado' : 'Público';

        $sql_update = "UPDATE cars SET status = '$nuevo_estado' WHERE id = '$id_coche' AND user_id = '$id_usuario'";
        
        if (mysqli_query($conexion, $sql_update)) {
            header("Location: panel.php?update=success");
            exit();
        } else {
            echo "Error al actualizar el estado: " . mysqli_error($conexion);
        }
    } else {
        echo "No se encontró el vehículo o no tienes permiso.";
    }

} else {
    header("Location: ../compraventa.php");
    exit();
}
?>