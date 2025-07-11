import "./bootstrap";

// O auth.js pode ser importado aqui se ele tiver lógicas independentes
// que não dependem da inicialização de componentes.
import "./auth.js";

// Inicializa todos os toasts que estiverem na página
document.addEventListener("DOMContentLoaded", function () {
    const toastElList = [].slice.call(document.querySelectorAll(".toast"));
    const toastList = toastElList.map(function (toastEl) {
        // Usa a instância global do Bootstrap, que é a forma correta
        return new window.bootstrap.Toast(toastEl);
    });
    // Mostra cada toast.
    toastList.forEach((toast) => toast.show());
});
