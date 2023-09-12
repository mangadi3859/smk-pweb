<?php
require_once "../utils/conn.php";

// $redirect = isset($_GET["redirect"]) ? $_GET["redirect"] : NULL;
$BACK_URL = "../";

// if ($_SERVER["REQUEST_METHOD"] != "GET") {
//     header("Location: " . $BACK_URL);
// }

$id = (int) $_GET['id'];

if (!isset($id) || is_nan($id)) {
    header("Location: " . $BACK_URL);
}

try {
    $query = "DELETE FROM tbobat WHERE idobat = '$id'";
    queryData($conn, $query);
} catch (Exception $e) {
    die($e->getMessage());
}
header("Location: " . $BACK_URL);