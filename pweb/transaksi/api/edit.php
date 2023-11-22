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
$idkaryawan = (int) ($_POST["idkaryawan"] ?? NULL);
$idpelanggan = (int) ($_POST["idpelanggan"] ?? NULL);
$kategori = $_POST["kategori"] ?? NULL;
$tanggal = $_POST["tanggal"] ?? NULL;
$totalbayar = (int) $_POST["totalbayar"] ?? NULL;


if (!@$id || !@$tanggal || !@$totalbayar || !@$kategori || !@$idkaryawan || !@$idpelanggan) {
    header("Location: $BACK_URL?id=$id&err=Data tidak lengkap");
    exit;
}

if (is_nan($id) || is_nan($idpelanggan) || is_nan($idkaryawan) || is_nan($totalbayar)) {
    header("Location: $BACK_URL?id=$id&err=Data tidak valid");
    exit;
}

$sql = "SELECT * FROM tb_transaksi WHERE idtransaksi = '$id'";
$transaksi = queryData($conn, $sql);

if (empty($transaksi)) {
    header("Location: $BACK_URL?id=$id&err=ID Transaksi tidak ditemukan");
    exit;
}

$sql = "SELECT idkaryawan FROM tb_karyawan WHERE idkaryawan = '$idkaryawan'";
$karyawan = queryData($conn, $sql);

if (empty($karyawan)) {
    header("Location: $BACK_URL?id=$id&err=ID Karyawan tidak ditemukan");
    exit;
}

$sql = "SELECT idpelanggan FROM tb_pelanggan WHERE idpelanggan = '$idpelanggan'";
$pelanggan = queryData($conn, $sql);

if (empty($transaksi)) {
    header("Location: $BACK_URL?id=$id&err=ID Pelanggan tidak ditemukan");
    exit;
}

if ($totalbayar < $transaksi["totalbayar"]) {
    header("Location: $BACK_URL?id=$id&err=Bayaran harus lebih besar atau sama dengan total harga");
    exit;
}

$query = "UPDATE tb_transaksi SET 
idpelanggan = $idpelanggan,
idkaryawan = $idkaryawan,
tgltransaksi = '$tanggal',
kategoripelanggan = '$kategori',
bayar = '$totalbayar',
kembali = $totalbayar - totalbayar
WHERE idtransaksi = '$id'";
try {
    queryData($conn, $query);
    header("Location: ../");
} catch (Exception $e) {
    header("Location: {$BACK_URL}?err=" . $e->getMessage());
}