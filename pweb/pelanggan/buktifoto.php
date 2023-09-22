<?php
require_once "../utils/conn.php";

$id = $_GET["id"] ?? NULL;

if (!isset($id))
    exit(header("Location: ./"));


$query = "SELECT namalengkap, buktifotoresep AS data64 FROM tb_pelanggan WHERE idpelanggan = '$id'";
$sql = queryData($conn, $query);

if (empty($sql))
    exit(header("Location: ./"));

$data = $sql[0];
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



        echo "<h2 class='head'>Bukti foto resep dari <a style='color: aqua;' href='./'>{$data["namalengkap"]}</a></h2>";
        ?>
        <div class='table-con' style="display: grid; palce-items: center; padding: 2rem;">
            <img style="display: block; margin-inline: auto; max-width: 100%;" src="<?= $data["data64"] ?>" alt="">
        </div>

    </div>
</body>

</html>