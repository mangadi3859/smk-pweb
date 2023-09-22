<?php
require_once "../../utils/conn.php";


$BACK_URL = "../edit.php";

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: $BACK_URL");
    exit;
}

$id = (int) ($_POST["id"] ?? NULL);
$alamat = $_POST["alamat"] ?? NULL;
$telp = $_POST["telp"] ?? NULL;


if (!isset($id) || !isset($alamat) || !isset($telp)) {
    header("Location: {$BACK_URL}?err=Data tidak lengkap");
    exit;
}

if (is_nan($id) || is_nan((int) $telp)) {
    header("Location: {$BACK_URL}?err=Data tidak valid");
    exit;
}

$query = "SELECT idkaryawan FROM tb_karyawan WHERE idkaryawan = '$id'";
$data = queryData($conn, $query);

if (empty($data)) {
    header("Location: {$BACK_URL}?id=$id_obat&err=ID Karyawan tidak terdaftar");
    exit;
}

$query = "UPDATE tb_karyawan SET alamat = '$alamat', telp = '$telp' WHERE idkaryawan = '$id'";

try {
    queryData($conn, $query);
    header("Location: ../");
} catch (Exception $e) {
    header("Location: {$BACK_URL}?err=" . $e->getMessage());
}