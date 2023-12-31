<?php
require_once "../utils/conn.php";
require_once "../utils/functions.php";

$redirect = isset($_GET["redirect"]) ? $_GET["redirect"] : NULL;
$BACK_URL = "../login.php";

if (isAuth($conn)) {
    header("Location: " . (isset($redirect) ? $redirect : "../index.php"));
    exit;
}

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    // header("Location: " . $BACK_URL);
    http_response_code(403);
    exit;
}

$username = $_POST["username"];
$password = $_POST["password"];

if (!isset($username) || !isset($password))
    exit(header("Location: {$BACK_URL}?err=Data tidak lengkap"));

$username = strtolower(trim($_POST["username"]));

$query = "SELECT `password`, idkaryawan, username FROM tb_login WHERE username = '$username' OR email = '$username'";
$data = queryData($conn, $query);

if (empty($data))
    exit(header("Location: {$BACK_URL}?err=Username salah"));


if (!password_verify($password, $data[0]["password"]))
    exit(header("Location: {$BACK_URL}?err=Password salah"));

$token = generateToken((int) $data[0]["idkaryawan"], 32);
// $query = "SELECT * FROM auth WHERE idkaryawan = '{$data[0]['idkaryawan']}'";

$query = "DELETE FROM auth WHERE idkaryawan = {$data[0]['idkaryawan']}";
queryData($conn, $query);

try {
    $query = "INSERT INTO auth VALUE ('$token', '{$data[0]['idkaryawan']}', '{$data[0]['username']}', CURRENT_TIMESTAMP + INTERVAL $SESSION_EXPIRES SECOND)";
    queryData($conn, $query);

    $query = "SELECT username, email, idkaryawan, leveluser FROM tb_login WHERE username = '$username'";
    $data = queryData($conn, $query);

    $_SESSION["auth"] = $token;
    $_SESSION["user"] = $data[0];

    setcookie("auth", $token, time() + $SESSION_EXPIRES, "/");

    global $redirect;
    return header("Location: " . (!empty($redirect) ? $redirect : "../index.php"));
} catch (Exception $e) {
    header("Location: {$BACK_URL}?err=Server Error: {$e->getMessage()}");
}

// echo json_encode($data);