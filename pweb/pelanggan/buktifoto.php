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
    <?php include "../components/navbar.php" ?>

    <main class="main-container">
        <div class="img-con" style="background-color: var(--neutral-400); width: 100%; border-radius: .15rem; box-shadow: 0 .5rem 5rem 0 rgb(0 0 0 / .3); padding: 2rem;">
            <h2 style='color: black; margin: 0'>Bukti foto resep dari <a style='color: var(--primary-400);' href='./'><?= $data["namalengkap"] ?></a></h2>
            <div style="display: grid; palce-items: center; padding: 2rem;">
                <img style="display: block; margin-inline: auto; max-width: 100%;" src="<?= $data["data64"] ?>" alt="">
            </div>
        </div>
    </main>

    <?php include "../components/footer.php" ?>
</body>
</html>