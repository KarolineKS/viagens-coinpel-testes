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

        const closeButton = changePasswordModalEl.querySelector(".btn-close");
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
});
