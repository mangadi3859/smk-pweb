<?php
require_once "utils/conn.php";

$redirect = isset($_GET["redirect"]) ? $_GET["redirect"] : NULL;
if (isAuth($conn)) {
    header("Location: " . (isset($redirect) ? $redirect : "index.php"));
    exit;
}

$err = isset($_GET["err"]) ? $_GET["err"] : NULL;
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- CSS -->
    <link rel="stylesheet" href="css/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/login.css">

    <!-- JS -->
    <script src="js/global.js" defer></script>

</head>

<body>
    <?php include "components/navbar.php" ?>
    <main class="main-container">
        <form action="api/login.php?redirect<?= isset($redirect) ? "=" . $redirect : "" ?>" method="POST" id="form">
            <p class="title">LOGIN</p>
            <div class="input-container">

                <div class="input-group">
                    <label for="i-username">Username</label>
                    <div class="outer-input">
                        <input pattern="[A-Za-z0-9_@\.]*" class="input" type="text" name="username" required placeholder="Username or email" id="i-username">
                        <label for="i-username" class="fa fas fa-user input-icon"></label>
                    </div>
                </div>

                <div class="input-group">
                    <label for="i-password">Password</label>
                    <div class="outer-input">
                        <input class="input" type="password" placeholder="Password" max="20" required name="password" id="i-password">
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
                    <p>Belum memiliki akun? <a href="register.php">Buat akun disini</a></p>
                </div>
            </div>
            </form>
    </main>
    <?php include "components/footer.php" ?>
</body>

</html>