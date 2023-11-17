<?php
require_once dirname(dirname(__FILE__)) . "/utils/conn.php";

$isLoggedIn = isAuth($conn);
?>

<link rel="stylesheet" href="<?= $ROOT_PATH ?>/css/navbar.css">
<link rel="stylesheet" href="<?= $ROOT_PATH ?>/css/fontawesome/css/all.min.css">

<header class="nav">
    <div class="main-container nav-container">
        <div class="brand"><span>Apotek</span><span>Sehat</span></div>
        <div class="nav-items">
            <a href="<?= $ROOT_PATH ?>">Home</a>
            <a href="<?= $ROOT_PATH ?>/karyawan">Karyawan</a>
            <a href="<?= $ROOT_PATH ?>/pelanggan">Pelanggan</a>
            <a href="<?= $ROOT_PATH ?>/obat">Produk</a>
            <a href="<?= $ROOT_PATH ?>/kontak.php">Kontak</a>
        </div>
        
        <?php

        if (!$isLoggedIn)
            echo "<div class='login'><a href='$ROOT_PATH/login.php?redirect={$_SERVER["REQUEST_URI"]}' class='btn btn-primary'>Sign In</a></div>";
        else {
            $user_nav = $_SESSION["user"]["username"];
            $isAdmin = isAdmin($_SESSION["user"]);
            $crown = $isAdmin ? "<i title='Admin User' class='fa-solid fa-crown nav-user-admin'></i>" : "";
            echo "<div class='logout'><p title='$user_nav' class='nav-user'>$crown$user_nav</p><a href='$ROOT_PATH/logout.php?redirect={$_SERVER["REQUEST_URI"]}' class='btn btn-primary'>Log Out</a></div>";
        }
        ?>
        

    </div>
</header>
