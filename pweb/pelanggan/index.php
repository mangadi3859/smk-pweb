<?php
require_once "../utils/conn.php";

$query = "SELECT tb_pelanggan.idpelanggan AS idpelanggan, namalengkap, alamat, telp, usia, buktifotoresep, tb_transaksi.idpelanggan AS is_used
FROM `tb_pelanggan` LEFT JOIN tb_transaksi 
USING(idpelanggan)
ORDER BY tb_pelanggan.idpelanggan ASC";

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
    <title>Karyawan</title>
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/home.css">
</head>

<body>
    <div class="container">
        <?php
        echo "<h1 class='head'>";
        echo isAuth($conn) ? "SUDAH LOGIN" : "BELUM LOGIN";
        echo "</h1>";
        echo isAuth($conn) ? "<a style='color: aqua;' href='../logout.php?redirect={$_SERVER["REQUEST_URI"]}'>Logout</a>" : "<a style='color: aqua;' href='../login.php?redirect={$_SERVER["REQUEST_URI"]}'>Login Here</a>";

        ?>
        <div class='table-con'>
            <table>
                <thead>
                    <th>ID Pelanggan</th>
                    <th>Nama Lengkap</th>
                    <th>Alamat</th>
                    <th>Nomer HP</th>
                    <th>Usia</th>
                    <th>Bukti Foto Resep</th>
                </thead>
                <tbody>
                    <?php
                    foreach ($sql as $data) {
                        echo "<tr>";
                        $inner = "";

                        $is_used = array_pop($data);
                        $attr_btn = $is_used ? "pointer-events: none; cursor: not-allowed; opacity: 0.5;" : "";

                        foreach ($data as $val) {
                            $inner = $inner . "<td>" . $val . "</td>";
                        }

                        echo $inner;
                        echo <<<act
                    <td>
                        <div class='action-tb'>
                            <a style="$attr_btn" class='btn' href='api/delete.php?id={$data['idpelanggan']}'>DELETE</a>
                            <a class='btn' href='edit.php?id={$data['idpelanggan']}'>EDIT</a>
                        </div>
                    </td> 
                    act;
                    }

                    echo "</tr>";
                    ?>

                </tbody>
            </table>
        </div>

    </div>
</body>

</html>