<?php
include '../db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $pass  = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $resultado = mysqli_query($conexion, $sql);
    $usuario = mysqli_fetch_assoc($resultado);

    if ($usuario && password_verify($pass, $usuario['password'])) {
        $_SESSION['user_id'] = $usuario['id'];
        $_SESSION['name']    = $usuario['name'];
        $_SESSION['rol']     = $usuario['rol'];

        header("Location: ../compraventa.php");
        exit();
    } else {
        echo "<script>alert('Datos incorrectos'); window.location.href='../compraventa.php';</script>";
    }
}
?>