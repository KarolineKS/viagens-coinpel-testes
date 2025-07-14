/**
 * =============================================================================
 *  SISTEMA DE VEÍCULOS - Validação e Máscaras
 * =============================================================================
 */

class VehicleFormHandler {
    constructor() {
        this.form = document.getElementById("vehicleForm");
        this.offcanvas = document.getElementById("vehicleFormOffcanvas");

        if (this.form) {
            this.init();
        }
    }

    init() {
        this.setupOffcanvasHandler();
        this.setupInputMasks();
        this.setupValidation();
        this.setupFormSubmission();
    }

    /**
     * Gerencia abertura/fechamento do offcanvas
     */

    setupOffcanvasHandler() {
        if (!this.offcanvas) return;

        // Auto-abre se há erros de validação
        const hasValidationErrors = document.querySelector(
            ".alert-danger, .is-invalid"
        );
        const shouldAutoOpen =
            this.offcanvas.dataset.autoOpen === "true" || hasValidationErrors;

        if (shouldAutoOpen) {
            const offcanvas = new bootstrap.Offcanvas(this.offcanvas);
            offcanvas.show();
        }

        // Reset do formulário ao fechar
        this.offcanvas.addEventListener("hidden.bs.offcanvas", () => {
            const url = new URL(window.location);

            if (url.searchParams.has("edit")) {
                url.searchParams.delete("edit");
                window.location.href = url.toString();
            } else {
                if (document.querySelector(".alert-danger, .text-danger")) {
                    window.location.href = url.pathname;
                }
            }
        });
    }

    /**
     *  Aplica máscaras nos campos de entrada
     */
    setupInputMasks() {
        // Placa: formato inteligente (antigo/Mercosul)
        const licensePlateInput = document.getElementById("license_plate");
        if (licensePlateInput) {
            licensePlateInput.addEventListener("input", (e) => {
                let value = e.target.value
                    .replace(/[^A-Z0-9]/gi, "")
                    .toUpperCase();

                if (value.length > 7) value = value.substring(0, 7);

                // Aplica máscara baseada no formato
                if (value.length >= 4) {
                    if (value.length <= 7 && /^[A-Z]{3}[0-9]/.test(value)) {
                        // Formato Mercosul: ABC1D23
                        if (value.length > 4) {
                            value =
                                value.substring(0, 3) +
                                value.substring(3, 4) +
                                value.substring(4);
                        }
                    } else {
                        // Formato antigo: ABC-1234
                        value =
                            value.substring(0, 3) + "-" + value.substring(3);
                    }
                }

                e.target.value = value;
            });
        }

        // Prefixo: alfanumérico, máximo 10 caracteres
        const prefixInput = document.getElementById("prefix");
        if (prefixInput) {
            prefixInput.addEventListener("input", (e) => {
                let value = e.target.value
                    .replace(/[^A-Z0-9]/gi, "")
                    .toUpperCase();
                if (value.length > 10) value = value.substring(0, 10);
                e.target.value = value;
            });
        }

        // Chassi: alfanumérico, máximo 17 caracteres
        const chassisInput = document.getElementById("chassis");
        if (chassisInput) {
            chassisInput.addEventListener("input", (e) => {
                let value = e.target.value
                    .replace(/[^A-Z0-9]/gi, "")
                    .toUpperCase();
                if (value.length > 17) value = value.substring(0, 17);
                e.target.value = value;
            });
        }

        // Capacidade: apenas números
        const capacityInput = document.getElementById("capacity");
        if (capacityInput) {
            capacityInput.addEventListener("input", (e) => {
                let value = e.target.value.replace(/[^0-9]/g, "");
                e.target.value = value;
            });
        }

        // Ano: apenas números, máximo 4 dígitos
        const yearInput = document.getElementById("year");
        if (yearInput) {
            yearInput.addEventListener("input", (e) => {
                let value = e.target.value.replace(/[^0-9]/g, "");
                if (value.length > 4) value = value.substring(0, 4);
                e.target.value = value;
            });
        }

        // Tipo de veículo: remove caracteres especiais
        const vehicleTypeInput = document.getElementById("vehicle_type");
        if (vehicleTypeInput) {
            vehicleTypeInput.addEventListener("input", (e) => {
                let value = e.target.value.replace(/[^a-zA-Z0-9\s\-]/g, "");
                e.target.value = value;
            });
        }

        // Nome de identificação: limita caracteres
        const identificationInput = document.getElementById(
            "identification_name"
        );
        if (identificationInput) {
            identificationInput.addEventListener("input", (e) => {
                if (e.target.value.length > 255) {
                    e.target.value = e.target.value.substring(0, 255);
                }
            });
        }

        // Modelo: limita caracteres
        const modelInput = document.getElementById("model");
        if (modelInput) {
            modelInput.addEventListener("input", (e) => {
                if (e.target.value.length > 100) {
                    e.target.value = e.target.value.substring(0, 100);
                }
            });
        }
    }

