<?php
require_once "../../utils/conn.php";

header("Content-Type: application/json");

if (!isAuth($conn)) {
    http_response_code(401);
    exit(json_encode([
        "error" => "Unauthenticated",
        "code" => 401
    ]));
}

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    http_response_code(405);
    exit(json_encode([
        "error" => "Method Not Allowed",
        "code" => 405
    ]));
}

$payload = json_decode(file_get_contents("php://input"), true);
$kategori = $payload['kategori'] ?? NULL;
$idpelanggan = $payload['idpelanggan'] ?? NULL;
$idkaryawan = $payload['idkaryawan'] ?? NULL;
$items = $payload['items'] ?? NULL;
$paid = $payload['paid'] ?? NULL;
$kategori_list = [
    "umum",
    "langganan"
];

if (!@$kategori || !in_array($kategori, $kategori_list) || !@$idpelanggan || !@$idkaryawan || !$items || !$paid || is_nan($paid) || sizeof($items) < 1) {
    http_response_code(400);
    exit(json_encode([
        "error" => "Bad Request",
        "code" => 400
    ]));
}

$sql = "SELECT idpelanggan, namalengkap FROM tb_pelanggan WHERE idpelanggan = '$idpelanggan'";
$pelanggan = queryData($conn, $sql);

$sql = "SELECT idkaryawan, nama FROM tb_karyawan WHERE idkaryawan = '$idkaryawan'";
$karyawan = queryData($conn, $sql);

if (sizeof($pelanggan) < 1 || sizeof($karyawan) < 1) {
    http_response_code(404);
    exit(json_encode([
        "error" => "Not Found",
        "code" => 404
    ]));
}

$totalbayar = array_reduce($items, function ($pre, $now) {
    return $pre + (int) $now["hargajual"] * $now["jumlah"];
}, 0);
$changes = $paid - $totalbayar;

$sql = "INSERT INTO tb_transaksi VALUE (
    NULL,
    $idpelanggan,
    $idkaryawan,
    CURRENT_DATE,
    '$kategori',
    $totalbayar,
    $paid,
    $changes
)";
queryData($conn, $sql);

$idtransaksi = $conn->insert_id;
foreach ($items as $obat) {
    $total = $obat["jumlah"] * (int) $obat["hargajual"];
    $sql = "INSERT INTO tb_detail_transaksi VALUE (
        NULL,
        $idtransaksi,
        {$obat["idobat"]},
        {$obat["jumlah"]},
        {$obat["hargajual"]},
        $total
    )";

    $sql_update = "UPDATE tbobat SET stok_obat = stok_obat - {$obat["jumlah"]} WHERE idobat = {$obat["idobat"]}";
    queryData($conn, $sql);
    queryData($conn, $sql_update);
}

// $id_karyawan = (int) ($_POST["id_karyawan"] ?? NULL);
