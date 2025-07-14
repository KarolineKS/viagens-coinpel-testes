/**
 * =============================================================================
 *  SISTEMA DE MOTORISTAS - Gerenciamento de Formulários
 * =============================================================================
 *
 * Este arquivo gerencia todas as funcionalidades relacionadas ao formulário
 * de motoristas, incluindo validação, máscaras, upload de fotos e reset.
 *
 * @author Sistema Coinpel
 * @version 1.0.0
 */

class DriverFormManager {
    constructor() {
        this.pageLoadTime = Date.now();
        this.lastActiveTime = Date.now();
        this.form = null;
        this.offcanvas = null;

        this.init();
    }

    /**
     * Inicializa todas as funcionalidades do formulário
     */
    init() {
        this.form = document.getElementById("driverForm");
        this.offcanvas = document.getElementById("driverFormOffcanvas");

        if (!this.form || !this.offcanvas) return;

        this.initFormHandlers();
        this.initPhotoHandlers();
        this.initInputMasks();
        this.initValidation();
        this.initSessionMonitoring();
    }

    /**
     * =============================================================================
     *  GERENCIAMENTO DO FORMULÁRIO
     * =============================================================================
     */

    /**
     * Inicializa os handlers do formulário principal
     */
    initFormHandlers() {
        this.setupEventDelegation();
        this.setupOffcanvasHandlers();
        this.setupFormSubmission();
    }

    /**
     * Configura event delegation para ações do formulário
     */
    setupEventDelegation() {
        document.addEventListener("click", (e) => {
            const action = this.findActionInElement(e.target);
            if (!action.type) return;

            switch (action.type) {
                case "edit-section":
                    this.editSection(action.section);
                    break;
                case "cancel-edit":
                    this.cancelEdit(action.section);
                    break;
                case "save-section":
                    this.saveSection(action.section);
                    break;
                case "choose-photo":
                    this.choosePhoto();
                    break;
            }
        });
    }

    /**
     * Encontra ação em elemento ou seus pais
     */
    findActionInElement(element) {
        let currentElement = element;
        let action = null;
        let section = null;

        for (let i = 0; i < 3 && currentElement; i++) {
            action = currentElement.getAttribute("data-action");
            section = currentElement.getAttribute("data-section");

            if (action) break;
            currentElement = currentElement.parentElement;
        }

        return { type: action, section };
    }

    /**
     * Configura handlers do offcanvas
     */
    setupOffcanvasHandlers() {
        this.setupAutoOpen();
        this.setupResetOnClose();
        this.setupResetOnShow();
        this.setupCancelButtons();
        this.setupCloseButton();
    }

    /**
     * Auto-abre offcanvas se necessário
     */
    setupAutoOpen() {
        const hasValidationErrors = document.querySelector(
            ".alert-danger, .is-invalid"
        );
        const shouldAutoOpen =
            this.offcanvas.dataset.autoOpen === "true" || hasValidationErrors;

        if (shouldAutoOpen) {
            const bsOffcanvas = new bootstrap.Offcanvas(this.offcanvas);
            bsOffcanvas.show();
        }
    }

    /**
     * Reset do formulário ao fechar
     */
    setupResetOnClose() {
        this.offcanvas.addEventListener("hidden.bs.offcanvas", () => {
            const url = new URL(window.location);
            if (url.searchParams.has("edit")) {
                url.searchParams.delete("edit");
                window.location.href = url.toString();
            } else {
                const hasErrors = document.querySelector(
                    ".alert-danger, .is-invalid"
                );
                if (!hasErrors) {
                    this.resetCompleteForm();
                }
            }
        });
    }

    /**
     * Reset do formulário ao abrir para novo motorista
     */
    setupResetOnShow() {
        this.offcanvas.addEventListener("shown.bs.offcanvas", () => {
            const url = new URL(window.location);
            if (!url.searchParams.has("edit")) {
                const hasErrors = document.querySelector(
                    ".alert-danger, .is-invalid"
                );
                if (!hasErrors) {
                    this.resetCompleteForm();
                }
            }
        });
    }

    /**
     * Reset do formulário ao clicar em cancelar
     */
    setupCancelButtons() {
        const cancelButtons = this.offcanvas.querySelectorAll(
            '[data-bs-dismiss="offcanvas"]'
        );
        cancelButtons.forEach((button) => {
            button.addEventListener("click", () => {
                const url = new URL(window.location);
                if (!url.searchParams.has("edit")) {
                    setTimeout(() => this.resetCompleteForm(), 300);
                }
            });
        });
    }

