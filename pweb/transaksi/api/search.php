<?php
require_once "../../utils/conn.php";

if (!isAuth($conn)) {
    exit(json_encode([
        "error" => "Unauthenticated",
        "code" => 401
    ]));
}

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    exit(json_encode([
        "error" => "Method Not Allowed",
        "code" => 405
    ]));
}

$name = $_POST["name"] ?? NULL;
$id = $_POST["id"] ?? NULL;


if (!@$name && !@$id) {
    exit(json_encode([
        "error" => "Bad Request",
        "code" => 400
    ]));
}


$sql = @$id ? "SELECT * FROM tbobat WHERE idobat = '$id'" : "SELECT * FROM tbobat WHERE namaobat LIKE '%$name%'";
$data = queryData($conn, $sql);

echo json_encode($data);