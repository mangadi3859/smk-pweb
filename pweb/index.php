<?php
require_once "utils/conn.php";

$query = "SELECT idobat, perusahaan, namaobat, kategoriobat, hargajual, 
hargabeli, stok_obat, tbobat.keterangan AS keterangan, 
tb_detail_transaksi.iddetailtransaksi AS is_used
FROM `tbobat` INNER JOIN tb_supplier 
USING(idsupplier)
LEFT JOIN tb_detail_transaksi USING(idobat);";

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
    <title>Home</title>
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/home.css">
</head>

<body>
    <div class="container">
        <?php
        echo "<h1 class='head'>";
        echo isAuth($conn) ? "SUDAH LOGIN" : "BELUM LOGIN";
        echo "</h1>";
        echo isAuth($conn) ? "<a style='color: aqua;' href='logout.php'>Logout</a>" : "<a style='color: aqua;' href='login.php'>Login Here</a>";

        ?>
        <table>
            <thead>
                <th>ID Obat</th>
                <th>Supplier</th>
                <th>Nama Obat</th>
                <th>Kategori Obat</th>
                <th>Harga Jual</th>
                <th>Harga Beli</th>
                <th>Stock Obat</th>
                <th>Keterangan</th>
                <th>Actions</th>
            </thead>
            <tbody>
                <?php
                foreach ($sql as $data) {
                    echo "<tr>";
                    $inner = "";

                    $is_used = array_pop($data) != NULL;
                    $attr_btn = $is_used ? "pointer-events: none; cursor: not-allowed; opacity: 0.5;" : "";

                    foreach ($data as $val) {
                        $inner = $inner . "<td>" . $val . "</td>";
                    }


                    echo $inner;
                    echo <<<act
                    <td>
                        <div class='action-tb'>
                            <a style="$attr_btn" class='btn' href='api/delete-obat.php?id={$data['idobat']}'>DELETE</a>
                            <a class='btn' href='edit-obat.php?id={$data['idobat']}'>EDIT</a>
                        </div>
                    </td> 
                    act;
                }

                echo "</tr>";
                ?>

            </tbody>
        </table>

    </div>
</body>

</html>