<?php
require_once "../../utils/conn.php";

// $redirect = isset($_GET["redirect"]) ? $_GET["redirect"] : NULL;
$BACK_URL = "../";

// if ($_SERVER["REQUEST_METHOD"] != "GET") {
//     header("Location: " . $BACK_URL);
// }

$id = (int) $_GET['id'];

if (!isset($id) || is_nan($id)) {
    header("Location: " . $BACK_URL);
}

$query = "SELECT idkaryawan FROM tb_login WHERE idkaryawan = $id";
if (!empty(queryData($conn, $query))) {
    header("Location: " . $BACK_URL);
}

try {
    $query = "DELETE FROM tb_karyawan WHERE idkaryawan = '$id'";
    queryData($conn, $query);
} catch (Exception $e) {
    die($e->getMessage());
}
header("Location: " . $BACK_URL);