    /**
     * Reset do formulário ao clicar no botão X (close)
     */
    setupCloseButton() {
        const closeButton = this.offcanvas.querySelector(".btn-close");
        if (closeButton) {
            closeButton.addEventListener("click", () => {
                const url = new URL(window.location);
                if (!url.searchParams.has("edit")) {
                    setTimeout(() => this.resetCompleteForm(), 300);
                }
            });
        }
    }

    /**
     * Configura submissão do formulário
     */
    setupFormSubmission() {
        this.form.addEventListener("submit", (e) => {
            // Permitir submit normal do formulário
            // O Laravel vai lidar com o CSRF automaticamente
        });
    }

    /**
     * =============================================================================
     *  AÇÕES DO FORMULÁRIO
     * =============================================================================
     */

    /**
     * Edita uma seção do formulário
     */
    editSection(section) {
        if (!section) return;

        const viewMode = document.getElementById(`${section}ViewMode`);
        const editMode = document.getElementById(`${section}EditMode`);

        if (viewMode && editMode) {
            viewMode.classList.add("d-none");
            editMode.classList.remove("d-none");
        }
    }

    /**
     * Cancela edição de uma seção
     */
    cancelEdit(section) {
        if (!section) return;

        const viewMode = document.getElementById(`${section}ViewMode`);
        const editMode = document.getElementById(`${section}EditMode`);

        if (viewMode && editMode) {
            viewMode.classList.remove("d-none");
            editMode.classList.add("d-none");
        }
    }

    /**
     * Salva uma seção do formulário
     */
    saveSection(section) {
        this.form.submit();
    }

    /**
     * =============================================================================
     *  GERENCIAMENTO DE FOTO
     * =============================================================================
     */

    /**
     * Inicializa handlers de foto
     */
    initPhotoHandlers() {
        this.setupPhotoClick();
        this.setupPhotoInput();
    }

    /**
     * Configura clique na foto
     */
    setupPhotoClick() {
        const profilePreview = document.querySelector(".profile-photo-preview");
        console.log("setupPhotoClick - profilePreview found:", profilePreview);

        if (
            profilePreview &&
            !profilePreview.hasAttribute("data-click-setup")
        ) {
            profilePreview.addEventListener("click", (e) => {
                // Evita conflito com o botão "Escolher foto"
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();
                console.log("Photo preview clicked");
                this.choosePhoto();
            });

            // Marca como configurado para evitar múltiplos listeners
            profilePreview.setAttribute("data-click-setup", "true");
            console.log("Click listener added to profile preview");
        } else if (!profilePreview) {
            console.error("Profile preview element not found");
        } else {
            console.log("Click listener already setup for profile preview");
        }
    }

    /**
     * Configura input de foto
     */
    setupPhotoInput() {
        const photoInput = document.getElementById("profile_photo");
        if (photoInput) {
            photoInput.addEventListener("change", (e) => {
                if (e.target.files && e.target.files[0]) {
                    this.previewPhoto(e.target);
                }
            });
        }
    }

    /**
     * Abre seletor de foto
     */
    choosePhoto() {
        console.log("choosePhoto called");
        const input = document.getElementById("profile_photo");
        console.log("Input element:", input);

        if (input) {
            // Remove o disabled caso esteja presente
            input.disabled = false;
            input.click();
        } else {
            console.error("Input profile_photo not found");
        }
    }

    /**
     * Remove foto selecionada
     */
    removePhoto() {
        const fileInput = document.getElementById("profile_photo");
        const preview = document.getElementById("profilePhotoPreview");
        const template = document.getElementById("cameraIconTemplate");

        if (fileInput) {
            fileInput.value = "";
        }

        if (preview) {
            // Remove a classe has-image
            preview.classList.remove("has-image");

            // Restaura o conteúdo original usando o template
            if (template) {
                preview.innerHTML = template.innerHTML;
            }
        }
    }

    /**
     * Preview da foto selecionada
     */
    previewPhoto(input) {
        if (!input.files || !input.files[0]) return;

        const reader = new FileReader();
        reader.onload = (e) => {
            const preview = document.getElementById("profilePhotoPreview");

            if (preview) {
                // Adiciona a classe has-image para aplicar estilos específicos
                preview.classList.add("has-image");

                // Remove o conteúdo atual (ícone)
                preview.innerHTML = "";

                // Cria e adiciona a imagem
                const img = document.createElement("img");
                img.src = e.target.result;
                img.alt = "Preview da foto";
                preview.appendChild(img);
            }
        };
        reader.readAsDataURL(input.files[0]);
    }

    /**
     * =============================================================================
     *  RESET DO FORMULÁRIO
     * =============================================================================
     */

