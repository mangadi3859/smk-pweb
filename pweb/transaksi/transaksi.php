<?php
require_once "../utils/conn.php";

if (!isAuth($conn)) {
    exit(header("Location: ../login.php?redirect={$_SERVER["REQUEST_URI"]}"));
}

$type = $_POST["type"];
$idpelanggan = $_POST["idpelanggan"] ?? NULL;

if (!@$type) {
    exit(header("Location: ./"));
}

$sql = @$idpelanggan ? "SELECT idpelanggan, namalengkap FROM `tb_pelanggan` WHERE idpelanggan = '$idpelanggan'" : "SELECT idpelanggan, namalengkap FROM `tb_pelanggan` WHERE namalengkap = 'UMUM'";
$data = queryData($conn, $sql);

$sql_karyawan = "SELECT idkaryawan, nama FROM tb_karyawan WHERE idkaryawan = '{$_SESSION["user"]["idkaryawan"]}'";
$data_karyawan = queryData($conn, $sql_karyawan);

$sql_obat = "SELECT idobat, namaobat, hargajual, stok_obat, keterangan FROM tbobat";
$data_obat = queryData($conn, $sql_obat);

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
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/transaksi.css">

    <!-- JS -->
    <script src="../js/global.js" defer></script>
    <script src="../js/detail-transaksi.js" defer></script>

</head>

<body>
    <?php include "../components/navbar.php" ?>

    <main class="main-container">
        <h1>DETAIL TRANSAKSI</h1>
        <?php
        if (isset($err)) {
            echo "<p id='form-err' class='error'>Gagal: {$err}</p>";
        }
        ?>

        <div class="detail-container">
            <span class="bold">Taggal</span><span>:</span><span><?= date("Y-m-d") ?></span>
            <span class="bold">Nama Pelanggan</span><span>:</span><span><?= $data[0]["namalengkap"] ?></span>
            <span class="bold">Kategori</span><span>:</span><span><?= strtoupper($type) ?></span>
            <span class="bold">Nama Karyawan</span><span>:</span><span><?= $data_karyawan[0]["nama"] ?></span>
        </div>


        <div class="form-container">
            <form class="action-quick" data-input-search method="POST" enctype="multipart/form-data">
                <input required placeholder="Masukan nama obat" id="i-obat" list="list-obat" type="text" class="input-action btn">
                <datalist id="list-obat">
                    <?php
                    foreach ($data_obat as $obat) {
                        echo "<option value='{$obat["namaobat"]}'></option>";
                    }
                    ?>
                </datalist>

                <button title="Search" type="submit" class="btn-primary btn"><i class="fa fa-magnifying-glass"></i></button>
            </form>

            <form class="action-quick" style="display: none;" data-input-submit method="POST" enctype="multipart/form-data">
                <input required placeholder="Masukan Jumlah" id="i-jumlah" type="number" class="input-action btn">
                <button title="Submit" type="submit" class="btn-primary btn"><i class="fa fa-upload"></i></button>
            </form>
            
            <form class="action-quick" data-input-save style="display: none;" method="POST" action="api/add.php" data-purchase-type="<?= $type ?>" data-idpelanggan="<?= $data[0]["idpelanggan"] ?>" data-idkaryawan="<?= $data_karyawan[0]["idkaryawan"] ?>" >
                <input required placeholder="Bayar" id="i-paid" type="number" class="input-action btn">
                <button title="Checkout" type="submit" class="btn-primary btn"><i class="fa fa-cart-plus"></i></button>
            </form>
        </div>

        <div id="preview-container"></div>

        <div class='table-con'>
            <table>
                <thead>
                    <th>#</th>
                    <th>Nama Obat</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Total Harga</th>                    
                    <th>Actions</th>                    
                </thead>
                <tbody data-table-body>
                    <tr data-total-value style="border-top: 2px solid rgb(0 0 0 / .5)">
                        <td class="bold" style="color: black" colspan="4">Total Harga Akhir</td>
                        <td data-total-value-column colspan="2" style="text-align:left;">Rp. 0</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>

    <?php include "../components/footer.php" ?>
</body>

</html>