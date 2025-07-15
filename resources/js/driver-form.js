document.addEventListener("DOMContentLoaded", function () {
    // Classe principal para gerenciar o formulário de motoristas
    class DriverFormHandler {
        constructor() {
            this.form = document.getElementById("driverForm");
            this.init();
        }

        init() {
            this.initializeMasks();
            this.initializeValidation();
            this.initializeProfilePhoto();
            this.initializeErrorHandling();
        }

        // Inicializar máscaras de input
        initializeMasks() {
            // Máscara para CPF
            const cpfInput = document.getElementById("cpf");
            if (cpfInput) {
                cpfInput.addEventListener("input", (e) => {
                    let value = e.target.value.replace(/\D/g, "");
                    value = value.replace(/(\d{3})(\d)/, "$1.$2");
                    value = value.replace(/(\d{3})(\d)/, "$1.$2");
                    value = value.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
                    e.target.value = value;
                });
            }

            // Máscara para CEP com busca automática
            const zipCodeInput = document.getElementById("zip_code");
            if (zipCodeInput) {
                zipCodeInput.addEventListener("input", (e) => {
                    let value = e.target.value.replace(/\D/g, "");
                    value = value.replace(/(\d{5})(\d)/, "$1-$2");
                    e.target.value = value;
                });

                // Busca automática quando CEP completo é digitado
                zipCodeInput.addEventListener("blur", (e) => {
                    const cep = e.target.value.replace(/\D/g, "");
                    if (cep.length === 8) {
                        this.fetchAddressByCep(cep);
                    }
                });
            }

            // Máscara para telefone
            const phoneInput = document.getElementById("phone");
            if (phoneInput) {
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

            // Máscara para RG (apenas números)
            const rgInput = document.getElementById("rg");
            if (rgInput) {
                rgInput.addEventListener("input", (e) => {
                    let value = e.target.value.replace(/\D/g, "");
                    e.target.value = value;
                });
            }

            // Máscara para CNH (apenas números)
            const cnhInput = document.getElementById("cnh_number");
            if (cnhInput) {
                cnhInput.addEventListener("input", (e) => {
                    let value = e.target.value.replace(/\D/g, "");
                    e.target.value = value;
                });
            }

            // Máscara para matrícula (apenas números)
            const registrationInput = document.getElementById(
                "registration_number"
            );
            if (registrationInput) {
                registrationInput.addEventListener("input", (e) => {
                    let value = e.target.value.replace(/\D/g, "");
                    e.target.value = value;
                });
            }
        }

        // Inicializar validação em tempo real
        initializeValidation() {
            if (!this.form) return;

            const inputs = this.form.querySelectorAll(
                "input[required], select[required]"
            );

            inputs.forEach((input) => {
                // Validação ao sair do campo (blur)
                input.addEventListener("blur", () => {
                    this.validateField(input);
                });

                // Limpar erro ao digitar
                input.addEventListener("input", () => {
                    this.clearFieldError(input);
                });
            });

            // Validação no submit
            this.form.addEventListener("submit", (e) => {
                if (!this.validateForm()) {
                    e.preventDefault();
                }
            });
        }

        // Validar campo individual
        validateField(field) {
            const value = field.value.trim();
            let isValid = true;
            let errorMessage = "";

            // Limpar erro anterior
            this.clearFieldError(field);

            // Validação de campo obrigatório
            if (field.hasAttribute("required") && !value) {
                isValid = false;
                errorMessage = "Este campo é obrigatório.";
            }

            // Validações específicas por campo
            if (value && isValid) {
                switch (field.id) {
                    case "name":
                        if (value.length < 2) {
                            isValid = false;
                            errorMessage =
                                "Nome deve ter pelo menos 2 caracteres.";
                        }
                        break;

                    case "cpf":
                        if (value.length !== 14) {
                            isValid = false;
                            errorMessage = "CPF deve ter 14 caracteres.";
                        } else if (!/^\d{3}\.\d{3}\.\d{3}-\d{2}$/.test(value)) {
                            isValid = false;
                            errorMessage =
                                "CPF deve estar no formato 000.000.000-00.";
                        }
                        break;

                    case "zip_code":
                        if (value.length !== 9) {
                            isValid = false;
                            errorMessage = "CEP deve ter 9 caracteres.";
                        } else if (!/^\d{5}-\d{3}$/.test(value)) {
                            isValid = false;
                            errorMessage =
                                "CEP deve estar no formato 00000-000.";
                        }
                        break;

                    case "email":
                        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                        if (!emailRegex.test(value)) {
                            isValid = false;
                            errorMessage = "Digite um e-mail válido.";
                        }
                        break;

                    case "phone":
                        if (value.length < 14) {
                            isValid = false;
                            errorMessage =
                                "Telefone deve ter pelo menos 10 dígitos.";
                        }
                        break;

                    case "birth_date":
                        const birthDate = new Date(value);
                        const today = new Date();
                        const age =
                            today.getFullYear() - birthDate.getFullYear();
                        if (age < 18) {
                            isValid = false;
                            errorMessage =
                                "O motorista deve ser maior de 18 anos.";
                        }
                        break;

                    case "cnh_expiry_date":
                        const expiryDate = new Date(value);
                        const currentDate = new Date();
                        if (expiryDate <= currentDate) {
                            isValid = false;
                            errorMessage = "A CNH deve ter validade futura.";
                        }
                        break;
                }
            }

            if (!isValid) {
                this.showFieldError(field, errorMessage);
            }

            return isValid;
        }

        // Mostrar erro no campo
        showFieldError(field, message) {
            field.classList.add("is-invalid");

            const errorSpan = document.createElement("span");
            errorSpan.className = "text-danger small d-block mt-1 field-error";
            errorSpan.textContent = message;

            field.parentElement.appendChild(errorSpan);
        }

        // Limpar erro do campo
        clearFieldError(field) {
            field.classList.remove("is-invalid");

            const errorSpan = field.parentElement.querySelector(".field-error");
            if (errorSpan) {
                errorSpan.remove();
            }
        }

        // Validar formulário completo
        validateForm() {
            const inputs = this.form.querySelectorAll(
                "input[required], select[required]"
            );
            let isValid = true;
            let firstErrorField = null;

            inputs.forEach((input) => {
                if (!this.validateField(input)) {
                    isValid = false;
                    if (!firstErrorField) {
                        firstErrorField = input;
                    }
                }
            });

            // Scroll para o primeiro erro
            if (firstErrorField) {
                firstErrorField.scrollIntoView({
                    behavior: "smooth",
                    block: "center",
                });
                firstErrorField.focus();
            }

            return isValid;
        }

        // Funcionalidade da foto de perfil
        initializeProfilePhoto() {
            const profilePhotoInput = document.getElementById("profile_photo");
            const profilePhotoPreview = document.getElementById(
                "profilePhotoPreview"
            );
            const choosePhotoBtn = document.querySelector(
                '[data-action="choose-photo"]'
            );
            const cameraIconTemplate =
                document.getElementById("cameraIconTemplate");
            const currentPhotoContainer = document.querySelector(
                ".current-photo-container"
            );

            if (choosePhotoBtn && profilePhotoInput) {
                choosePhotoBtn.addEventListener("click", function () {
                    profilePhotoInput.click();
                });
            }

            if (profilePhotoPreview && profilePhotoInput) {
                profilePhotoPreview.addEventListener("click", function () {
                    profilePhotoInput.click();
                });
            }

            if (profilePhotoInput) {
                profilePhotoInput.addEventListener("change", (event) => {
                    const file = event.target.files[0];

                    if (file) {
                        // Validar tamanho (5MB) - mostra erro mas permite submit para validação do backend
                        const maxSize = 5 * 1024 * 1024;
                        if (file.size > maxSize) {
                            this.showFieldError(
                                profilePhotoInput,
                                "A imagem é muito grande. O tamanho máximo é 5MB."
                            );
                            // Não retornamos aqui - deixamos o backend validar também
                        }

                        // Validar tipo - mostra erro mas permite submit para validação do backend
                        const allowedTypes = [
                            "image/jpeg",
                            "image/png",
                            "image/jpg",
                            "image/gif",
                            "image/webp",
                        ];
                        if (!allowedTypes.includes(file.type)) {
                            this.showFieldError(
                                profilePhotoInput,
                                "Tipo de arquivo não permitido. Use apenas: JPEG, PNG, JPG, GIF ou WebP."
                            );
                            // Não retornamos aqui - deixamos o backend validar também
                        }

                        const fileSize = (file.size / 1024 / 1024).toFixed(2);
                        const reader = new FileReader();

                        reader.onload = (e) => {
                            const img = new Image();
                            img.onload = () => {
                                // Validar dimensões - mostra erro mas permite submit para validação do backend
                                if (img.width < 100 || img.height < 100) {
                                    this.showFieldError(
                                        profilePhotoInput,
                                        "A imagem deve ter pelo menos 100x100 pixels."
                                    );
                                    // Não retornamos aqui - deixamos o backend validar também
                                }

                                if (img.width > 4000 || img.height > 4000) {
                                    this.showFieldError(
                                        profilePhotoInput,
                                        "A imagem não pode ter mais de 4000x4000 pixels."
                                    );
                                    // Não retornamos aqui - deixamos o backend validar também
                                }

                                // Mostrar preview
                                if (currentPhotoContainer) {
                                    currentPhotoContainer.innerHTML = `
                                        <img src="${e.target.result}" alt="Nova foto" class="current-photo-img rounded-circle" style="width: 150px; height: 150px; object-fit: cover; border: 2px solid #dee2e6;">
                                        <small class="text-muted d-block mt-2">Nova imagem: ${img.width}x${img.height}px (${fileSize}MB)</small>
                                    `;
                                } else if (profilePhotoPreview) {
                                    profilePhotoPreview.innerHTML = `<img src="${e.target.result}" alt="Preview" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">`;

                                    const infoElement =
                                        document.createElement("small");
                                    infoElement.className =
                                        "text-muted d-block mt-2 text-center";
                                    infoElement.textContent = `${img.width}x${img.height}px (${fileSize}MB)`;
                                    profilePhotoPreview.parentNode.appendChild(
                                        infoElement
                                    );
                                }
                            };
                            img.src = e.target.result;
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }
        }

        // Buscar endereço por CEP usando ViaCEP
        async fetchAddressByCep(cep) {
            try {
                const response = await fetch(
                    `https://viacep.com.br/ws/${cep}/json/`
                );
                const data = await response.json();

                if (data.erro) {
                    this.showCepError("CEP não encontrado.");
                    return;
                }

                // Preencher os campos automaticamente
                const streetInput = document.getElementById("street");
                const cityInput = document.getElementById("city");
                const stateInput = document.getElementById("state");

                if (streetInput && data.logradouro) {
                    streetInput.value = data.logradouro;
                    this.clearFieldError(streetInput);
                }

                if (cityInput && data.localidade) {
                    cityInput.value = data.localidade;
                    this.clearFieldError(cityInput);
                }

                if (stateInput && data.uf) {
                    stateInput.value = data.uf;
                    this.clearFieldError(stateInput);
                }

                // Focar no campo número
                const numberInput = document.getElementById("number");
                if (numberInput) {
                    numberInput.focus();
                }

                this.clearCepError();
            } catch (error) {
                console.error("Erro ao buscar CEP:", error);
                this.showCepError("Erro ao buscar CEP. Verifique sua conexão.");
            }
        }

        // Mostrar erro de CEP
        showCepError(message) {
            const zipCodeInput = document.getElementById("zip_code");
            if (zipCodeInput) {
                this.showFieldError(zipCodeInput, message);
            }
        }

        // Limpar erro de CEP
        clearCepError() {
            const zipCodeInput = document.getElementById("zip_code");
            if (zipCodeInput) {
                this.clearFieldError(zipCodeInput);
            }
        }

        // Inicializar tratamento de erros
        initializeErrorHandling() {
            // Scroll para primeiro erro na abertura
            const firstErrorField = document.querySelector(
                ".form-group__input.is-invalid"
            );
            if (firstErrorField) {
                setTimeout(() => {
                    firstErrorField.scrollIntoView({
                        behavior: "smooth",
                        block: "center",
                    });
                    firstErrorField.focus();
                }, 300);
            }

            // Reset do formulário quando offcanvas fecha
            const offcanvasEl = document.getElementById("driverFormOffcanvas");
            if (offcanvasEl) {
                offcanvasEl.addEventListener("hidden.bs.offcanvas", () => {
                    if (this.form) {
                        this.form.reset();

                        // Limpar todos os erros
                        const invalidFields =
                            this.form.querySelectorAll(".is-invalid");
                        invalidFields.forEach((field) => {
                            this.clearFieldError(field);
                        });

                        // Reset foto preview
                        const profilePhotoPreview = document.getElementById(
                            "profilePhotoPreview"
                        );
                        const cameraIconTemplate =
                            document.getElementById("cameraIconTemplate");
                        if (profilePhotoPreview && cameraIconTemplate) {
                            profilePhotoPreview.innerHTML =
                                cameraIconTemplate.innerHTML;
                        }
                    }
                });
            }
        }
    }

    // Inicializar o manipulador do formulário
    if (document.getElementById("driverForm")) {
        new DriverFormHandler();
    }

    // Lógica para abrir o offcanvas automaticamente
    const offcanvasElement = document.getElementById("driverFormOffcanvas");
    if (offcanvasElement) {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has("edit") || urlParams.has("create")) {
            const offcanvas = new bootstrap.Offcanvas(offcanvasElement);
            offcanvas.show();
        }
    }
});
