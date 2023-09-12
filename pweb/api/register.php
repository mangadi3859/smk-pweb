<?php
require_once "../utils/conn.php";

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    echo "Unauthorized method.";
    exit();
}

if (isAuth($conn)) {
    header("Location: " . (isset($redirect) ? $redirect : "../"));
}

$email = $_POST["email"];
$username = $_POST["username"];
$idkaryawan = $_POST["idkaryawan"];
$password = $_POST["password"];

if (!isset($username) || !isset($email) || !isset($idkaryawan) || !isset($password))
    return header("Location: ../register.php");

$username = trim(strtolower($username));
$hashed = password_hash($password, PASSWORD_BCRYPT);
$query = "SELECT * FROM tb_karyawan WHERE idkaryawan = '$idkaryawan'";
$karyawan = queryData($conn, $query);

if (sizeof($karyawan) < 1) {
    echo "ID Not Found";
    exit();
}

$query = "SELECT * FROM tb_login WHERE username = '$username' OR idkaryawan = '$idkaryawan'";
$userdata = queryData($conn, $query);

if (sizeof($userdata) > 0) {
    echo "This user already registered.";
    exit();
}

$query = "INSERT INTO `tb_login` VALUE ('$username', '$email', '$hashed', $idkaryawan, 0)";

try {
    $redirect = isset($_GET["redirect"]) ? $_GET["redirect"] : NULL;

    $logindata = queryData($conn, $query);
    return header("Location: " . (empty($redirect) ? "../login.php" : $redirect));
} catch (Exception $e) {
    echo "Server Error: " . $e->getMessage();
    exit();
}



?>