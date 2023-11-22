<?php
require_once "../utils/conn.php";

$query = "SELECT tb_transaksi.idtransaksi AS idtransaksi, tb_pelanggan.namalengkap AS nama_pelanggan, tb_karyawan.nama AS nama_karyawan, tb_transaksi.tgltransaksi AS tgltransaksi, tb_transaksi.kategoripelanggan AS kategoripelanggan, tb_transaksi.totalbayar AS totalbayar, tb_transaksi.bayar AS bayar, tb_transaksi.kembali AS kembali 
FROM tb_transaksi
JOIN tb_karyawan USING(idkaryawan)
JOIN tb_pelanggan USING(idpelanggan)
";


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

$sql = queryData($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi</title>
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/home.css">
</head>

<body>
    <?php include "../components/navbar.php" ?>

    <main class="main-container">
        <div class="btn-nav-container">
            <a href="add.php" class="btn-add btn btn-primary"><i class="fas fa-plus"></i> Tambah transaksi</a>
            <!-- <a href="transaction.php" class="btn-add btn btn-secondary"><i class="fas fa-cart-plus"></i> Tambah transaksi</a> -->
            <a href="javascript:window.print()" class="btn-add btn btn-secondary print"><i class="fas fa-print"></i> Print</a>
        </div>
        
        <div class='table-con'>
            <table>
                <thead>
                    <th>#</th>
                    <th>Nama Pelanggan</th>
                    <th>Nama Karyawan</th>
                    <th>Tanggal Transaksi</th>
                    <th>Tipe Transaksi</th>
                    <th>Tagihan</th>
                    <th>Bayar</th>
                    <th>Kembalian</th>
                    <th class="action-head">Actions</th>
                </thead>
                <tbody>
                    <?php
                    foreach ($sql as $data) {
                        echo "<tr>";
                        $inner = "";

                        $data["totalbayar"] = "Rp. " . number_format($data["totalbayar"], 0, ".", ",");
                        $data["bayar"] = "Rp. " . number_format($data["bayar"], 0, ".", ",");
                        $data["kembali"] = "Rp. " . number_format($data["kembali"], 0, ".", ",");
                        // unset($data["buktifotoresep"]);
                    
                        foreach ($data as $val) {
                            $inner .= "<td>" . $val . "</td>";
                        }

                        echo $inner;
                        echo <<<act
                    <td>
                        <div class='action-tb'>
                            <a class='table-action unselect' style="background-color: var(--accent-200); border-color: var(--accent-base); --shadow: var(--accent-base);" href='detail-transaksi.php?id={$data['idtransaksi']}'>VIEW</a>
                            <a class='table-action unselect' href='edit.php?id={$data['idtransaksi']}'>EDIT</a>
                        </div>
                    </td> 
                    act;
                    }

                    echo "</tr>";
                    ?>

                </tbody>
            </table>
        </div>
    </main>

    <?php include "../components/footer.php" ?>    
</body>

</html>