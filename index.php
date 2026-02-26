<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PostCenter Canarias</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <link rel="stylesheet" href="styles/style.css">
    
    <link rel="icon" type="image/jpg" href="img/icon.png">
    <link rel="apple-touch-icon" href="img/logo.jpg">
</head>
<body class="bg-white">  
    <!-- LOGO más importante -->
    <header class="pc-header sticky-top bg-white">
        <div class="container d-flex align-items-center justify-content-between py-2">
            <div class="p-2">
                <img src="img/logo.jpg" alt="PostCenter" style="height: 95px;">
            </div>
            <nav>
                <ul class="nav">
                    <li class="nav-item"><a class="nav-link pc-nav-link" href="#nosotros">Sobre Nosotros</a></li>
                    <li class="nav-item"><a class="nav-link pc-nav-link" href="#servicios">Servicios</a></li>
                    <li class="nav-item"><a class="nav-link pc-nav-link" href="#contacto">Contacto</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container py-5"> 
        
    </main> 
 
    <!-- Cambiar percepción del Texto -->
    <section class="pc-section" id="nosotros">
        <div class="container text-center">
            <h2 class="display-6 fw-bold mb-4">Acerca de nosotros</h2>
            <p class="lead text-muted mx-auto" style="max-width: 800px;">
                En MotorCenter Canarias llevanis dedicándonos a arreglar y mantener tu vehículo desde 2009, contamos con más de 15 años dedicados a cuidar de miles de vehículos de diferentes tipos.
            </p>
        </div>
    </section>

    <section class="pc-section" id="servicios">
        <div class="container">
            <h2 class="display-6 fw-bold text-center mb-5">Nuestros Servicios</h2>
            <div class="row g-4">
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="pc-service-card shadow-sm">
                        <img src="img/mecanica.jpg" alt="Mecánica General" class="pc-service-img">
                        <div class="pc-service-overlay"><h3 class="h5 fw-bold mb-0">Mecánica General</h3></div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="pc-service-card shadow-sm">
                        <img src="img/chapa.jpg" alt="Chapa" class="pc-service-img">
                        <div class="pc-service-overlay"><h3 class="h5 fw-bold mb-0">Chapa y Pintura</h3></div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="pc-service-card shadow-sm">
                        <img src="img/neumatico.jpg" alt="Pintura" class="pc-service-img">
                        <div class="pc-service-overlay"><h3 class="h5 fw-bold mb-0">Neumáticos</h3></div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="pc-service-card shadow-sm">
                        <img src="img/electro.jpg" alt="Electrónica" class="pc-service-img">
                        <div class="pc-service-overlay"><h3 class="h5 fw-bold mb-0">Electricidad</h3></div> 
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="pc-service-card shadow-sm">
                        <img src="img/rapida.jpg" alt="Aire Acondicionado" class="pc-service-img">
                        <div class="pc-service-overlay"><h3 class="h5 fw-bold mb-0">Mecánica Rápida</h3></div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="pc-service-card shadow-sm">
                        <img src="img/caravana.jpg" alt="Autocaravanas" class="pc-service-img">
                        <div class="pc-service-overlay"><h3 class="h5 fw-bold mb-0">Autocaravanas</h3></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="pc-section border-top" id="contacto">
        <div class="container">
            <h2 class="display-6 fw-bold text-center mb-5">Contáctenos</h2>
            <div class="row g-4">
                <div class="col-12 col-md-6 col-lg-3 d-flex align-items-center">
                    <div class="pc-icon-circle me-3"><i class="bi bi-telephone-fill fs-5"></i></div>
                    <div><span class="d-block fw-bold">Teléfonos</span><small class="text-muted">+34 928 15 65 76</small><br><small class="text-muted">+34 615 305 634</small></div>
                </div>
                <div class="col-12 col-md-6 col-lg-3 d-flex align-items-center">
                    <div class="pc-icon-circle me-3"><i class="bi bi-envelope-at-fill fs-5"></i></div>
                    <div><span class="d-block fw-bold">Email</span><a href="mailto:taller@postcenter.es" class="text-decoration-none text-muted small">taller@postcenter.es</a></div>
                </div>
                <div class="col-12 col-md-6 col-lg-3 d-flex align-items-center">
                    <div class="pc-icon-circle me-3"><i class="bi bi-geo-alt-fill fs-5"></i></div>
                    <div><span class="d-block fw-bold">Dirección</span><address class="text-muted mb-0 small">Calle Brasil 10, Vecindario</address></div>
                </div>
                <div class="col-12 col-md-6 col-lg-3 d-flex align-items-center">
                    <div class="pc-icon-circle me-3"><i class="bi bi-clock-fill fs-5"></i></div>
                    <div><span class="d-block fw-bold">Horario</span><small class="text-muted">Lun - Jue: 08:00 a 17:00</small><br><small class="text-muted">Vie: 08:00 a 16:00</small></div>
                </div>
            </div>
            <div class="text-center mt-5">
                <a href="https://wa.me/34615305634" class="btn btn-dark btn-lg rounded-pill px-5 shadow-sm" target="_blank">
                    <i class="bi bi-whatsapp me-2"></i>Escríbenos por WhatsApp
                </a>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>