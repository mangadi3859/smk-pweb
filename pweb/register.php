<?php
require_once "utils/conn.php";

$err = $_GET["err"] ?? NULL;
$idkaryawan = $_GET["k"] ?? "";
$ignoreAuth = $_GET["ignoreAuth"] ?? NULL;
$redirect = isset($_GET["redirect"]) ? $_GET["redirect"] : NULL;

if (isAuth($conn) && !isAdmin($_SESSION["user"]) && !@$ignoreAuth) {
    header("Location: " . (isset($redirect) ? $redirect : "index.php"));
    exit;
}

$query = "SELECT tb_karyawan.idkaryawan AS idkaryawan, nama FROM tb_karyawan LEFT JOIN tb_login USING(idkaryawan) WHERE tb_login.username IS NULL";
$karyawan = queryData($conn, $query);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- CSS -->
    <link rel="stylesheet" href="css/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/register.css">

    <!-- JS -->
    <script src="js/global.js" defer></script>
</head>

<body>
    <?php include "components/navbar.php" ?>

    <main class="main-container">
        <form
            action="api/register.php?<?= isset($ignoreAuth) ? "ignoreAuth&" : "" ?>redirect<?= isset($redirect) ? "=" . $redirect : "" ?>"
            method="POST" enctype="application/x-www-form-urlencoded" id="form">

            <p class="title">REGISTER</p>
            <div class="input-container">
                <div class="input-group">
                    <label for="i-id">Kode Karyawan</label>
                    <div class="outer-input">
                        <select required class="input"
                            id="i-id" name="idkaryawan">
                            <option value="">Pilih Kode Karyawan</option>
                            <?php

                            foreach ($karyawan as $data) {
                                $id = $data["idkaryawan"];
                                $nama = $data["nama"];
                                echo "<option value='$id'>$nama</option>";
                            }
                            ?>
                        </select>
                        <label for="i-id" class="fa fas fa-newspaper input-icon"></label>
                    </div>
                </div>

                <div class="input-group">
                    <label for="i-email">Email</label>
                    <div class="outer-input">
                        <input autocomplete="off" class="input" type="email" name="email" required placeholder="Email"
                        id="i-email">
                        <label for="i-email" class="fa fas fa-envelope input-icon"></label>
                    </div>
                </div>

                <div class="input-group">
                    <label for="i-username">Username</label>
                    <div class="outer-input">
                        <input pattern="[A-Za-z0-9_]*" autocomplete="off" class="input" type="text" name="username" required placeholder="Username"
                        id="i-username">
                        <label for="i-username" class="fa fas fa-user input-icon"></label>
                    </div>
                </div>

                <div class="input-group">
                    <label for="i-password">Password</label>
                    <div class="outer-input">
                        <input autocomplete="off" class="input" type="password" placeholder="Password" max="20" required
                        name="password" id="i-password">
                        <label data-password-toggle class="fa fas fa-eye-slash input-icon"></label>
                    </div>
                </div>

                <?php
                if (isset($err)) {
                    echo "<p id='form-err' class='error'>Gagal: {$err}</p>";
                }
                ?>

                <div class="btn-container">
                    <button type="submit">Submit</button>
                    <p>Sudah memiliki akun? <a href="login.php">Login disini</a></p>
                </div>
            </div>

        </form>
    </main>

    <?php include "components/footer.php" ?>
</body>

</html>