    /**
     * Reset completo do formulário
     */
    resetCompleteForm() {
        if (!this.form) return;

        this.form.reset();
        this.removeValidationClasses();
        this.removeErrorMessages();
        this.resetPhotoPreview();
        this.removeAlerts();
        this.clearInputs();
    }

    /**
     * Remove classes de validação
     */
    removeValidationClasses() {
        const invalidFields = this.form.querySelectorAll(
            ".is-invalid, .is-valid"
        );
        invalidFields.forEach((field) => {
            field.classList.remove("is-invalid", "is-valid");
        });
    }

    /**
     * Remove mensagens de erro
     */
    removeErrorMessages() {
        const errorMessages = this.form.querySelectorAll(".invalid-feedback");
        errorMessages.forEach((msg) => msg.remove());
    }

    /**
     * Reset do preview da foto
     */
    resetPhotoPreview() {
        const preview = document.getElementById("profilePhotoPreview");
        const fileInput = document.getElementById("profile_photo");
        const template = document.getElementById("cameraIconTemplate");

        if (preview) {
            // Remove a classe has-image
            preview.classList.remove("has-image");

            // Restaura o conteúdo original usando o template
            if (template) {
                preview.innerHTML = template.innerHTML;
            }
        }

        if (fileInput) {
            fileInput.value = "";
        }
    }

    /**
     * Remove alertas
     */
    removeAlerts() {
        const alerts = this.form.querySelectorAll(".alert");
        alerts.forEach((alert) => alert.remove());
    }

    /**
     * Limpa inputs específicos
     */
    clearInputs() {
        const inputs = this.form.querySelectorAll("input, select, textarea");
        inputs.forEach((input) => {
            if (input.type === "file") {
                input.value = "";
            } else if (input.type === "checkbox" || input.type === "radio") {
                input.checked = false;
            } else if (input.name !== "_token") {
                input.value = "";
            }
        });
    }

    /**
     * =============================================================================
     *  MÁSCARAS DE INPUT
     * =============================================================================
     */

    /**
     * Inicializa máscaras de input
     */
    initInputMasks() {
        this.setupCPFMask();
        this.setupPhoneMask();
        this.setupCEPMask();
    }

    /**
     * Máscara para CPF
     */
    setupCPFMask() {
        const cpfInput = document.getElementById("cpf");
        if (!cpfInput) return;

        cpfInput.addEventListener("input", (e) => {
            let value = e.target.value.replace(/\D/g, "");
            value = value.replace(/(\d{3})(\d)/, "$1.$2");
            value = value.replace(/(\d{3})(\d)/, "$1.$2");
            value = value.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
            e.target.value = value;
        });
    }

    /**
     * Máscara para telefone
     */
    setupPhoneMask() {
        const phoneInput = document.getElementById("phone");
        if (!phoneInput) return;

        phoneInput.addEventListener("input", (e) => {
            let value = e.target.value.replace(/\D/g, "");
            if (value.length <= 10) {
                value = value.replace(/(\d{2})(\d)/, "($1) $2");
                value = value.replace(/(\d{4})(\d)/, "$1-$2");
            } else {
                value = value.replace(/(\d{2})(\d)/, "($1) $2");
                value = value.replace(/(\d{5})(\d)/, "$1-$2");
            }
            e.target.value = value;
        });
    }

    /**
     * Máscara para CEP
     */
    setupCEPMask() {
        const cepInput = document.getElementById("zip_code");
        if (!cepInput) return;

        cepInput.addEventListener("input", (e) => {
            let value = e.target.value.replace(/\D/g, "");
            value = value.replace(/(\d{5})(\d)/, "$1-$2");
            e.target.value = value;
        });

        cepInput.addEventListener("blur", () => {
            const cep = cepInput.value.replace(/\D/g, "");
            if (cep.length === 8) {
                this.searchAddressByCep(cep);
            }
        });
    }

    /**
     * =============================================================================
     *  VALIDAÇÃO
     * =============================================================================
     */

    /**
     * Inicializa validação
     */
    initValidation() {
        this.setupCPFValidation();
        this.setupEmailValidation();
    }

    /**
     * Validação de CPF
     */
    setupCPFValidation() {
        const cpfInput = document.getElementById("cpf");
        if (!cpfInput) return;

        cpfInput.addEventListener("blur", () => {
            const cpf = cpfInput.value.replace(/\D/g, "");
            if (cpf && !this.isValidCPF(cpf)) {
                cpfInput.classList.add("is-invalid");
                this.showFieldError(cpfInput, "CPF inválido");
            } else {
                cpfInput.classList.remove("is-invalid");
                this.hideFieldError(cpfInput);
            }
        });
    }

