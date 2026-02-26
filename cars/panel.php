<?php
session_start();
include '../db.php'; 

if (!isset($_SESSION['user_id'])) {
    header("Location: ../compraventa.php");
    exit();
}

$mi_id = $_SESSION['user_id'];

// Consulta mejorada para obtener los vehículos del usuario
$query = "SELECT * FROM cars WHERE user_id = '$mi_id' ORDER BY created_at DESC";
$resultado = mysqli_query($conexion, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Vehículos | Panel de Control</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../styles/style.css">
</head>

<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-5">
        <div class="container">
            <a class="navbar-brand fw-bold" href="../compraventa.php">
                <i class="bi bi-arrow-left-circle me-2"></i> Volver a la Tienda
            </a>
        </div>
    </nav>

    <main class="container">
        <div class="row mb-4 align-items-center">
            <div class="col-md-6">
                <h2 class="fw-bold m-0">Gestionar <span class="text-primary">Mis Vehículos</span></h2>
            </div>
            <div class="col-md-6 text-md-end">
                <button class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalSubir">
                    <i class="bi bi-plus-lg me-2"></i> NUEVA PUBLICACIÓN
                </button>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-white border-bottom">
                        <tr class="text-muted small text-uppercase">
                            <th class="ps-4 py-3">Vehículo</th>
                            <th>Estado Actual</th>
                            <th>Precio Venta</th>
                            <th class="text-end pe-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($resultado) > 0): ?>
                            <?php while($coche = mysqli_fetch_assoc($resultado)): 
                                $id_coche   = $coche['id'];
                                $nombre     = $coche['brand'] . " " . $coche['model'];
                                $info_extra = $coche['manufacture_year'] . " - " . $coche['fuel_type'] . " " . number_format($coche['kms'], 0, '', '.') . " km";
                                $precio     = number_format($coche['price'], 0, ',', '.') . "€";
                                
                                $es_publico = ($coche['status'] == 'Público');
                                $btn_clase  = $es_publico ? 'btn-success' : 'btn-secondary';
                                $btn_icono  = $es_publico ? 'bi-eye-fill' : 'bi-eye-slash-fill';
                            ?>
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <div class="fw-bold text-dark h6 mb-0"><?php echo $nombre; ?></div>
                                                <div class="text-muted small"><?php echo $info_extra; ?></div>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <form action="cambiar_estado.php" method="POST">
                                            <input type="hidden" name="id_coche" value="<?php echo $id_coche; ?>">
                                            <button type="submit" class="btn btn-sm <?php echo $btn_clase; ?> rounded-pill px-3 fw-semibold border-0 shadow-sm">
                                                <i class="bi <?php echo $btn_icono; ?> me-1"></i>
                                                <?php echo $coche['status']; ?>
                                            </button>
                                        </form>
                                    </td>

                                    <td>
                                        <span class="fw-bold text-primary fs-5"><?php echo $precio; ?></span>
                                    </td>

                                    <td class="text-end pe-4">
                                        <form id="form-eliminar-<?php echo $id_coche; ?>" action="eliminar_coche.php" method="POST" class="d-inline">
                                            <input type="hidden" name="id_coche" value="<?php echo $id_coche; ?>">
                                            <button type="button" class="btn btn-outline-danger btn-sm border-0 rounded-circle p-2"
                                                onclick="confirmarAccion('¿Eliminar vehículo?', '¿Estás seguro de que quieres borrar el <?php echo $nombre; ?>? Esta acción es irreversible.', () => document.getElementById('form-eliminar-<?php echo $id_coche; ?>').submit())">
                                                <i class="bi bi-trash3 fs-5"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <i class="bi bi-info-circle fs-2 d-block mb-2"></i>
                                    No tienes vehículos publicados. ¡Empieza publicando uno!
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <div class="modal fade" id="modalSubir" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-0 ps-4 pt-4">
                    <h5 class="modal-title fw-bold">Nueva <span class="text-primary">Publicación</span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formNuevoCoche" enctype="multipart/form-data">
                    <div class="modal-body p-4">
                        <div class="row g-3"> 
                            <div class="col-12 mt-3">
                                <label class="form-label small fw-bold">Fotos del Vehículo (Máx. 5)</label>
                                <input type="file" name="fotos[]" id="fotosInput" class="form-control rounded-3" multiple accept="image/*">
                                <div id="preview-fotos" class="d-flex gap-2 mt-2 flex-wrap"></div>
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold">Marca</label>
                                <input type="text" name="brand" class="form-control rounded-3" placeholder="Ej: Toyota" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold">Modelo</label>
                                <input type="text" name="model" class="form-control rounded-3" placeholder="Ej: Corolla" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold">Kilómetros</label>
                                <input type="number" name="kms" class="form-control rounded-3" placeholder="0" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold">Año</label>
                                <input type="number" name="year" class="form-control rounded-3" value="2024" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold">Combustible</label>
                                <select name="fuel_type" class="form-select rounded-3">
                                    <option value="Gasolina">Gasolina</option>
                                    <option value="Diesel">Diesel</option>
                                    <option value="Híbrido">Híbrido</option>
                                    <option value="Híbrido Enchufable">Híbrido Enchufable</option>
                                    <option value="Eléctrico">Eléctrico</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold">Cambio</label>
                                <select name="gears" class="form-select rounded-3">
                                    <option value="Manual">Manual</option>
                                    <option value="Automático">Automático</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold">Precio (€)</label>
                                <input type="number" name="price" class="form-control rounded-3" placeholder="0" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pb-4 pe-4">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold" id="btnGuardar">
                            <span id="btnTexto">Publicar Vehículo</span>
                            <span id="btnCarga" class="d-none spinner-border spinner-border-sm"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> 
    <script src="../js/notificador.js"></script>

    <script>
    document.getElementById('formNuevoCoche').addEventListener('submit', function(e) {
    // 1. Evitamos que el formulario se envíe de la forma tradicional
    e.preventDefault();
    
    // 2. Referencias a elementos de la interfaz
    const btnGuardar = document.getElementById('btnGuardar');
    const btnTexto = document.getElementById('btnTexto');
    const btnCarga = document.getElementById('btnCarga');

    // 3. Bloqueo de seguridad: Si ya se está enviando, salimos
    if(btnGuardar.disabled) return;
    
    btnGuardar.disabled = true;
    btnTexto.classList.add('d-none');
    btnCarga.classList.remove('d-none');

    // 4. Captura de todos los datos (incluyendo fotos y fuel_type)
    const datos = new FormData(this); 

    // 5. Envío único al servidor
    fetch('crear_coche.php', {
        method: 'POST',
        body: datos
    })
    .then(res => res.text())
    .then(data => {
        if (data.trim() === "success") {
            // Cerramos modal si existe y lanzamos aviso
            const modalEl = document.getElementById('modalSubir');
            const modalBus = bootstrap.Modal.getInstance(modalEl);
            if(modalBus) modalBus.hide();
            
            lanzarAviso("¡Vehículo guardado correctamente!", "success");
            
            // Recarga limpia tras el éxito
            setTimeout(() => location.reload(), 1500);
        } else {
            // Si hay error, desbloqueamos para corregir
            lanzarAviso("Error: " + data, "danger");
            btnGuardar.disabled = false;
            btnTexto.classList.remove('d-none');
            btnCarga.classList.add('d-none');
        }
    })
    .catch(err => {
        lanzarAviso("Error de conexión con el servidor", "danger");
        btnGuardar.disabled = false;
        btnTexto.classList.remove('d-none');
        btnCarga.classList.add('d-none');
    });
});
</script>
</body>
</html>