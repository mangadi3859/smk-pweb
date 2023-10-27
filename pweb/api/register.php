<?php
require_once "../utils/conn.php";

$BACK_URL = "../register.php";

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    echo "Unauthorized method.";
    exit;
}

$ignoreAuth = $_GET["ignoreAuth"] ?? NULL;
if (isAuth($conn) && !isAdmin($_SESSION["user"]) && !@$ignoreAuth) {
    header("Location: ../");
}

$email = $_POST["email"];
$username = $_POST["username"];
$idkaryawan = $_POST["idkaryawan"];
$password = $_POST["password"];
$level = ((int) $_POST["leveluser"]) ?? 0;

if (!isset($username) || !isset($email) || !isset($idkaryawan) || !isset($password))
    exit(header("Location: $BACK_URL?err=Data tidak lengkap"));

if (is_nan($level) || !@$LEVEL_USER[$level])
    exit(header("Location: $BACK_URL?err=Data salah"));

$username = trim(strtolower($username));
$hashed = password_hash($password, PASSWORD_BCRYPT);
$query = "SELECT idkaryawan FROM tb_karyawan WHERE idkaryawan = '$idkaryawan'";
$karyawan = queryData($conn, $query);

if (empty($karyawan)) {
    exit(header("Location: $BACK_URL?err=Kode karyawan tidak terdaftar"));
}

$query = "SELECT username FROM tb_login WHERE username = '$username' OR idkaryawan = '$idkaryawan'";
$userdata = queryData($conn, $query);

if (!empty($userdata)) {
    header("Location: $BACK_URL?err=User ini sudah terdaftar");
    exit;
}

$query = "INSERT INTO `tb_login` VALUE ('$username', '$email', '$hashed', $idkaryawan, $level)";

try {
    $redirect = isset($_GET["redirect"]) ? $_GET["redirect"] : NULL;

    $logindata = queryData($conn, $query);
    header("Location: " . (empty($redirect) ? "../login.php" : $redirect));
    exit;
} catch (Exception $e) {
    echo "Server Error: " . $e->getMessage();
    exit;
}



?>