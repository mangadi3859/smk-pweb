<?php
require_once "../../utils/conn.php";

if (!isAuth($conn)) {
    exit(header("Location: ../../_401.php"));
}

$BACK_URL = "../edit.php";

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: $BACK_URL");
    exit;
}

$id = (int) ($_POST["id"] ?? NULL);
$nama = $_POST["nama"] ?? NULL;
$alamat = $_POST["alamat"] ?? NULL;
$telp = $_POST["telp"] ?? NULL;
$usia = (int) ($_POST["usia"] ?? NULL);
$image = $_POST["file"] ?? NULL;

if (!isset($id) || !isset($nama) || !isset($usia) || !isset($alamat) || !isset($telp)) {
    header("Location: {$BACK_URL}?err=Data tidak lengkap");
    exit;
}

if (is_nan($id) || is_nan((int) $telp) || is_nan($usia)) {
    header("Location: {$BACK_URL}?id=$id&err=Data tidak valid");
    exit;
}

$image_size = strlen(explode(",", $image)[1]) / 1024 / 1024;
if ($image_size > 2) {
    header("Location: {$BACK_URL}?id=$id&err=Gambar terlalu besar");
    exit;
}

$query = "SELECT idpelanggan FROM tb_pelanggan WHERE idpelanggan = '$id'";
$data = queryData($conn, $query);

if (empty($data)) {
    header("Location: {$BACK_URL}?id=$id&err=ID Pelanggan tidak terdaftar");
    exit;
}

$base64 = isset($image) && str_contains($image, ";base64,") ? ", buktifotoresep = '$image'" : "";
$query = "UPDATE tb_pelanggan SET namalengkap = '$nama', alamat = '$alamat', telp = '$telp', usia = $usia $base64 WHERE idpelanggan = '$id'";

try {
    queryData($conn, $query);
    header("Location: ../");
} catch (Exception $e) {
    header("Location: {$BACK_URL}?err=" . $e->getMessage());
}