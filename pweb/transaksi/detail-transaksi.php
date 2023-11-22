<?php
require_once "../utils/conn.php";

$idtransaksi = $_GET["id"] ?? NULL;

if (!@$idtransaksi) {
    exit(header("Location: ./"));
}

$sql = "SELECT * FROM tb_transaksi 
WHERE idtransaksi = '$idtransaksi'";
$data = queryData($conn, $sql);

if (sizeof($data) < 1) {
    header("Location: ./");
}

$sql_items = "SELECT * FROM tb_detail_transaksi
JOIN tbobat USING(idobat)
WHERE idtransaksi = '$idtransaksi'";
$data_items = queryData($conn, $sql_items);

// $query = "SELECT idobat, perusahaan, namaobat, kategoriobat, hargajual, 
// hargabeli, stok_obat, tbobat.keterangan AS keterangan, 
// CASE 
// WHEN tb_detail_transaksi.iddetailtransaksi IS NOT NULL 
//     THEN 1
//     ELSE 0
// END AS is_used
// FROM `tbobat` INNER JOIN tb_supplier 
// USING(idsupplier)
// LEFT JOIN tb_detail_transaksi USING(idobat);";

// $sql = queryData($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Transaksi</title>
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/home.css">
    <link rel="stylesheet" href="../css/transaksi.css">
</head>

<body>
    <?php include "../components/navbar.php" ?>

    <main class="main-container">
        <div class="btn-nav-container">
            <a href="./" class="btn-add btn btn-primary"><i class="fas fa-angle-left"></i> Kembali</a>
            <a href="javascript:window.print()" class="btn-add btn btn-secondary print"><i class="fas fa-print"></i> Print</a>
        </div>
        
        </html>
        <div class="table-con">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Obat</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Total Harga</th>                    
                    </tr>
                </thead>
                <tbody data-table-body="">
                    <?php

                    $grand_price = array_reduce($data_items, function ($pre, $now) {
                        return $pre + $now["totalharga"];
                    }, 0);
                    foreach ($data_items as $i => $item) {
                        $index = $i + 1;
                        $harga = "Rp. " . number_format($item["hargasatuan"], 0, ".", ",");
                        $totalharga = "Rp. " . number_format($item["totalharga"], 0, ".", ",");

                        echo <<<tr
                        <tr>
                            <td>$index</td>
                            <td>{$item["namaobat"]}</td>
                            <td>{$item["jumlah"]}</td>
                            <td>$harga</td>
                            <td>$totalharga</td>
                        <tr>
                        tr;
                    }

                    ?>
                    
                    <tr data-total-value="" style="border-top: 2px solid rgb(0 0 0 / .3)">
                        <td colspan="3"></td>
                        <td colspan="1" style="text-align:left;">Total Harga Akhir</td>
                        <td data-total-value-column="" style="text-align:left; color: black;"><?= "Rp. " . number_format($grand_price, 0, ".", ","); ?></td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                        <td colspan="1" style="text-align:left; color: black;">Total Bayar</td>
                        <td data-total-value-column="" style="text-align:left;"><?= "Rp. " . number_format($data[0]["bayar"], 0, ".", ","); ?></td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                        <td colspan="1" style="text-align: left; color: black;">Kembalian</td>
                        <td data-total-value-column="" style="text-align:left;"><?= "Rp. " . number_format($data[0]["kembali"], 0, ".", ","); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>

    <?php include "../components/footer.php" ?>    
</body>