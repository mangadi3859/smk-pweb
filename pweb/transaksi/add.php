<?php
require_once "../utils/conn.php";

if (!isAuth($conn)) {
    exit(header("Location: ../login.php?redirect={$_SERVER["REQUEST_URI"]}"));
}

$sql = "SELECT namalengkap, idpelanggan FROM `tb_pelanggan`";
$data = queryData($conn, $sql);

$err = isset($_GET["err"]) ? $_GET["err"] : NULL;

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi</title>
    <!-- CSS -->
    <link rel="stylesheet" href="../css/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/add-obat.css">

    <!-- JS -->
    <script src="../js/global.js" defer></script>
    <script src="../js/transaksi.js" defer></script>

</head>

<body>
    <?php include "../components/navbar.php" ?>

    <main class="main-container">
        <form id="form" action="transaksi.php" method="POST" enctype="multipart/form-data">
            <div class="heading">
                <p class="title">TRANSAKSI</p>
            </div>
            <div class="form-content" style="min-height: 15rem;">
                <label for="i-type">Kategori Pelanggan</label>
                <div class="outer-input">
                    <div class="input-icon">
                        <label for="i-type" class="fas fa-cubes"></label>
                    </div>
                    <select required class="input"
                        id="i-type" name="type">
                        <option value="umum">Umum</option>
                        <option value="langganan">Langganan</option>
                    </select>
                </div>

                <label for="i-type" data-input-pelanggan style="display: none;">Pelanggan</label>
                <div class="outer-input" data-input-pelanggan style="display: none;">
                    <div class="input-icon">
                        <label for="i-pelanggan" class="fas fa-user"></label>
                    </div>
                    <select required class="input"
                        id="i-pelanggan" name="idpelanggan" data-pelanggan>
                        <option value="">Pilih Pelanggan</option>                        
                        <?php

                        foreach ($data as $val) {
                            if ($val["namalengkap"] == "UMUM")
                                continue;

                            echo "<option value='{$val["idpelanggan"]}'>{$val["namalengkap"]} - {$val["idpelanggan"]}</option>";
                        }

                        ?>
                    </select>
                </div>

                <?php
                if (isset($err)) {
                    echo "<p id='form-err' class='error'>Gagal: {$err}</p>";
                }
                ?>

                <button type="submit">Lanjutkan</button>
            </div>
        </form>
    </main>

    <?php include "../components/footer.php" ?>
</body>

</html>