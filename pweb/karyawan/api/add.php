<?php
require_once "../../utils/conn.php";

if (!isAuth($conn)) {
    exit(header("Location: ../../_401.php"));
}

if (!isAdmin($_SESSION["user"])) {
    exit(header("Location: ../../_403.php?msg=Access Denied"));
}

$BACK_URL = "../add.php";

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: ../add.php");
    exit;
}

$nama = $_POST["nama"] ?? NULL;
$alamat = $_POST["alamat"] ?? NULL;
$telp = $_POST["telp"] ?? NULL;


if (!@$nama || !isset($alamat) || !isset($telp)) {
    header("Location: {$BACK_URL}?err=Data tidak lengkap");
    exit;
}

if (is_nan((int) $telp)) {
    header("Location: {$BACK_URL}?err=Data tidak valid");
    exit;
}

$query = "INSERT INTO tb_karyawan VALUE (NULL, '$nama', '$alamat', '$telp')";

try {
    queryData($conn, $query);
    header("Location: ../");
} catch (Exception $e) {
    header("Location: {$BACK_URL}?err=" . $e->getMessage());
}