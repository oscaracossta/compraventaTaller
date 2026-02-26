<?php 
session_start(); 
include 'db.php';  

// Consulta con JOIN para traer los datos del coche y el nombre del vendedor
$query = "SELECT cars.*, users.name as Vendedor 
        from cars 
        join users on cars.user_id = users.id 
        where status = 'Público' 
        order by created_at desc";
$resultado = mysqli_query($conexion, $query);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PostCenter - Ventas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="styles/style.css">
</head>
<body class="bg-white"> 

<nav class="navbar navbar-light bg-white shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="compraventa.php">
            POSTCENTER <span class="text-primary">COMPRAVENTA</span>
        </a>
        <button class="btn border-0" data-bs-toggle="offcanvas" data-bs-target="#adminDrawer">
            <i class="bi bi-person-circle fs-4"></i>
        </button>
    </div>
</nav>

<main class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Vehículos <span class="text-primary">en venta</span></h2>
    </div>

    <div class="row g-4" id="contenedor-coches">
    <?php 
    while($coche = mysqli_fetch_assoc($resultado)): 
        // 1. Procesar la cadena de fotos (extraemos la primera)
        $fotos = !empty($coche['main_photo']) ? explode(',', $coche['main_photo']) : [];
        $foto_portada = !empty($fotos) ? "img/" . $fotos[0] : "img/placeholder-coche.jpg"; // Imagen por defecto
    ?>
    <div class="col-12 col-md-6 col-lg-4 coche-item">
        <div class="card h-100 border-0 shadow-sm car-card">
            <div class="position-relative">
                <img src="<?php echo $foto_portada; ?>" 
                    class="card-img-top rounded-t-4" 
                    alt="<?php echo $coche['brand']; ?>"
                    style="height: 220px; object-fit: cover;">
                
                <span class="position-absolute top-0 end-0 m-3 badge bg-dark bg-opacity-75 rounded-pill">
                    <?php echo $coche['fuel_type']; ?>
                </span>
            </div>
            
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <h5 class="fw-bold mb-0"><?php echo $coche['brand'] . " " . $coche['model']; ?></h5>
                        <small class="text-muted text-uppercase fw-semibold" style="font-size: 0.7rem;">
                            <?php echo $coche['manufacture_year']; ?> • <?php echo number_format($coche['kms'], 0, '', '.'); ?> km
                        </small>
                    </div>
                    <h5 class="text-primary fw-bold mb-0"><?php echo number_format($coche['price'], 0, ',', '.'); ?>€</h5>
                </div>
                
                <hr class="my-3 opacity-25">
                
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">                          
                        <span class="small text-muted">Vendido por <strong><?php echo $coche['Vendedor'] ?? 'Particular'; ?></strong></span>
                    </div>
                    <a href="detalles_coche.php?id=<?php echo $coche['id']; ?>" class="btn btn-outline-dark btn-md rounded-pill px-4">
                        Ver Detalles
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php endwhile; ?>
</div>

<div id="loading" class="text-center my-4 d-none">
    <div class="spinner-border text-primary" role="status"></div>
</div>
</main>

<div class="offcanvas offcanvas-end" tabindex="-1" id="adminDrawer">
    <div class="offcanvas-header border-bottom">
        <h5 class="fw-bold mb-0">Mi Perfil</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body">
        <?php if (!isset($_SESSION['user_id'])): ?>

            <!-- <div class="mb-4">
                <p class="small fw-bold text-uppercase text-muted">Nueva Cuenta</p>
                <form action="session/registro_proceso.php" method="POST">
                    <input type="text" name="name" class="form-control mb-2" placeholder="Nombre completo" required>
                    <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
                    <input type="password" name="password" class="form-control mb-3" placeholder="Contraseña" required>
                    <button type="submit" class="btn btn-outline-dark w-100 fw-bold" disabled>REGISTRARME</button>
                </form>
            </div> -->

            <hr>

            <div>
                <p class="small fw-bold text-uppercase text-muted">INICIAR SESIÓN</p>
                <form action="session/login_proceso.php" method="POST">
                    <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
                    <input type="password" name="password" class="form-control mb-3" placeholder="Contraseña" required>
                    <button type="submit" class="btn btn-dark w-100 fw-bold">ACCEDER</button>
                </form>
            </div>

        <?php else: ?>
            <div class="text-center py-4">
                <div class="mb-4">
                    <p class="text-muted small mb-0">HOLA</p>
                    <h4 class="fw-bold"><?php echo $_SESSION['name']; ?></h4>
                </div>

                <div class="list-group list-group-flush text-start mb-4">
                    <a href="cars/panel.php" class="list-group-item list-group-item-action border-0 py-3 rounded-3 mb-2 shadow-sm">
                        <i class="bi bi-kanban me-2 text-primary"></i> 
                        <strong>Mis Vehículos</strong>
                    </a>
                </div>
                <hr class="my-4 opacity-25">
                <a href="session/logout.php" class="btn btn-outline-danger w-100 fw-bold rounded-pill">
                    <i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
    <div class="modal fade" id="modalNuevoCoche" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0">
                <h5 class="fw-bold">Publicar Vehículo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formNuevoCoche">
                    <div class="row mb-3">
                        <div class="col">
                            <input type="text" name="brand" class="form-control" placeholder="Marca" required>
                        </div>
                        <div class="col">
                            <input type="text" name="model" class="form-control" placeholder="Modelo" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <label class="small fw-bold text-muted mb-1">Combustible</label>
                            <select name="fuel_type" class="form-select" required>
                                <option value="Gasolina">Gasolina</option>
                                <option value="Diésel">Diésel</option>
                                <option value="Híbrido">Híbrido</option>
                                <option value="Híbrido Enchufable">Híbrido Enchufable</option>
                                <option value="Eléctrico">Eléctrico</option>
                            </select>
                        </div>
                        <div class="col">
                            <label class="small fw-bold text-muted mb-1">Caja de Cambios</label>
                            <select name="gears" class="form-select" required>
                                <option value="Manual">Manual</option>
                                <option value="Automático">Automático</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <input type="text" name="year" class="form-control" placeholder="Año" inputmode="numeric" maxlength="4" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
                        </div>
                        <div class="col">
                            <input type="text" name="kms" class="form-control" placeholder="Km" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <input type="text" name="price" class="form-control form-control-lg fw-bold" placeholder="Precio (€)" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 fw-bold py-2 rounded-pill" id="btnPublicar">
                        <span id="btnTexto">CREAR AHORA</span>
                        <div id="btnCarga" class="spinner-border spinner-border-sm d-none" role="status"></div>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div> 

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> 

</body>
</html>