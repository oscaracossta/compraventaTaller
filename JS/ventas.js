// JS/ventas.js

// 1. Previsualización de imágenes antes de subir
document.getElementById('fotosInput').addEventListener('change', function(e) {
    const contenedor = document.getElementById('previsualizacion');
    contenedor.innerHTML = ''; // Limpiar anterior
    
    Array.from(this.files).forEach(file => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.classList.add('rounded', 'border');
            img.style.width = '60px';
            img.style.height = '60px';
            img.style.objectFit = 'cover';
            contenedor.appendChild(img);
        }
        reader.readAsDataURL(file);
    });
});

// 2. Envío del formulario (Sustituye la lógica que tenías en panel.php)
document.getElementById('formNuevoCoche').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const btnTexto = document.getElementById('btnTexto');
    const btnCarga = document.getElementById('btnCarga');
    const formData = new FormData(this); // FormData captura automáticamente archivos y textos

    btnTexto.classList.add('d-none');
    btnCarga.classList.remove('d-none');

    // La ruta es 'crear_coche.php' porque panel.php y crear_coche.php están en la misma carpeta /cars/
    fetch('crear_coche.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.text())
    .then(data => {
        if (data.trim() === "success") {
            lanzarAviso("¡Vehículo y fotos guardados!", "success");
            setTimeout(() => location.reload(), 1500);
        } else {
            lanzarAviso("Error: " + data, "danger");
            btnTexto.classList.remove('d-none');
            btnCarga.classList.add('d-none');
        }
    })
    .catch(error => {
        lanzarAviso("Error de conexión", "danger");
    });
});