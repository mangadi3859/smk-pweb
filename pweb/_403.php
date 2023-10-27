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
    <main style="display: grid; place-items: center; height: 80vh;">
        <div class="main-container" style="display: grid; place-items: center;">
            <div style="display: flex; flex-direction: column; min-width: 50%;">
                <h1 style="color: var(--primary-500); font-size: 3.5rem; margin-block: 0;">Error 403</h1>
                <span style="font-size: 1rem; margin-block: 0;">Forbidden Request</span>
            </div>
        </div>
    </main>
    <?php include "components/footer.php" ?>
</body>

</html>