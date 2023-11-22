const inputs = document.querySelectorAll("[data-input-pelanggan]");
const formContainer = document.querySelector(".form-content");
const inputPelanggan = document.querySelector("[data-pelanggan]");
const typeInput = document.querySelector("#i-type");

typeInput.addEventListener("input", handleType);

handleType();

function handleType(e) {
    if (typeInput.value == "umum") {
        inputs.forEach((el) => {
            el.style.display = "none";
            inputPelanggan.removeAttribute("required");
        });
        return;
    }

    inputs.forEach((el) => {
        el.style.display = null;
        inputPelanggan.setAttribute("required", null);
    });
}
