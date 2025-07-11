import "./bootstrap";

import "./auth.js";

document.addEventListener("DOMContentLoaded", function () {
    const toastElList = [].slice.call(document.querySelectorAll(".toast"));
    const toastList = toastElList.map(function (toastEl) {
        return new window.bootstrap.Toast(toastEl);
    });
    toastList.forEach((toast) => toast.show());
});
