<?php
require_once "../../utils/conn.php";

if (!isAuth($conn)) {
    exit(header("Location: ../_401.php"));
}

$BACK_URL = "../add.php";

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    exit(header("Location: $BACK_URL"));
}


$id_obat = isset($_POST["id_obat"]) ? (int) $_POST["id_obat"] : NULL;
$id_supplier = (int) $_POST["id_supplier"];
$nama_obat = $_POST["nama"];
$kategori = $_POST["kategori"];
$harga_jual = (int) $_POST["jual"];
$harga_beli = (int) $_POST["beli"];
$stock = (int) $_POST["stock"];
$keterangan = mysqli_escape_string($conn, $_POST["keterangan"]);


if (!isset($id_supplier) || !isset($nama_obat) || !isset($kategori) || !isset($harga_beli) || !isset($harga_jual) || !isset($stock) || !isset($keterangan)) {
    header("Location: {$BACK_URL}?err=Data tidak lengkap");
    exit;
}

if (is_nan($id_obat) || is_nan($id_supplier)) {
    header("Location: {$BACK_URL}?err=Data ID obat atau ID supplier tidak valid");
    exit;
}

if (is_nan($harga_beli) || is_nan($harga_jual)) {
    header("Location: {$BACK_URL}?err=Data harga jual atau harga beli tidak valid");
    exit;
}

// if (is_nan($harga_beli) || is_nan($harga_jual)) {
//     header("Location: {$BACK_URL}?err=Data harga jual atau harga beli tidak valid");
// }

if ($harga_beli < 0) {
    header("Location: {$BACK_URL}?err=Data harga beli harus lebih besar atau sama dengan 0");
    exit;
}

if ($harga_jual < 1000) {
    header("Location: {$BACK_URL}?err=Data harga beli harus lebih besar atau sama dengan 1000");
    exit;
}

if (is_nan($stock)) {
    header("Location: {$BACK_URL}?err=Data stock obat tidak valid");
    exit;
}

if ($stock < 0) {
    header("Location: {$BACK_URL}?err=Data stock obat harus lebih besar atau sama dengan 0");
    exit;
}

$query = "SELECT idobat FROM tbobat WHERE idobat = '$id_obat'";
$data = queryData($conn, $query);

if (!empty($data)) {
    header("Location: {$BACK_URL}?err=ID obat sudah terdaftar");
    exit;
}

$query = "SELECT idsupplier FROM tb_supplier WHERE idsupplier = '$id_supplier'";
$data = queryData($conn, $query);

if (empty($data)) {
    header("Location: {$BACK_URL}?err=ID supplier tidak terdaftar");
}


$query = "INSERT INTO tbobat VALUE ('$id_obat', '$id_supplier', '$nama_obat', '$kategori', '$harga_jual', '$harga_beli', '$stock', '$keterangan')";

try {
    queryData($conn, $query);
    header("Location: ../");
} catch (Exception $e) {
    header("Location: {$BACK_URL}?err=" . $e->getMessage());
}