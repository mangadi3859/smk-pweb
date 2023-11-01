<?php
require_once "../../utils/conn.php";

if (!isAuth($conn)) {
    exit(header("Location: ../../login.php"));
}

// $redirect = isset($_GET["redirect"]) ? $_GET["redirect"] : NULL;
$BACK_URL = "../";

// if ($_SERVER["REQUEST_METHOD"] != "GET") {
//     header("Location: " . $BACK_URL);
// }

$id = (int) $_GET['id'];

if (!isset($id) || is_nan($id)) {
    header("Location: " . $BACK_URL);
    exit;
}

$query = "SELECT idpelanggan FROM tb_transaksi WHERE idpelanggan = $id";
if (!empty(queryData($conn, $query))) {
    header("Location: " . $BACK_URL);
    exit;
}

try {
    $query = "DELETE FROM tb_pelanggan WHERE idpelanggan = '$id'";
    queryData($conn, $query);
} catch (Exception $e) {
    die($e->getMessage());
}
header("Location: " . $BACK_URL);