const numbersOnly = document.querySelectorAll("[data-number-only-input]");

numbersOnly.forEach((e) => {
    e.addEventListener("input", (el) => {
        let target = el.target;
        let regex = /\D+/g;

        if (regex.test(target.value)) {
            target.value = target.value.replace(regex, "");
        }
    });
});
