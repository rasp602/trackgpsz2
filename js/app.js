console.log("app.js cargado correctamente");

document.addEventListener("DOMContentLoaded", function () {
    console.log("DOM cargado correctamente");

    const body = document.querySelector("body");
    if (body) {
        body.setAttribute("data-js", "activo");
    }
});