<?php
require_once "../utils/conn.php";

$sql = "SELECT * FROM `tb_supplier`";
$supplier = queryData($conn, $sql);

$err = isset($_GET["err"]) ? $_GET["err"] : NULL;
$id = (int) $_GET["id"];

if (!isset($id) || is_nan($id)) {
    header("Location: index.php");
    exit();
}

$data = queryData($conn, "SELECT * FROM tb_karyawan WHERE idkaryawan = '$id'");

if (empty($data)) {
    header("Location: index.php");
    exit();
}

$data = $data[0];

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Karyawan</title>
    <!-- CSS -->
    <link rel="stylesheet" href="../css/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/add-obat.css">

    <!-- JS -->
    <script src="../js/global.js" defer></script>
    <script src="../js/edit-obat.js" defer></script>
</head>

<body>
    <form id="form" action="api/edit.php" method="POST">
        <div class="heading">
            <p class="title">EDIT KARYAWAN</p>
        </div>
        <div class="form-content">
            <label for="i-id">ID Karyawan (READ ONLY)</label>
            <div class="outer-input">
                <div class="input-icon">
                    <label for="i-id" class="fas fa-key"></label>
                </div>
                <input required class="input" max="9999" autocomplete="off" data-number-only-input type="text" id="i-id"
                    name="id" regex="^\d+$" placeholder="ID Karyawan (AUTO_INCREMENT)" value="<?= $id ?>" readonly>
            </div>

            <label for="i-alamat">Alamat</label>
            <div class="outer-input">
                <div class="input-icon">
                    <label for="i-alamat" class="fas fa-map-location"></label>
                </div>
                <input value="<?= $data["alamat"] ?>" type="text" placeholder="Alamat" required class="input"
                    name="alamat" id="i-alamat">
            </div>

            <label for="i-phone">Nomer HP</label>
            <div class="outer-input">
                <div class="input-icon">
                    <label for="i-phone" class="fas fa-square-phone"></label>
                </div>
                <input value="<?= $data["telp"] ?>" regex="^\d{4,20}$" data-number-only-input class="input"
                    autocomplete="off" required type="text" id="i-phone" name="telp" placeholder="Nomer HP">
            </div>

            <?php
            if (isset($err)) {
                echo "<p id='form-err' class='error'>Gagal: {$err}</p>";
            }

            ?>

            <button type="submit">EDIT</button>
        </div>
    </form>
</body>

</html>