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
$image = $_FILES["file"] ?? NULL;


if (!isset($nama) || !isset($usia) || !isset($image) || !isset($image["tmp_name"]) || !isset($alamat) || !isset($telp)) {
    header("Location: {$BACK_URL}?err=Data tidak lengkap");
}

if (is_nan((int) $telp) || is_nan($usia)) {
    header("Location: {$BACK_URL}?err=Data tidak valid");
}

$buffer_img = file_get_contents($image["tmp_name"]);
$base64_img = "data:{$image["type"]};base64," . base64_encode($buffer_img);
$query = "INSERT INTO tb_pelanggan VALUE (NULL, '$nama', '$alamat', '$telp', $usia, '$base64_img')";

try {
    queryData($conn, $query);
    header("Location: ../");
} catch (Exception $e) {
    header("Location: {$BACK_URL}?err=" . $e->getMessage());
}