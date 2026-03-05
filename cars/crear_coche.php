<?php
session_start();
include '../db.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    
    $brand     = mysqli_real_escape_string($conexion, $_POST['brand']);
    $model     = mysqli_real_escape_string($conexion, $_POST['model']);
    $price     = mysqli_real_escape_string($conexion, $_POST['price']);
    $kms       = mysqli_real_escape_string($conexion, $_POST['kms']);
    $gears     = mysqli_real_escape_string($conexion, $_POST['gears']);
    $year      = mysqli_real_escape_string($conexion, $_POST['year']);
    $fuel_type = mysqli_real_escape_string($conexion, $_POST['fuel_type']);
    $description = mysqli_real_escape_string($conexion, $_POST['description']);
    $status = "Público"; 

    $nombres_imagenes = [];
    if (isset($_FILES['fotos']) && !empty($_FILES['fotos']['name'][0])) {
        foreach ($_FILES['fotos']['tmp_name'] as $key => $tmp_name) {
            if ($_FILES['fotos']['error'][$key] === 0) {
                $ext = pathinfo($_FILES['fotos']['name'][$key], PATHINFO_EXTENSION);
                $nuevo_nombre = time() . "_" . bin2hex(random_bytes(4)) . "." . $ext;
                if (move_uploaded_file($tmp_name, "../img/" . $nuevo_nombre)) {
                    $nombres_imagenes[] = $nuevo_nombre;
                }
            }
        }
    }
    $fotos_db = implode(",", $nombres_imagenes);

    $sql = "INSERT INTO cars (brand, model, price, user_id, kms, gears, manufacture_year, fuel_type, description, status, main_photo) 
            VALUES ('$brand', '$model', '$price', '$user_id', '$kms', '$gears', '$year', '$fuel_type', '$description', '$status', '$fotos_db')";

    if (mysqli_query($conexion, $sql)) {
        echo "success"; 
    } else {
        echo "Error: " . mysqli_error($conexion);
    }
}
?>