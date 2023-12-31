<?php
require_once "../utils/conn.php";

$query = "SELECT idobat, perusahaan, namaobat, kategoriobat, hargajual, 
hargabeli, stok_obat, tbobat.keterangan AS keterangan, 
tb_detail_transaksi.iddetailtransaksi AS is_used
FROM `tbobat` INNER JOIN tb_supplier 
USING(idsupplier)
LEFT JOIN tb_detail_transaksi USING(idobat) ORDER BY tbobat.idobat ASC";

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
    <title>Obat</title>
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/home.css">
</head>

<body>
<?php include "../components/navbar.php" ?>

    <main class="main-container">    
        
        <div class="btn-nav-container">
            <a href="add.php" class="btn-add btn btn-primary"><i class="fas fa-plus"></i> Tambah data</a>
            <a href="javascript:window.print()" class="btn-add btn btn-secondary print"><i class="fas fa-print"></i> Print</a>
        </div>

        <div class='table-con'>
            <table>
                <thead>
                    <th>#</th>
                    <th>Supplier</th>
                    <th>Nama Obat</th>
                    <th>Kategori Obat</th>
                    <th>Harga Jual</th>
                    <th>Harga Beli</th>
                    <th>Stock Obat</th>
                    <th>Keterangan</th>
                    <th class="action-head">Actions</th>
                </thead>
                <tbody>
                    <?php
                    foreach ($sql as $data) {
                        echo "<tr>";
                        $inner = "";

                        $data["hargajual"] = "Rp. " . number_format($data["hargajual"], 0, ".", ",");
                        $data["hargabeli"] = "Rp. " . number_format($data["hargabeli"], 0, ".", ",");
                        $is_used = array_pop($data) != NULL;
                        $attr_btn = $is_used ? "pointer-events: none; cursor: not-allowed; opacity: 0.35;" : "";

                        foreach ($data as $val) {
                            $inner = $inner . "<td>" . $val . "</td>";
                        }


                        echo $inner;
                        echo <<<act
                    <td>
                        <div class='action-tb'>
                            <a style="$attr_btn" class='table-action unselect' href='api/delete.php?id={$data['idobat']}'>DELETE</a>
                            <a class='table-action unselect' href='edit.php?id={$data['idobat']}'>EDIT</a>
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