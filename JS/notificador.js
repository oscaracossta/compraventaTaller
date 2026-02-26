function lanzarAviso(mensaje, tipo = 'success') {
    let toastContainer = document.querySelector('.toast-container');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.className = "toast-container position-fixed top-0 end-0 p-3";
        toastContainer.style.zIndex = "1100";
        document.body.appendChild(toastContainer);
    }

    const toastId = 'toast-' + Date.now();
    const bgClass = tipo === 'success' ? 'bg-success' : (tipo === 'danger' ? 'bg-danger' : 'bg-primary');
    
    const toastHTML = `
        <div id="${toastId}" class="toast align-items-center text-white ${bgClass} border-0 shadow-lg" role="alert">
            <div class="d-flex">
                <div class="toast-body fw-bold">
                    <i class="bi bi-info-circle me-2"></i> ${mensaje}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>`;
    
    toastContainer.insertAdjacentHTML('beforeend', toastHTML);
    const toastEl = document.getElementById(toastId);
    const bsToast = new bootstrap.Toast(toastEl, { delay: 3000 });
    bsToast.show();

    toastEl.addEventListener('hidden.bs.toast', () => toastEl.remove());
}

function confirmarAccion(titulo, mensaje, callback) {
    const modalId = 'modalConfirmSimple';
    let modalEl = document.getElementById(modalId);

    if (!modalEl) {
        const html = `
        <div class="modal fade" id="${modalId}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content border-0 shadow-lg rounded-4">
                    <div class="modal-body text-center p-4">
                        <i class="bi bi-exclamation-triangle text-danger display-4"></i>
                        <h5 class="fw-bold mt-3" id="confirmTitle"></h5>
                        <p class="text-muted small" id="confirmText"></p>
                        <div class="d-flex gap-2 mt-4">
                            <button class="btn btn-light rounded-pill w-100" data-bs-dismiss="modal">No</button>
                            <button class="btn btn-danger rounded-pill w-100 fw-bold" id="confirmBtnOk">Sí, eliminar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>`;
        document.body.insertAdjacentHTML('beforeend', html);
        modalEl = document.getElementById(modalId);
    }

    document.getElementById('confirmTitle').innerText = titulo;
    document.getElementById('confirmText').innerText = mensaje;
    
    const btnOk = document.getElementById('confirmBtnOk');

    const newBtnOk = btnOk.cloneNode(true);
    btnOk.parentNode.replaceChild(newBtnOk, btnOk);

    const bsModal = new bootstrap.Modal(modalEl);
    
    newBtnOk.onclick = () => {
        callback();
        bsModal.hide();
    };

    bsModal.show();
}