document.addEventListener("DOMContentLoaded", () => {
    const changePasswordModalEl = document.getElementById(
        "changePasswordModal"
    );
    if (changePasswordModalEl) {
        const changePasswordModal = new bootstrap.Modal(changePasswordModalEl, {
            backdrop: "static",
            keyboard: false,
        });
        changePasswordModal.show();

        const closeButton = changePasswordModalEl.querySelector(
            ".change-password-modal__close-btn"
        );
        if (closeButton) {
            closeButton.addEventListener("click", (event) => {
                event.preventDefault();
                event.stopPropagation();

                const alertModalEl = document.getElementById(
                    "mandatory-change-alert"
                );
                if (alertModalEl) {
                    const alertModal = new bootstrap.Modal(alertModalEl);
                    alertModal.show();
                }
            });
        }
    }

    const sessionAlertModalEl = document.getElementById("sessionAlertModal");
    if (sessionAlertModalEl) {
        const sessionAlertModal = new bootstrap.Modal(sessionAlertModalEl);
        sessionAlertModal.show();
    }

    const passwordInput = document.getElementById("new-password");
    const passwordConfirmationInput = document.getElementById(
        "new-password-confirmation"
    );
    const submitButton = document.getElementById("change-password-submit-btn");
    const lengthError = document.getElementById("password-length-error");
    const matchError = document.getElementById("password-match-error");
    const form = document.getElementById("change-password-form");
    const minPasswordLength = form
        ? parseInt(form.dataset.minPasswordLength)
        : 8;

    function validatePasswords() {
        const password = passwordInput.value;
        const confirmation = passwordConfirmationInput.value;
        let isLengthValid = false;
        let arePasswordsMatching = false;

        if (password.length > 0 && password.length < minPasswordLength) {
            lengthError.textContent = `A senha deve ter no mínimo ${minPasswordLength} caracteres.`;
            passwordInput.classList.add("is-invalid");
            isLengthValid = false;
        } else {
            lengthError.textContent = "";
            passwordInput.classList.remove("is-invalid");
            isLengthValid = password.length >= minPasswordLength;
        }

        if (confirmation.length > 0 && password !== confirmation) {
            matchError.textContent = "As senhas não conferem.";
            passwordConfirmationInput.classList.add("is-invalid");
            arePasswordsMatching = false;
        } else {
            matchError.textContent = "";
            passwordConfirmationInput.classList.remove("is-invalid");
            arePasswordsMatching =
                confirmation.length > 0 && password === confirmation;
        }

        if (isLengthValid && arePasswordsMatching) {
            submitButton.disabled = false;
        } else {
            submitButton.disabled = true;
        }
    }

    if (passwordInput && passwordConfirmationInput && submitButton) {
        passwordInput.addEventListener("keyup", validatePasswords);
        passwordConfirmationInput.addEventListener("keyup", validatePasswords);
    }
});
