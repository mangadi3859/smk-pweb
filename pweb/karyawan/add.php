<?php
require_once "../utils/conn.php";


if (!isAuth($conn)) {
    exit(header("Location: ../login.php?redirect={$_SERVER["REQUEST_URI"]}"));
}

if (!isAdmin($_SESSION["user"])) {
    exit(header("Location: ../_403.php?msg=Access Denied"));
}

$sql = "SELECT * FROM `tb_supplier`";
$supplier = queryData($conn, $sql);


$err = isset($_GET["err"]) ? $_GET["err"] : NULL;

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Karyawan</title>
    <!-- CSS -->
    <link rel="stylesheet" href="../css/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/add-obat.css">

    <!-- JS -->
    <script src="../js/global.js" defer></script>
</head>

<body>
    <?php include "../components/navbar.php" ?>

    <main class="main-container">    
        <form id="form" action="api/add.php" method="POST">
            <div class="heading">
                <p class="title">TAMBAH KARYAWAN</p>
            </div>
            <div class="form-content">
                <label for="i-nama">Nama</label>
                <div class="outer-input">
                    <div class="input-icon">
                        <label for="i-nama" class="fas fa-user"></label>
                    </div>
                    <input type="text" placeholder="Nama Karyawan" required class="input" name="nama" id="i-nama">
                </div>

                <label for="i-alamat">Alamat</label>
                <div class="outer-input">
                    <div class="input-icon">
                        <label for="i-alamat" class="fas fa-map-location"></label>
                    </div>
                    <input type="text" placeholder="Alamat" required class="input" name="alamat" id="i-alamat">
                </div>
                <!-- <input class="input" required type="text" id="i-idsupplier" name="id_supplier" regex="^\d+$"
    placeholder="ID Obat"> -->

                <label for="i-phone">Nomer HP</label>
                <div class="outer-input">
                    <div class="input-icon">
                        <label for="i-phone" class="fas fa-square-phone"></label>
                    </div>
                    <input regex="^\d{4,20}$" data-number-only-input class="input" autocomplete="off" required type="text"
                        id="i-phone" name="telp" placeholder="Nomer HP">
                </div>

                <?php
                if (isset($err)) {
                    echo "<p id='form-err' class='error'>Gagal: {$err}</p>";
                }

                ?>

                <button type="submit">Submit</button>
            </div>
        </form>
    </main>

    <?php include "../components/footer.php" ?>
</body>

</html>