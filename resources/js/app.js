import "./bootstrap";
import "./auth.js";
import "./vehicle.js";
import "./users.js";

import.meta.glob(["../images/**", "../fonts/**"]);

import "./driver-form.js";

// Toast functionality
document.addEventListener("DOMContentLoaded", function () {
    const toastElList = [].slice.call(document.querySelectorAll(".toast"));
    const toastList = toastElList.map(function (toastEl) {
        return new window.bootstrap.Toast(toastEl);
    });
    toastList.forEach((toast) => toast.show());
});
