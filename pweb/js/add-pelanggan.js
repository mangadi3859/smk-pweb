const inputFile = document.querySelector("[data-file-input]");
const trueInputFile = document.querySelector("[data-true-file]");
const imgPreview = document.querySelector("[data-img-preview]");

let defaultImage = imgPreview.getAttribute("src");
if (!defaultImage) imgPreview.parentNode.style.opacity = "0";

inputFile.addEventListener("change", async (e) => {
    let img = e.target.files[0];

    if (defaultImage && !img) {
        imgPreview.parentNode.style.opacity = "1";
        return imgPreview.setAttribute("src", defaultImage);
    }
    if (!img) {
        imgPreview.style.display = "none";
        imgPreview.parentNode.style.opacity = "0";
        handleTrueInput();
        return imgPreview.removeAttribute("src");
    }

    try {
        let bufferedFile = await readFile64(img);

        imgPreview.style.display = "initial";
        imgPreview.setAttribute("src", bufferedFile);
        handleTrueInput(bufferedFile);
        imgPreview.parentNode.style.opacity = "1";
    } catch (e) {
        alert("Error! buka console buat melihat error");
        console.error(e);
    }
});

function readFile64(file) {
    return new Promise((resolve, reject) => {
        const reader = new FileReader(file);

        reader.onload = (e) => {
            resolve(e.target.result);
        };

        reader.onerror = reject;
        reader.readAsDataURL(file);
    });
}

function handleTrueInput(base64Data) {
    if (!trueInputFile) return;
    if (!base64Data) {
        trueInputFile.value = "";
        return;
    }

    trueInputFile.value = base64Data;
}
