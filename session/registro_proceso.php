<?php
include '../db.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre   = $_POST['name']; 
    $email    = $_POST['email'];
    $password = $_POST['password'];

    $password_encriptada = password_hash($password, PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (name, email, password, rol) 
            VALUES ('$nombre', '$email', '$password_encriptada', 'vendedor')";

    if (mysqli_query($conexion, $sql)) {
        header("Location: ../compraventa.php?registro=ok");
        exit();
    } else {
        echo "❌ Error al registrar: " . mysqli_error($conexion);
    }
}
?>