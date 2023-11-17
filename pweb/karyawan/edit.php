<?php
require_once "../utils/conn.php";

if (!isAuth($conn)) {
    exit(header("Location: ../login.php?redirect={$_SERVER["REQUEST_URI"]}"));
}

if (!isAdmin($_SESSION["user"])) {
    exit(header("Location: ../_403.php?msg=Access Denied"));
}

$err = isset($_GET["err"]) ? $_GET["err"] : NULL;
$id = (int) $_GET["id"];
$is_master = isMaster($_SESSION["user"]);

if (!isset($id) || is_nan($id)) {
    header("Location: index.php");
    exit;
}

$master_query = "SELECT tb_karyawan.idkaryawan AS idkaryawan, nama, alamat, telp, username, email, leveluser 
FROM tb_karyawan 
LEFT JOIN tb_login USING(idkaryawan) 
WHERE tb_karyawan.idkaryawan = '$id'";

$query = "SELECT * FROM tb_karyawan WHERE idkaryawan = '$id'";
$data = queryData($conn, $is_master ? $master_query : $query);

if (empty($data)) {
    header("Location: index.php");
    exit;
}

$data = $data[0];
$action = $is_master && @$data["username"] ? "api/master-edit.php" : "api/edit.php";
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
    <?php include "../components/navbar.php" ?>

    <main class="main-container">
        <form id="form" action="<?= $action ?>" method="POST">
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

                <label for="i-nama">Nama</label>
                <div class="outer-input">
                    <div class="input-icon">
                        <label for="i-nama" class="fas fa-user"></label>
                    </div>
                    <input type="text" placeholder="Nama Karyawan" required class="input" name="nama" id="i-nama" value="<?= $data["nama"] ?>">
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
                if ($is_master && @$data["username"]) {
                    $options = "";
                    foreach (array_filter($LEVEL_USER, function ($i) {
                        return !is_int($i);
                    }) as $k => $lvl) {
                        if ($k == $LEVEL_USER["MASTER"] && $data["leveluser"] != $LEVEL_USER["MASTER"])
                            continue;
                        $select = $k == $data["leveluser"] ? "selected" : "";
                        $options .= "<option $select value='$k'>$lvl</option>";
                    }

                    $blockmaster = $data["leveluser"] == $LEVEL_USER["MASTER"] ? "readonly style='pointer-events: none;'" : "";
                    $masterForm = <<<frm
                        <label for="i-username">Username</label>
                        <div class="outer-input">
                            <div class="input-icon">
                                <label for="i-username" class="fas fa-id-badge"></label>
                            </div>
                            <input value="{$data["username"]}" class="input"
                                autocomplete="off" required type="text" id="i-username" name="username" placeholder="Nomer HP">
                        </div>

                        <div class="input-group">
                            <label for="i-email">Email</label>
                            <div class="outer-input">
                                <div class="input-icon">
                                    <label for="i-username" class="fas fa-id-badge"></label>
                                </div>
                                <input value="{$data["email"]}" autocomplete="off" class="input" type="email" name="email" required placeholder="Email"
                                id="i-email">
                            </div>
                        </div>

                        <label for="i-lvl">Privilege</label>
                        <div class="outer-input">
                            <div class="input-icon">
                                <label for="i-lvl" class="fas fa-crown"></label>
                            </div>
                            <!-- <input type="text" class="input"> -->
                            <select $blockmaster class="input" required id="i-lvl" name="level">
                                $options
                            </select>
                        </div>
                    frm;

                    echo $masterForm;
                }
                ?>

                

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