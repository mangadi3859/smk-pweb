<?php
require_once "../../utils/conn.php";


$BACK_URL = "../add.php";

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: $BACK_URL");
}

// $id_karyawan = (int) ($_POST["id_karyawan"] ?? NULL);
$alamat = $_POST["alamat"] ?? NULL;
$telp = $_POST["telp"] ?? NULL;


if (!isset($alamat) || !isset($telp)) {
    header("Location: {$BACK_URL}?err=Data tidak lengkap");
}

if (is_nan((int) $telp)) {
    header("Location: {$BACK_URL}?err=Data tidak valid");
}

$query = "INSERT INTO tb_karyawan VALUE (NULL, '$alamat', '$telp')";

try {
    queryData($conn, $query);
    header("Location: ../");
} catch (Exception $e) {
    header("Location: {$BACK_URL}?err=" . $e->getMessage());
}