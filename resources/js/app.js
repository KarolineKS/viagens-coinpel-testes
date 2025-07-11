import "./bootstrap";

import * as bootstrap from "bootstrap/dist/js/bootstrap.bundle.min.js";

window.bootstrap = bootstrap;

import "./auth.js";

// Inicializa todos os toasts que estiverem na página
document.addEventListener("DOMContentLoaded", function () {
    const toastElList = [].slice.call(document.querySelectorAll(".toast"));
    const toastList = toastElList.map(function (toastEl) {
        // Cria uma nova instância do Toast, mas apenas se não houver uma já associada.
        return bootstrap.Toast.getOrCreateInstance(toastEl);
    });
    // Mostra cada toast.
    toastList.forEach((toast) => toast.show());
});
