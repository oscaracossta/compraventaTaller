<?php
session_start();
include '../db.php';

// 1. Validar seguridad
if (!isset($_GET['id']) || !isset($_SESSION['user_id'])) {
    header("Location: panel.php");
    exit();
}

$id_coche = $_GET['id'];
$mi_id = $_SESSION['user_id'];

// 2. Obtener datos actuales
$query = "SELECT * FROM cars WHERE id = '$id_coche' AND user_id = '$mi_id'";
$resultado = mysqli_query($conexion, $query);
$coche = mysqli_fetch_assoc($resultado);

if (!$coche) {
    header("Location: panel.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Vehículo | PostCenter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../styles/style.css">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <a href="panel.php" class="btn btn-link text-decoration-none text-muted mb-3 p-0">
                <i class="bi bi-arrow-left"></i> Volver al panel
            </a>

            <div class="card shadow-sm border-0 rounded-4 p-4">
                <h3 class="fw-bold mb-4">Editar <span class="text-primary">Detalles</span></h3>
                
                <form action="actualizar_coche.php" method="POST" enctype="multipart/form-data">
                    
                    <input type="hidden" name="id_coche" value="<?php echo $coche['id']; ?>">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">MARCA</label>
                            <input type="text" name="brand" class="form-control" value="<?php echo $coche['brand']; ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">MODELO</label>
                            <input type="text" name="model" class="form-control" value="<?php echo $coche['model']; ?>" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">PRECIO (€)</label>
                            <input type="number" name="price" class="form-control" value="<?php echo $coche['price']; ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">KILÓMETROS</label>
                            <input type="number" name="kms" class="form-control" value="<?php echo $coche['kms']; ?>" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">COMBUSTIBLE</label>
                            <select name="fuel_type" class="form-select">
                                <option value="Diésel" <?php if($coche['fuel_type'] == 'Diésel') echo 'selected'; ?>>Diésel</option>
                                <option value="Gasolina" <?php if($coche['fuel_type'] == 'Gasolina') echo 'selected'; ?>>Gasolina</option>
                                <option value="Híbrido" <?php if($coche['fuel_type'] == 'Híbrido') echo 'selected'; ?>>Híbrido</option>
                                <option value="Híbrido Enchufable" <?php if($coche['fuel_type'] == 'Híbrido Enchufable') echo 'selected'; ?>>Híbrido Enchufable</option>
                                <option value="Eléctrico" <?php if($coche['fuel_type'] == 'Eléctrico') echo 'selected'; ?>>Eléctrico</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">AÑO DE FABRICACIÓN</label>
                            <input type="number" name="year" class="form-control" value="<?php echo $coche['manufacture_year']; ?>" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted">DESCRIPCIÓN / COMENTARIOS</label>
                        <textarea name="description" class="form-control" rows="4" placeholder="Detalles adicionales..."><?php echo $coche['description']; ?></textarea>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end border-top pt-4">
                        <a href="panel.php" class="btn btn-light rounded-pill px-4">Cancelar</a>
                        <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold shadow-sm">
                            <i class="bi bi-check-lg me-1"></i> GUARDAR CAMBIOS
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>