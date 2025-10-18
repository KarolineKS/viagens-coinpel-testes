/**
 * =============================================================================
 *  SISTEMA DE USUÁRIOS - Validação e Funcionalidades
 * =============================================================================
 */

class UserFormHandler {
    constructor() {
        this.form = document.getElementById("userForm");
        this.offcanvas = document.getElementById("userFormOffcanvas");

        if (this.form) {
            this.init();
        }
    }

    init() {
        this.setupOffcanvasHandler();
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
            case "name":
                if (value.length < 2) {
                    return "Nome deve ter pelo menos 2 caracteres";
                }
                if (value.length > 255) {
                    return "Nome deve ter no máximo 255 caracteres";
                }
                break;

            case "email":
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(value)) {
                    return "Digite um e-mail válido";
                }
                if (value.length > 255) {
                    return "E-mail deve ter no máximo 255 caracteres";
                }
                break;

            case "password":
                if (value.length < 8) {
                    return "Senha deve ter pelo menos 8 caracteres";
                }
                break;
        }

        return "";
    }

    /**
     * Mostra erro no campo
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
     * Configura validação no envio do formulário
     */
    setupFormSubmission() {
        this.form.addEventListener("submit", (e) => {
            let hasErrors = false;
            let firstErrorField = null;

            // Valida todos os campos obrigatórios
            const requiredFields =
                this.form.querySelectorAll("input[required]");

            requiredFields.forEach((field) => {
                const isValid = this.validateField(field);
                if (!isValid) {
                    hasErrors = true;
                    if (!firstErrorField) {
                        firstErrorField = field;
                    }
                }
            });

            // Valida todos os campos não obrigatórios que têm valor
            const allFields = this.form.querySelectorAll(
                "input:not([required])"
            );
            allFields.forEach((field) => {
                if (field.value.trim()) {
                    const isValid = this.validateField(field);
                    if (!isValid) {
                        hasErrors = true;
                        if (!firstErrorField) {
                            firstErrorField = field;
                        }
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
    new UserFormHandler();
});

export default UserFormHandler;
