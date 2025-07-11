import "./bootstrap";

import * as bootstrap from "bootstrap/dist/js/bootstrap.bundle.min.js";

window.bootstrap = bootstrap;

import "./auth.js";

document.addEventListener("DOMContentLoaded", function () {
    const toastElList = [].slice.call(document.querySelectorAll(".toast"));
    const toastList = toastElList.map(function (toastEl) {
        return bootstrap.Toast.getOrCreateInstance(toastEl);
    });
    toastList.forEach((toast) => toast.show());
});