    /**
     * Validação de email
     */
    setupEmailValidation() {
        const emailInput = document.getElementById("email");
        if (!emailInput) return;

        emailInput.addEventListener("blur", () => {
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (emailInput.value && !emailPattern.test(emailInput.value)) {
                emailInput.classList.add("is-invalid");
                this.showFieldError(emailInput, "Email inválido");
            } else {
                emailInput.classList.remove("is-invalid");
                this.hideFieldError(emailInput);
            }
        });
    }

    /**
     * Valida CPF
     */
    isValidCPF(cpf) {
        cpf = cpf.replace(/\D/g, "");

        if (cpf.length !== 11 || /^(\d)\1+$/.test(cpf)) {
            return false;
        }

        let sum = 0;
        for (let i = 0; i < 9; i++) {
            sum += parseInt(cpf.charAt(i)) * (10 - i);
        }

        let remainder = (sum * 10) % 11;
        if (remainder === 10 || remainder === 11) remainder = 0;
        if (remainder !== parseInt(cpf.charAt(9))) return false;

        sum = 0;
        for (let i = 0; i < 10; i++) {
            sum += parseInt(cpf.charAt(i)) * (11 - i);
        }

        remainder = (sum * 10) % 11;
        if (remainder === 10 || remainder === 11) remainder = 0;
        return remainder === parseInt(cpf.charAt(10));
    }

    /**
     * Mostra erro no campo
     */
    showFieldError(field, message) {
        this.hideFieldError(field);

        const errorDiv = document.createElement("div");
        errorDiv.className = "invalid-feedback";
        errorDiv.textContent = message;

        field.parentNode.appendChild(errorDiv);
    }

    /**
     * Esconde erro do campo
     */
    hideFieldError(field) {
        const feedback = field.parentElement.querySelector(".invalid-feedback");
        if (feedback) {
            feedback.remove();
        }
    }

    /**
     * =============================================================================
     *  UTILITÁRIOS
     * =============================================================================
     */

    /**
     * Busca endereço por CEP
     */
    async searchAddressByCep(cep) {
        try {
            const response = await fetch(
                `https://viacep.com.br/ws/${cep}/json/`
            );
            const data = await response.json();

            if (!data.erro) {
                const streetInput = document.getElementById("street");
                const cityInput = document.getElementById("city");
                const stateInput = document.getElementById("state");

                if (streetInput) streetInput.value = data.logradouro || "";
                if (cityInput) cityInput.value = data.localidade || "";
                if (stateInput) stateInput.value = data.uf || "";
            }
        } catch (error) {
            console.error("Erro ao buscar CEP:", error);
        }
    }

    /**
     * =============================================================================
     *  MONITORAMENTO DE SESSÃO
     * =============================================================================
     */

    /**
     * Inicializa monitoramento de sessão
     */
    initSessionMonitoring() {
        this.setupActivityTracking();
        this.setupVisibilityChange();
        this.setupSubmitCheck();
    }

    /**
     * Rastreia atividade do usuário
     */
    setupActivityTracking() {
        document.addEventListener("click", () => {
            this.lastActiveTime = Date.now();
        });
        document.addEventListener("keydown", () => {
            this.lastActiveTime = Date.now();
        });
    }

    /**
     * Verifica quando usuário volta para a página
     */
    setupVisibilityChange() {
        document.addEventListener("visibilitychange", () => {
            if (!document.hidden) {
                const timeSinceActive = Date.now() - this.lastActiveTime;
                const oneHour = 60 * 60 * 1000;

                if (timeSinceActive > oneHour) {
                    const shouldReload = confirm(
                        "Você ficou ausente por um tempo. Deseja recarregar a página para evitar erros?"
                    );
                    if (shouldReload) {
                        window.location.reload();
                    }
                }
                this.lastActiveTime = Date.now();
            }
        });
    }

    /**
     * Verifica antes de enviar formulário
     */
    setupSubmitCheck() {
        document.addEventListener("submit", (e) => {
            const timeSinceLoad = Date.now() - this.pageLoadTime;
            const twoHours = 2 * 60 * 60 * 1000;

            if (timeSinceLoad > twoHours) {
                if (
                    confirm(
                        "A página foi carregada há muito tempo. Deseja recarregar para evitar erros?"
                    )
                ) {
                    e.preventDefault();
                    window.location.reload();
                    return;
                }
            }
        });
    }
}

// Inicializar quando DOM estiver pronto
document.addEventListener("DOMContentLoaded", () => {
    new DriverFormManager();
});
