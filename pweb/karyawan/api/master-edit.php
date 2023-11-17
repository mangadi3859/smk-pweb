<?php
require_once "../../utils/conn.php";

if (!isAuth($conn)) {
    exit(header("Location: ../../_401.php"));
}

// if (!isAdmin($_SESSION["user"])) {
//     exit(header("Location: ../../_403.php?msg=Access Denied"));
// }

if (!isMaster($_SESSION["user"])) {
    exit(header("Location: ../../_403.php?msg=Access Denied"));
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
$username = $_POST["username"] ?? NULL;
$email = $_POST["email"] ?? NULL;
$level = (int) $_POST["level"] ?? NULL;

if (!isset($id) || !@$nama || !isset($alamat) || !isset($telp) || !@$username || !@$email || is_nan($level)) {
    header("Location: {$BACK_URL}?id=$id&err=Data tidak lengkap");
    exit;
}

if (is_nan($id) || is_nan((int) $telp) || is_nan($level)) {
    header("Location: {$BACK_URL}?id=$id&err=Data tidak valid");
    exit;
}

if (!@$LEVEL_USER[$level]) {
    header("Location: {$BACK_URL}?id=$id&err=Level user tidak valid");
    exit;
}

$query = "SELECT idkaryawan FROM tb_karyawan WHERE idkaryawan = '$id'";
$data = queryData($conn, $query);

if (empty($data)) {
    header("Location: {$BACK_URL}?id=$id&err=ID Karyawan tidak terdaftar");
    exit;
}

$query = "UPDATE tb_karyawan SET nama = '$nama', alamat = '$alamat', telp = '$telp' WHERE idkaryawan = '$id'";
$query_auth = "UPDATE tb_login SET username = '$username', email = '$email', leveluser = '$level' WHERE username = '$username'";

try {
    queryData($conn, $query);
    queryData($conn, $query_auth);
    header("Location: ../");
} catch (Exception $e) {
    header("Location: {$BACK_URL}?err=" . $e->getMessage());
}