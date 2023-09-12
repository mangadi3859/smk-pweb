const inputOption = document.querySelectorAll("select[data-value]");

inputOption.forEach((e) => {
    e.value = e.dataset.value;
});
