<?php
require_once "../utils/conn.php";

if (!isAuth($conn)) {
    exit(header("Location: ../login.php?redirect={$_SERVER["REQUEST_URI"]}"));
}


$err = isset($_GET["err"]) ? $_GET["err"] : NULL;
$id = (int) $_GET["id"];

if (!isset($id) || is_nan($id)) {
    header("Location: index.php");
    exit;
}

$sql_transaksi = "SELECT * FROM tb_transaksi WHERE idtransaksi = '$id'";
$transaksi = queryData($conn, $sql_transaksi);

if (empty($transaksi)) {
    header("Location: ./");
}

$sql_pelanggan = "SELECT idpelanggan, namalengkap FROM `tb_pelanggan`";
$pelanggan = queryData($conn, $sql_pelanggan);

$sql_karyawan = "SELECT idkaryawan, nama FROM `tb_karyawan`";
$karyawan = queryData($conn, $sql_karyawan);


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Transaksi</title>
    <!-- CSS -->
    <link rel="stylesheet" href="../css/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/add-obat.css">

    <!-- JS -->
    <script src="../js/global.js" defer></script>
    <script src="../js/edit-obat.js" defer></script>
    <script src="../js/add-pelanggan.js" defer></script>
</head>

<body>
    <?php include "../components/navbar.php" ?>

    <main class="main-container">    
        <form id="form" action="api/edit.php" method="POST">
            <div class="heading">
                <p class="title">EDIT TRANSAKSI</p>
            </div>
            <div class="form-content">
                <label for="i-id">ID Transaksi (READ ONLY)</label>
                <div class="outer-input">
                    <div class="input-icon">
                        <label for="i-id" class="fas fa-key"></label>
                    </div>
                    <input required class="input" max="9999" autocomplete="off" data-number-only-input type="text" id="i-id"
                        name="id" regex="^\d+$" placeholder="ID Transaksi (AUTO_INCREMENT)" value="<?= $id ?>" readonly>
                </div>

                <label for="i-idkaryawan">Karyawan</label>
                <div class="outer-input">
                    <label for="i-idkaryawan" class="fa fas fa-address-card input-icon"></label>
                    <select required class="input"
                        id="i-idkaryawan" name="idkaryawan">
                        <option value="">Pilih Karyawan</option>
                        <?php

                        foreach ($karyawan as $data) {
                            $id = $data["idkaryawan"];
                            $nama = $data["nama"];
                            $select = $transaksi[0]["idkaryawan"] == $id ? "selected" : "";
                            echo "<option $select value='$id'>$nama</option>";
                        }
                        ?>
                    </select>
                </div>

                <label for="i-kategori">Kategori</label>
                <div class="outer-input">
                    <label for="i-kategori" class="fa fas fa-fire input-icon"></label>
                    <select required class="input"
                        id="i-kategori" name="kategori">
                        <option value="">Pilih Kategori</option>
                        <?php
                        if ($transaksi[0]["kategoripelanggan"] == "umum") {
                            echo "<option selected value='umum'>UMUM</option>";
                            echo "<option value='langganan'>LANGGANAN</option>";
                        } else {
                            echo "<option value='umum'>UMUM</option>";
                            echo "<option selected value='langganan'>LANGGANAN</option>";
                        }
                        ?>
                    </select>
                </div>

                <label for="i-idpelanggan">Pelanggan</label>
                <div class="outer-input">
                    <label for="i-idpelanggan" class="fa fas fa-crown input-icon"></label>
                    <select required class="input"
                        id="i-idpelanggan" name="idpelanggan">
                        <option value="">Pilih Pelanggan</option>
                        <?php

                        foreach ($pelanggan as $data) {
                            $id = $data["idpelanggan"];
                            $nama = $data["namalengkap"];
                            $select = $transaksi[0]["idpelanggan"] == $id ? "selected" : "";
                            echo "<option $select value='$id'>$nama</option>";
                        }
                        ?>
                    </select>
                </div>

                <label for="i-date">Tanggal</label>
                <div class="outer-input">
                    <label for="i-date" class="fa fas fa-calendar-days input-icon"></label>
                    <input required type="date" value="<?= $transaksi[0]["tgltransaksi"] ?>" class="input" id="i-date" name="tanggal" />
                </div>

                <label for="i-date">Bayar (Rp. <?= $transaksi[0]["totalbayar"] ?>)</label>
                <div class="outer-input">
                    <label for="i-date" class="fa fas fa-money input-icon"></label>
                    <input required type="number" min="<?= $transaksi[0]["totalbayar"] ?>"  value="<?= $transaksi[0]["bayar"] ?>" class="input" id="i-paid" name="totalbayar" />
                </div>

                <?php
                if (isset($err)) {
                    echo "<p id='form-err' class='error'>Gagal: {$err}</p>";
                }

                ?>

                <button type="submit">EDIT</button>
            </div>
        </form>
    </main>

    <?php include "../components/footer.php" ?>
</body>

</html>