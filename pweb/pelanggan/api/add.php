<?php
require_once "../../utils/conn.php";


$BACK_URL = "../add.php";

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: $BACK_URL");
}

// $id_karyawan = (int) ($_POST["id_karyawan"] ?? NULL);
$nama = $_POST["nama"] ?? NULL;
$alamat = $_POST["alamat"] ?? NULL;
$telp = $_POST["telp"] ?? NULL;
$usia = (int) ($_POST["usia"] ?? NULL);
$image = $_POST["file"] ?? NULL;


if (!isset($nama) || !isset($usia) || !isset($image) || !isset($alamat) || !isset($telp)) {
    header("Location: {$BACK_URL}?err=Data tidak lengkap");
}

if (is_nan((int) $telp) || is_nan($usia)) {
    header("Location: {$BACK_URL}?err=Data tidak valid");
}

$query = "INSERT INTO tb_pelanggan VALUE (NULL, '$nama', '$alamat', '$telp', $usia, '$image')";

try {
    queryData($conn, $query);
    header("Location: ../");
} catch (Exception $e) {
    header("Location: {$BACK_URL}?err=" . $e->getMessage());
}