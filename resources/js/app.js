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
        if (vehicleOffcanvas.dataset.autoOpen === "true") {
            const offcanvas = new bootstrap.Offcanvas(vehicleOffcanvas);
            offcanvas.show();
        }

        vehicleOffcanvas.addEventListener("hidden.bs.offcanvas", function () {
            const url = new URL(window.location);

            if (url.searchParams.has("edit")) {
                url.searchParams.delete("edit");
                window.location.href = url.toString();
            }
        });
    }
});
