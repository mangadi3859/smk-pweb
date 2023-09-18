<?php
require_once "../utils/conn.php";

$query = "SELECT tb_karyawan.idkaryawan AS idkaryawan, tb_login.username AS username, tb_login.email AS email, alamat, telp, 
CASE
    WHEN tb_login.idkaryawan IS NOT NULL OR auth.idkaryawan IS NOT NULL
    THEN 1
    ELSE 0
END as is_used
FROM `tb_karyawan` LEFT JOIN tb_login 
USING(idkaryawan)
LEFT JOIN auth 
USING(idkaryawan) 
ORDER BY tb_karyawan.idkaryawan ASC";

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
                    <th>ID Karyawan</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Alamat</th>
                    <th>Telp</th>
                </thead>
                <tbody>
                    <?php
                    foreach ($sql as $data) {
                        echo "<tr>";
                        $inner = "";

                        $is_used = array_pop($data);
                        $attr_btn = $is_used ? "pointer-events: none; cursor: not-allowed; opacity: 0.5;" : "";

                        foreach ($data as $val) {
                            $value = empty($val) ? "<a href='../register.php?ignoreAuth&redirect={$_SERVER['REQUEST_URI']}&k=${data['idkaryawan']}'><i style='opacity: .5'>Not Set~</i></a>" : $val;
                            $inner = $inner . "<td>" . $value . "</td>";
                        }


                        echo $inner;
                        echo <<<act
                    <td>
                        <div class='action-tb'>
                            <a style="$attr_btn" class='btn' href='api/delete.php?id={$data['idkaryawan']}'>DELETE</a>
                            <a class='btn' href='edit.php?id={$data['idkaryawan']}'>EDIT</a>
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