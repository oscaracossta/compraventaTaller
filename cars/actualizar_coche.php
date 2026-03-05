<?php
session_start();
include '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    
    // ESTA ES LA LÍNEA QUE TE FALTA:
    $mi_id = $_SESSION['user_id']; 
    
    $id_coche = $_POST['id_coche']; 
    $brand    = mysqli_real_escape_string($conexion, $_POST['brand']);
    $model    = mysqli_real_escape_string($conexion, $_POST['model']);
    $price    = mysqli_real_escape_string($conexion, $_POST['price']);
    $kms      = mysqli_real_escape_string($conexion, $_POST['kms']);
    $fuel_type = mysqli_real_escape_string($conexion, $_POST['fuel_type']);
    $year     = mysqli_real_escape_string($conexion, $_POST['year']);
    $description = mysqli_real_escape_string($conexion, $_POST['description']);
    $gears    = mysqli_real_escape_string($conexion, $_POST['gears']);

    $sql = "UPDATE cars SET 
                brand = '$brand', 
                model = '$model', 
                price = '$price', 
                kms = '$kms', 
                fuel_type = '$fuel_type', 
                gears = '$gears', 
                manufacture_year = '$year', 
                description = '$description' 
            WHERE id = '$id_coche' AND user_id = '$mi_id'";

    if (mysqli_query($conexion, $sql)) {
        header("Location: panel.php?edit=success");
        exit(); 
    } else {
        echo "Error al actualizar: " . mysqli_error($conexion);
    }
} else {
    header("Location: panel.php?error=access");
    exit();
}
?>