    /**
     * Configura validação em tempo real
     */

    setupValidation() {
        const formInputs = document.querySelectorAll(".form-group__input");

        formInputs.forEach((input) => {
            // Remove erros quando o usuário digita
            input.addEventListener("input", () => {
                this.clearFieldError(input);
            });

            // Valida quando o usuário sai do campo
            input.addEventListener("blur", () => {
                this.validateField(input);
            });
        });
    }

    /**
     * Valida um campo específico
     */

    validateField(field) {
        this.clearFieldError(field);

        const value = field.value.trim();
        const errorMessage = this.getFieldErrorMessage(field, value);

        if (errorMessage) {
            this.showFieldError(field, errorMessage);
            return false;
        }

        return true;
    }

    /**
     * Retorna mensagem de erro para um campo específico
     */
    getFieldErrorMessage(field, value) {
        // Campo obrigatório vazio
        if (field.hasAttribute("required") && !value) {
            return "Este campo é obrigatório";
        }

        // Validações específicas apenas se há valor
        if (!value) return "";

        switch (field.id) {
            case "license_plate":
                const plateRegex =
                    /^[A-Z]{3}[-]?[0-9]{4}$|^[A-Z]{3}[0-9][A-Z][0-9]{2}$/;
                if (!plateRegex.test(value.replace("-", ""))) {
                    return "Formato de placa inválido";
                }
                break;

            case "capacity":
                const capacity = parseInt(value);
                if (isNaN(capacity) || capacity < 1) {
                    return "Capacidade deve ser maior que 0";
                }
                break;

            case "year":
                const year = parseInt(value);
                const currentYear = new Date().getFullYear();
                if (isNaN(year) || year < 1950 || year > currentYear + 1) {
                    return `Ano deve ser entre 1950 e ${currentYear + 1}`;
                }
                break;

            case "prefix":
                if (value.length > 10) {
                    return "Prefixo deve ter no máximo 10 caracteres";
                }
                break;

            case "chassis":
                if (value.length > 17) {
                    return "Chassi deve ter no máximo 17 caracteres";
                }
                break;

            case "identification_name":
                if (value.length > 255) {
                    return "Nome deve ter no máximo 255 caracteres";
                }
                break;

            case "model":
                if (value.length > 100) {
                    return "Modelo deve ter no máximo 100 caracteres";
                }
                break;
        }

        return "";
    }

    /**
     *  Mostra erro no campo
     */
    showFieldError(field, message) {
        field.classList.add("is-invalid");

        const errorSpan = document.createElement("span");
        errorSpan.className = "text-danger small d-block mt-1 js-error-message";
        errorSpan.textContent = message;
        field.parentElement.appendChild(errorSpan);
    }

    /**
     * Remove erro do campo
     */
    clearFieldError(field) {
        field.classList.remove("is-invalid");

        const errorSpan =
            field.parentElement.querySelector(".js-error-message");
        if (errorSpan) {
            errorSpan.remove();
        }
    }

    /**
     *  Configura validação no envio do formulário
     */
    setupFormSubmission() {
        this.form.addEventListener("submit", (e) => {
            let hasErrors = false;
            let firstErrorField = null;

            // Valida todos os campos obrigatórios
            const requiredFields = this.form.querySelectorAll(
                "input[required], select[required]"
            );

            requiredFields.forEach((field) => {
                const isValid = this.validateField(field);
                if (!isValid) {
                    hasErrors = true;
                    if (!firstErrorField) {
                        firstErrorField = field;
                    }
                }
            });

            // Se há erros, impede o envio
            if (hasErrors) {
                e.preventDefault();
            }
        });
    }
}

// Inicializa quando o DOM estiver pronto
document.addEventListener("DOMContentLoaded", () => {
    new VehicleFormHandler();
});

export default VehicleFormHandler;
