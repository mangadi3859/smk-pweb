<?php
require_once "utils/conn.php";

$redirect = isset($_GET["redirect"]) ? $_GET["redirect"] : NULL;
if (isAuth($conn)) {
    header("Location: " . (isset($redirect) ? $redirect : "index.php"));
}
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
    <form action="api/register.php?redirect<?= isset($redirect) ? "=" . $redirect : "" ?>" method="POST"
        enctype="application/x-www-form-urlencoded" id="form">
        <!-- <div class="heading">
            <p class="title">Register</p>
        </div>
        <disv class="form-content">
            <label for="i-username">Username</label>
            <input type="text" name="username" required placeholder="Username" id="i-username">
            <label for="i-id">Kode Karyawan</label>
            <input type="text" maxLength="4" required placeholder="Kode karyawan" regex="^\d{1,4}$" name="idkaryawan"
                id="i-id">
            <label for="i-password">Password</label>
            <input type="password" placeholder="Password" max="20" required name="password" id="i-password">
            <button type="submit">Submit</button>
        </disv> -->

        <p class="title">REGISTER</p>
        <div class="input-container">

            <div class="input-group">
                <label for="i-email">Email</label>
                <div class="outer-input">
                    <label for="i-email" class="fa fas fa-envelope input-icon"></label>
                    <input autocomplete="off" class="input" type="email" name="email" required placeholder="Email"
                        id="i-email">
                </div>
            </div>

            <div class="input-group">
                <label for="i-username">Username</label>
                <div class="outer-input">
                    <label for="i-username" class="fa fas fa-user input-icon"></label>
                    <input autocomplete="off" class="input" type="text" name="username" required placeholder="Username"
                        id="i-username">
                </div>
            </div>

            <div class="input-group">
                <label for="i-id">Kode Karyawan</label>
                <div class="outer-input">
                    <label for="i-id" class="fa fas fa-newspaper input-icon"></label>
                    <input autocomplete="off" class="input" type="text" name="idkaryawan" required
                        placeholder="Kode Karyawan" id="i-id">
                </div>
            </div>

            <div class="input-group">
                <label for="i-password">Password</label>
                <div class="outer-input">
                    <label for="i-password" class="fa fas fa-lock input-icon"></label>
                    <input autocomplete="off" class="input" type="password" placeholder="Password" max="20" required
                        name="password" id="i-password">
                </div>
            </div>



            <?php
            if (isset($err)) {
                echo "<p id='form-err' class='error'>Gagal: {$err}</p>";
            }
            ?>
        </div>

        <div class="btn">
            <button type="submit">Submit</button>
            <p>Already have an account? <a href="login.php">Login Here</a></p>
        </div>
    </form>

</body>

</html>