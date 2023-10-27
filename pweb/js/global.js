const numbersOnly = document.querySelectorAll("[data-number-only-input]");
const passwordToggles = document.querySelectorAll("[data-password-toggle]");

numbersOnly.forEach((e) => {
    e.addEventListener("input", (el) => {
        let target = el.target;
        let regex = /\D+/g;

        if (regex.test(target.value)) {
            target.value = target.value.replace(regex, "");
        }
    });
});

passwordToggles.forEach((e) => {
    e.addEventListener("click", (e) => {
        let isToggled = "toggleOn" in e.target.dataset;
        if (isToggled) {
            e.target.parentNode.querySelector(".input").type = "password";
            e.target.classList.remove("fa-eye");
            e.target.classList.add("fa-eye-slash");
            return delete e.target.dataset.toggleOn;
        }

        e.target.parentNode.querySelector(".input").type = "text";
        e.target.classList.remove("fa-eye-slash");
        e.target.classList.add("fa-eye");
        e.target.dataset.toggleOn = "";
    });
});
