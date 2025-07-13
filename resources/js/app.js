import "./bootstrap";

import "./auth.js";

document.addEventListener("DOMContentLoaded", function () {
    const toastElList = [].slice.call(document.querySelectorAll(".toast"));
    const toastList = toastElList.map(function (toastEl) {
        return new window.bootstrap.Toast(toastEl);
    });
    toastList.forEach((toast) => toast.show());
});

document.addEventListener("DOMContentLoaded", function () {
    const vehicleOffcanvas = document.getElementById("vehicleFormOffcanvas");

    if (vehicleOffcanvas) {
        // Abre automaticamente se tiver o atributo data-auto-open OU se houver erros de validação
        const hasValidationErrors = document.querySelector(
            ".alert-danger, .is-invalid"
        );
        const shouldAutoOpen =
            vehicleOffcanvas.dataset.autoOpen === "true" || hasValidationErrors;

        if (shouldAutoOpen) {
            const offcanvas = new bootstrap.Offcanvas(vehicleOffcanvas);
            offcanvas.show();

            // Foca no primeiro campo com erro após o offcanvas abrir
            setTimeout(() => {
                const firstErrorField =
                    vehicleOffcanvas.querySelector(".is-invalid");
                if (firstErrorField) {
                    firstErrorField.focus();
                    firstErrorField.scrollIntoView({
                        behavior: "smooth",
                        block: "center",
                    });
                }
            }, 300);
        }

        vehicleOffcanvas.addEventListener("hidden.bs.offcanvas", function () {
            const url = new URL(window.location);

            if (url.searchParams.has("edit")) {
                url.searchParams.delete("edit");
                window.location.href = url.toString();
            } else {
                // Reseta o formulário quando fechar (apenas para novo veículo)
                const form = document.getElementById("vehicleForm");
                if (form) {
                    form.reset();

                    // Remove classes de erro
                    const invalidFields = form.querySelectorAll(".is-invalid");
                    invalidFields.forEach((field) =>
                        field.classList.remove("is-invalid")
                    );

                    // Remove feedbacks customizados
                    const customFeedbacks = form.querySelectorAll(
                        ".invalid-feedback.custom"
                    );
                    customFeedbacks.forEach((feedback) => feedback.remove());

                    // Desmarca todos os checkboxes de amenidades
                    const amenityCheckboxes = form.querySelectorAll(
                        'input[name="amenities[]"]'
                    );
                    amenityCheckboxes.forEach(
                        (checkbox) => (checkbox.checked = false)
                    );
                }
            }
        });
    }
});

// Máscara e validação para placa
document.addEventListener("DOMContentLoaded", function () {
    const licensePlateInput = document.getElementById("license_plate");

    if (licensePlateInput) {
        // Aplica máscara na placa
        licensePlateInput.addEventListener("input", function (e) {
            let value = e.target.value.replace(/[^A-Z0-9]/g, "").toUpperCase();

            if (value.length <= 7) {
                // Formato antigo: ABC-1234
                if (value.length > 3) {
                    value = value.substring(0, 3) + "-" + value.substring(3);
                }
            } else if (value.length === 8) {
                // Formato Mercosul: ABC1D23
                value =
                    value.substring(0, 3) +
                    value.substring(3, 4) +
                    value.substring(4, 5) +
                    value.substring(5);
            }

            e.target.value = value;
        });

        // Valida formato da placa
        licensePlateInput.addEventListener("blur", function (e) {
            const value = e.target.value.replace("-", "");
            const oldFormat = /^[A-Z]{3}[0-9]{4}$/;
            const newFormat = /^[A-Z]{3}[0-9]{1}[A-Z]{1}[0-9]{2}$/;

            if (value && !oldFormat.test(value) && !newFormat.test(value)) {
                e.target.classList.add("is-invalid");

                // Remove feedback anterior
                const existingFeedback = e.target.parentNode.querySelector(
                    ".invalid-feedback.custom"
                );
                if (existingFeedback) {
                    existingFeedback.remove();
                }

                // Adiciona feedback customizado
                const feedback = document.createElement("div");
                feedback.className = "invalid-feedback custom";
                feedback.textContent =
                    "Formato inválido. Use ABC-1234 ou ABC1D23";
                e.target.parentNode.appendChild(feedback);
            } else {
                e.target.classList.remove("is-invalid");
                const customFeedback = e.target.parentNode.querySelector(
                    ".invalid-feedback.custom"
                );
                if (customFeedback) {
                    customFeedback.remove();
                }
            }
        });
    }
});

// Validação em tempo real para campos obrigatórios
document.addEventListener("DOMContentLoaded", function () {
    const requiredFields = document.querySelectorAll(
        "input[required], select[required]"
    );

    requiredFields.forEach((field) => {
        field.addEventListener("blur", function () {
            if (this.value.trim() === "") {
                this.classList.add("is-invalid");
            } else {
                this.classList.remove("is-invalid");
            }
        });

        field.addEventListener("input", function () {
            if (
                this.classList.contains("is-invalid") &&
                this.value.trim() !== ""
            ) {
                this.classList.remove("is-invalid");
            }
        });
    });
});

// Formatação do campo de prefixo (apenas números e letras)
document.addEventListener("DOMContentLoaded", function () {
    const prefixInput = document.getElementById("prefix");

    if (prefixInput) {
        prefixInput.addEventListener("input", function (e) {
            e.target.value = e.target.value
                .replace(/[^A-Z0-9]/gi, "")
                .toUpperCase();
        });
    }
});

// Formatação do campo de chassi (apenas números e letras)
document.addEventListener("DOMContentLoaded", function () {
    const chassisInput = document.getElementById("chassis");

    if (chassisInput) {
        chassisInput.addEventListener("input", function (e) {
            e.target.value = e.target.value
                .replace(/[^A-Z0-9]/gi, "")
                .toUpperCase();
        });
    }
});

// Validação de capacidade
document.addEventListener("DOMContentLoaded", function () {
    const capacityInput = document.getElementById("capacity");

    if (capacityInput) {
        capacityInput.addEventListener("input", function (e) {
            const value = parseInt(e.target.value);
            if (value < 1 || value > 100) {
                e.target.classList.add("is-invalid");
            } else {
                e.target.classList.remove("is-invalid");
            }
        });
    }
});
