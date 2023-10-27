<?php
require_once "utils/conn.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/home1.css">
</head>

<body>
    <?php include "components/navbar.php" ?>
    <main>
        <div id="hero">
            <div   div class="main-container">
                <div class="hero-text">
                    <div class="hero-text-head">
                        <div class="paint"></div>
                        Kesehatan adalah kunci hidup sukses
                    </div>
                    <div class="hero-text-body">Mulai tingkatkan kualitas hidup dengan menjaga kesehatan.</div>
                    <a href="#about" class="btn btn-primary">Lihat Sekarang</a>
                </div>
                <div class="hero-svg">
                    <svg width="548" height="503" viewBox="0 0 548 503" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M178.584 459.585C168.154 448.427 169.092 431.315 180.679 421.364L470.262 172.667C481.85 162.716 499.698 163.695 510.128 174.852V174.852C520.558 186.01 519.62 203.122 508.033 213.074L218.45 461.77C206.863 471.721 189.014 470.743 178.584 459.585V459.585Z"
                            fill="#3A405A" />
                        <path
                            d="M179.158 250.893C172.246 243.499 172.867 232.159 180.546 225.564L429.29 11.9407C436.969 5.34611 448.797 5.9944 455.709 13.3888V13.3888C462.621 20.7831 462 32.1234 454.321 38.7181L205.577 252.341C197.898 258.936 186.07 258.288 179.158 250.893V250.893Z"
                            fill="#3A405A" />
                        <path
                            d="M25.84 475.309C11.569 460.042 12.8523 436.628 28.7064 423.013L466.9 46.6876C482.755 33.072 507.176 34.4105 521.447 49.6773V49.6773C535.718 64.944 534.435 88.3578 518.581 101.973L80.3864 478.298C64.5323 491.914 40.1111 490.575 25.84 475.309V475.309Z"
                            fill="#3A405A" />
                    </svg>

                    <video muted autoplay src="assets/hero-bar.png" class="img-bar"></video>

                </div>
            </div>
        </div>
    </main>
    <?php include "components/footer.php" ?>
</body>

</html>