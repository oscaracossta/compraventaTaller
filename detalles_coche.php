<?php
include 'db.php'; 

if (!isset($_GET['id'])) {
    header("Location: compraventa.php");
    exit();
}

$id = mysqli_real_escape_string($conexion, $_GET['id']);

$query = "SELECT * FROM cars WHERE id = '$id'";
$resultado = mysqli_query($conexion, $query);
$coche = mysqli_fetch_assoc($resultado);

if (!$coche) { echo "Vehículo no encontrado."; exit(); }

$fotos = !empty($coche['main_photo']) ? explode(',', $coche['main_photo']) : [];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo $coche['brand'] . " " . $coche['model']; ?> | Detalles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .foto-principal { height: 500px; object-fit: cover; border-radius: 15px; }
        .foto-galeria { height: 150px; object-fit: cover; cursor: pointer; transition: 0.3s; border-radius: 10px; }
        .foto-galeria:hover { opacity: 0.8; transform: scale(1.05); }
        .info-card { border: none; border-radius: 15px; background: #f8f9fa; }
    </style>
</head>
<body class="bg-light">

<div class="container py-5">
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-5">
        <div class="container">
            <a class="navbar-brand fw-bold" href="compraventa.php">
                <i class="bi bi-arrow-left-circle me-2"></i> Volver a la Tienda
            </a>
        </div>
    </nav>

    <div class="row g-5">
        <div class="col-lg-7">
            <img src="img/<?php echo $fotos[0] ?? 'placeholder.jpg'; ?>" class="w-100 foto-principal shadow-sm mb-3" id="mainDisplay">
            
            <div class="row g-2">
                <?php foreach($fotos as $index => $foto): ?>
                    <div class="col-3">
                        <img src="img/<?php echo $foto; ?>" class="w-100 foto-galeria shadow-sm" onclick="document.getElementById('mainDisplay').src=this.src">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="p-4 bg-white shadow-sm rounded-4 h-100">
                <h1 class="fw-bold mb-1"><?php echo $coche['brand']; ?></h1>
                <h2 class="text-muted mb-4"><?php echo $coche['model']; ?></h2>
                
                <div class="d-flex align-items-center mb-4">
                    <span class="display-5 fw-bold text-primary"><?php echo number_format($coche['price'], 0, ',', '.'); ?>€</span>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-6">
                        <div class="info-card p-3">
                            <small class="text-muted d-block">Kilómetros</small>
                            <span class="fw-bold"><?php echo number_format($coche['kms'], 0, '', '.'); ?> km</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="info-card p-3">
                            <small class="text-muted d-block">Año</small>
                            <span class="fw-bold"><?php echo $coche['manufacture_year']; ?></span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="info-card p-3">
                            <small class="text-muted d-block">Combustible</small>
                            <span class="fw-bold"><?php echo $coche['fuel_type']; ?></span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="info-card p-3">
                            <small class="text-muted d-block">Transmisión</small>
                            <span class="fw-bold"><?php echo $coche['gears']; ?></span>
                        </div>
                    </div> 
                    <div class="mt-4 p-3 bg-light rounded-4">
                        <h5>Descripción del vehículo</h5>
                        <p><?php echo nl2br($coche['description']); ?></p>
                    </div>
                </div>

                <!-- <button class="btn btn-dark w-100 py-3 rounded-pill fw-bold mb-3">
                    <i class="bi bi-chat-dots me-2"></i> CONTACTAR VENDEDOR
                </button> -->
            </div>
        </div>
    </div>
</div>
</body>
</html>