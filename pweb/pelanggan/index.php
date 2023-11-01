<?php
require_once "../utils/conn.php";

$query = "SELECT tb_pelanggan.idpelanggan AS idpelanggan, namalengkap, alamat, telp, usia, tb_transaksi.idpelanggan AS is_used
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
    <?php include "../components/navbar.php" ?>

    <main class="main-container">
        <a href="add.php" class="btn-add btn btn-primary">Tambah data</a>
        
        <div class='table-con'>
            <table>
                <thead>
                    <th>#</th>
                    <th>Nama Lengkap</th>
                    <th>Alamat</th>
                    <th>Nomer HP</th>
                    <th>Usia</th>
                    <th>Bukti Foto Resep</th>
                    <th class="action-head">Actions</th>
                </thead>
                <tbody>
                    <?php
                    foreach ($sql as $data) {
                        echo "<tr>";
                        $inner = "";

                        $is_used = array_pop($data);
                        $attr_btn = $is_used ? "pointer-events: none; cursor: not-allowed; opacity: 0.35;" : "";
                        unset($data["buktifotoresep"]);

                        foreach ($data as $val) {
                            $inner .= "<td>" . $val . "</td>";
                        }

                        $inner .= "<td><a href='buktifoto.php?id={$data["idpelanggan"]}'>See Picture</a></td>";
                        echo $inner;
                        echo <<<act
                    <td>
                        <div class='action-tb'>
                            <a style="$attr_btn" class='table-action unselect' href='api/delete.php?id={$data['idpelanggan']}'>DELETE</a>
                            <a class='table-action unselect' href='edit.php?id={$data['idpelanggan']}'>EDIT</a>
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