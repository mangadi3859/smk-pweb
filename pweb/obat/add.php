<?php
require_once "../utils/conn.php";

if (!isAuth($conn)) {
    exit(header("Location: ../login.php?redirect={$_SERVER["REQUEST_URI"]}"));
}

$sql = "SELECT * FROM `tb_supplier`";
$supplier = queryData($conn, $sql);

$err = isset($_GET["err"]) ? $_GET["err"] : NULL;

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Obat</title>
    <!-- CSS -->
    <link rel="stylesheet" href="../css/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/add-obat.css">

    <!-- JS -->
    <script src="../js/global.js" defer></script>
</head>

<body>
    <?php include "../components/navbar.php" ?>

    <main class="main-container">
        <form id="form" action="api/add.php" method="POST">
            <div class="heading">
                <p class="title">TAMBAH OBAT</p>
            </div>
            <div class="form-content">
                <label for="i-idobat">ID Obat</label>
                <div class="outer-input">
                    <div class="input-icon">
                        <label for="i-idobat" class="fas fa-tablets"></label>
                    </div>
                    <input class="input" max="9999" autocomplete="off" data-number-only-input type="text" id="i-idobat"
                        name="id_obat" regex="^\d+$" placeholder="ID Obat (AUTO_INCREMENT)">
                </div>

                <label for="i-idsupplier">ID Supplier</label>
                <div class="outer-input">
                    <div class="input-icon">
                        <label for="i-idsupplier" class="fas fa-id-card"></label>
                    </div>
                    <!-- <input type="text" class="input"> -->
                    <select class="input" required id="i-idsupplier" name="id_supplier">
                        <option value="">Pilih perusahaan</option>
                        <?php
                        foreach ($supplier as $data) {
                            $id = $data["idsupplier"];
                            $nama = $data["perusahaan"];
                            echo "<option value='$id'>$nama</option>";
                        }
                        ?>
                    </select>
                </div>
                <!-- <input class="input" required type="text" id="i-idsupplier" name="id_supplier" regex="^\d+$"
    placeholder="ID Obat"> -->

                <label for="i-nama">Nama Obat</label>
                <div class="outer-input">
                    <div class="input-icon">
                        <label for="i-nama" class="fas fa-pills"></label>
                    </div>
                    <input class="input" autocapitalize="on" autocomplete="off" required type="text" id="i-nama" name="nama"
                        placeholder="Nama Obat">
                </div>

                <label for="i-co">Kategori Obat</label>
                <div class="outer-input">
                    <div class="input-icon">
                        <label for="i-co" class="fa fa-file"></label>
                    </div>
                    <input autocapitalize class="input" autocomplete="off" required type="text" id="i-co" name="kategori"
                        placeholder="Kategori Obat">
                </div>

                <label for="i-jual">Harga Jual</label>
                <div class="outer-input">
                    <div class="input-icon">
                        <label for="i-jual" class="fas fa-money-bill-trend-up"></label>
                    </div>
                    <input min="1000" class="input" required type="number" id="i-jual" name="jual" placeholder="Harga Jual">
                </div>

                <label for="i-beli">Harga Beli</label>
                <div class="outer-input">
                    <div class="input-icon">
                        <label for="i-beli" class="fa fa-sack-dollar"></label>
                    </div>
                    <input min="0" class="input" required type="number" id="i-beli" name="beli" placeholder="Harga Beli">
                </div>

                <label for="i-stock">Stock Obat</label>
                <div class="outer-input">
                    <div class="input-icon">
                        <label for="i-stock" class="fas fa-cubes"></label>
                    </div>
                    <input min="0" class="input" required type="number" id="i-stock" name="stock" placeholder="Stock Obat">
                </div>
                <label for="i-ket">Keterangan</label>
                <div class="outer-input">
                    <textarea class="input" required name="keterangan" id="i-ket" placeholder="Keterangan" cols="30"
                        rows="10"></textarea>
                </div>

                <?php
                if (isset($err)) {
                    echo "<p id='form-err' class='error'>Gagal: {$err}</p>";
                }

                ?>

                <button type="submit">Submit</button>
            </div>
        </form>
    </main>

    <?php include "../components/footer.php" ?>
</body>

</html>