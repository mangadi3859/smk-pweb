const inputSearch = document.querySelector("[data-input-search]");
const saveButton = document.querySelector("[data-input-save]");
const inputSubmit = document.querySelector("[data-input-submit]");
const inputSearchInput = document.querySelector("[data-input-search] #i-obat");
const inputSubmitInput = document.querySelector("[data-input-submit] #i-jumlah");
const previewContainer = document.querySelector("#preview-container");
const tableBody = document.querySelector("[data-table-body]");
const totalValueRow = document.querySelector("[data-total-value]");
const totalValueColumn = document.querySelector("[data-total-value-column]");
const items = [];

inputSearch.addEventListener("submit", async (e) => {
    e.preventDefault();
    await handleSearch();
});

saveButton.addEventListener("submit", async (e) => {
    e.preventDefault();
    let target = e.target;

    let payload = {
        kategori: target.dataset.purchaseType,
        idpelanggan: target.dataset.idpelanggan,
        idkaryawan: target.dataset.idkaryawan,
        items,
        paid: parseInt(target.querySelector("input").value),
    };

    try {
        let proc = await fetch("api/add.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(payload),
        });

        if (!proc.ok) throw new Error(proc);
        window.alert("Transaksi Berhasil");
        window.location = "./";
    } catch (err) {
        window.alert("Transaksi Gagal");
        console.log(err);
    }
});

inputSubmit.addEventListener("submit", async (e) => {
    e.preventDefault();
    if (!document.querySelector("#preview-obat")) return;

    let process = await getMedicine(null, document.querySelector("#preview-obat").dataset.idobat);

    if (!process) return window.alert("Not Found");
    let json = await process.json();

    if (!Array.isArray(json) || !json.length) {
        console.log(json);
        return window.alert("Not Found");
    }

    let data = json[0];

    if (!items.some((e) => e.idobat == data.idobat)) items.push({ ...data, jumlah: parseInt(inputSubmitInput.value) || 1 });
    handleItems();
    inputSubmit.style.display = "none";
    inputSubmitInput.value = "";
    document.querySelector("#preview-obat")?.remove();
});

inputSubmitInput.addEventListener("input", (e) => {
    e.preventDefault();

    if (!document.querySelector("#preview-obat")) return;
    let price = parseInt(document.querySelector("[data-price]")?.dataset.price) || 0;
    let quantity = document.querySelector("[data-quantity]");
    let totalPrice = document.querySelector("[data-total-price]");
    let value = e.target.value;

    if (value <= 0) {
        e.target.value = 1;
        value = 1;
    }

    quantity.innerText = value;
    totalPrice.innerText = "Rp. " + (value * price).toLocaleString();
});

async function handleSearch(idobat) {
    let process = await getMedicine(inputSearchInput.value, idobat);

    if (!process) return window.alert("Not Found");

    let json = await process.json();

    if (!Array.isArray(json) || !json.length) {
        console.log(json);
        return window.alert("Not Found");
    }

    let data = json[0];

    let innerHTML = `
    <div class='table-con' id="preview-obat" data-idobat="${data.idobat}">
        <table>
            <thead>
                <th>#</th>
                <th>Nama Obat</th>
                <th>Kategori</th>
                <th>Keterangan</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Total Harga</th>                    
            </thead>
            <tbody>
                <tr>
                    <td>${data.idobat}</td>
                    <td>${data.namaobat}</td>
                    <td>${data.kategoriobat}</td>
                    <td>${data.keterangan}</td>
                    <td data-price="${data.hargajual}">Rp. ${parseInt(data.hargajual)?.toLocaleString()}</td>
                    <td data-quantity>1</td>
                    <td data-total-price>Rp. ${parseInt(data.hargajual)?.toLocaleString()}</td>
                </tr>
            </tbody>
        </table>
    </div>`;

    previewContainer.innerHTML = innerHTML;
    inputSubmit.style.display = null;
    inputSubmitInput.setAttribute("max", data.stok_obat);
    inputSubmitInput.setAttribute("placeholder", `Jumlah (0-${data.stok_obat})`);
    inputSearchInput.dataset.lastInput = inputSearchInput.value;

    // console.log(fetch());
}

async function getMedicine(name = "", id = "") {
    try {
        let process = await fetch("api/search.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: new URLSearchParams({
                name,
                id,
            }),
        });

        return process;
    } catch (e) {
        window.alert("Error: " + e.message);
    } finally {
        inputSearchInput.value = "";
    }
}

function handleItems() {
    tableBody.querySelectorAll("tr:not([data-total-value])").forEach((e) => e.remove());
    if (items.length) saveButton.style.display = null;
    else saveButton.style.display = "none";

    items.forEach((e, i) => {
        let html = "";
        let tr = document.createElement("tr");
        tr.dataset.itemIndex = i;
        html += `
            <td>${i + 1}</td>
            <td>${e.namaobat}</td>
            <td>${e.jumlah}</td>
            <td>Rp. ${parseInt(e.hargajual).toLocaleString()}</td>
            <td>Rp. ${(e.jumlah * parseInt(e.hargajual)).toLocaleString()}</td>
        `;

        html += `
        <td>
            <div class='action-tb'>
                <a class='table-action unselect' href='javascript:handleDeleteItem(${i})'>DELETE</a>
                <a class='table-action unselect' href='javascript:handleEditItem(${e.idobat}, ${i})'>EDIT</a>
            </div>
        </td>
        `;

        tr.innerHTML = html;
        tableBody.insertBefore(tr, totalValueRow);
    });

    let total = items.reduce((pre, now) => pre + now.jumlah * parseInt(now.hargajual), 0);
    totalValueColumn.innerHTML = `Rp. ${total.toLocaleString()}`;
    saveButton.querySelector("input").setAttribute("min", total);
}

function handleDeleteItem(index) {
    items.splice(index, 1);
    handleItems();
}
function handleEditItem(idobat, index) {
    handleSearch(idobat);
    handleDeleteItem(index);
}
