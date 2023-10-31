<?php
require_once "../utils/conn.php";

if (!isAuth($conn)) {
    exit(header("Location: ../login.php?redirect={$_SERVER["REQUEST_URI"]}"));
}

$sql = "SELECT * FROM `tb_supplier`";
$supplier = queryData($conn, $sql);

$err = isset($_GET["err"]) ? $_GET["err"] : NULL;
$id = (int) $_GET["id"];

if (!isset($id) || is_nan($id)) {
    header("Location: index.php");
    exit;
}

$data = queryData($conn, "SELECT * FROM tb_pelanggan WHERE idpelanggan = '$id'");

if (empty($data)) {
    header("Location: index.php");
    exit;
}

$data = $data[0];

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pelanggan</title>
    <!-- CSS -->
    <link rel="stylesheet" href="../css/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/add-obat.css">

    <!-- JS -->
    <script src="../js/global.js" defer></script>
    <script src="../js/edit-obat.js" defer></script>
    <script src="../js/add-pelanggan.js" defer></script>
</head>

<body>
    <?php include "../components/navbar.php" ?>

    <main class="main-container">    
        <form id="form" action="api/edit.php" method="POST">
            <div class="heading">
                <p class="title">EDIT PELANGGAN</p>
            </div>
            <div class="form-content">
                <label for="i-id">ID Pelanggan (READ ONLY)</label>
                <div class="outer-input">
                    <div class="input-icon">
                        <label for="i-id" class="fas fa-key"></label>
                    </div>
                    <input required class="input" max="9999" autocomplete="off" data-number-only-input type="text" id="i-id"
                        name="id" regex="^\d+$" placeholder="ID Karyawan (AUTO_INCREMENT)" value="<?= $id ?>" readonly>
                </div>

                <label for="i-nama">Nama Lengkap</label>
                <div class="outer-input">
                    <div class="input-icon">
                        <label for="i-nama" class="fas fa-chess-queen"></label>
                    </div>
                    <input type="text" value="<?= $data["namalengkap"] ?>" placeholder="Nama Lengkap" required class="input"
                        name="nama" id="i-nama">
                </div>

                <label for="i-alamat">Alamat</label>
                <div class="outer-input">
                    <div class="input-icon">
                        <label for="i-alamat" class="fas fa-map-location"></label>
                    </div>
                    <input type="text" value="<?= $data["alamat"] ?>" placeholder="Alamat" required class="input"
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

                <label for="i-age">Usia</label>
                <div class="outer-input">
                    <div class="input-icon">
                        <label for="i-age" class="fas fa-calendar"></label>
                    </div>
                    <input value="<?= $data["usia"] ?>" regex="^\d{1,3}$" data-number-only-input class="input"
                        autocomplete="off" required type="text" id="i-age" name="usia" placeholder="Usia">
                </div>

                <label for="i-file">Bukti Foto</label>
                <div class="outer-input">
                    <div class="input-icon">
                        <label for="i-file" class="fas fa-file-image"></label>
                    </div>
                    <input accept="image/png, image/jpg, image/jpeg" id="i-file" data-file-input class="input" type="file">
                    <input data-true-file readonly hidden name="file" type="text" value="">
                </div>

                <label for="i-file" class="preview">
                    <div class="preview-overlay">
                        <div>Upload Gambar</div>
                    </div>
                    <img src="<?= $data["buktifotoresep"]; ?>" data-img-preview />
                </label>

                <?php
                if (isset($err)) {
                    echo "<p id='form-err' class='error'>Gagal: {$err}</p>";
                }

                ?>

                <button type="submit">EDIT</button>
            </div>
        </form>
    </main>

    <?php include "../components/footer.php" ?>
</body>

</html>