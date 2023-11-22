<?php

session_start();

$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASSWORD = '';
$DB_NAME = 'apotek';
$COOKIE_KEY = 'apotek-';
$SESSION_EXPIRES = 60 * 60 * 12; //12 Jam
$ROOT_PATH = "/smk/pweb";
$conn;

$LEVEL_USER = [
    0 => 'KARYAWAN',
    1 => 'ADMIN',
    2 => 'MASTER',
    'MASTER' => 2,
    'ADMIN' => 1,
    'KARYAWAN' => 0
];

try {
    global $conn;
    $conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);
} catch (Exception $err) {
    echo ($err);
    echo (mysqli_connect_error());
    exit;
}

function queryData(mysqli $conn, string $query): array
{
    $sql = mysqli_query($conn, $query);
    $data = [];
    if ($conn->error || mysqli_error($conn))
        throw new Exception($conn->error ?? mysqli_error($conn));

    if ($conn->errno == 2006) {
        throw new Exception("Sending too big packages.");
    }

    if (!isset($sql->num_rows) || $sql->num_rows < 1)
        return [];

    while ($row = $sql->fetch_assoc()) {
        array_push($data, $row);
    }

    return $data;
}

function isAuth(mysqli $conn): bool
{
    if (!isset($_SESSION["auth"]) && !isset($_COOKIE["auth"]))
        return false;

    $auth = $_SESSION["auth"] ?? $_COOKIE["auth"];
    $query = "SELECT username, token, idkaryawan FROM auth WHERE token = '$auth' AND expires > CURRENT_TIMESTAMP";
    $data = queryData($conn, $query);

    if (empty($data))
        return false;

    if (@$_SESSION["user"] && !is_array($_SESSION["user"])) {
        unset($_SESSION["user"]);
        return false;
    }

    if (!isset($_SESSION["user"]) || $_SESSION["user"]["idkaryawan"] != $data[0]["idkaryawan"]) {
        $query = "SELECT * FROM tb_login WHERE username = '{$data[0]["username"]}'";
        $data = queryData($conn, $query);

        $_SESSION["user"] = $data[0];

        if (!isset($_SESSION["auth"]))
            $_SESSION["auth"] = $_COOKIE["auth"];
    }

    return true;
}

function isAdmin($user): bool
{
    global $LEVEL_USER;
    return @$user['leveluser'] && ($user["leveluser"] == $LEVEL_USER["ADMIN"] || $user["leveluser"] == $LEVEL_USER["MASTER"]);
}
function isMaster($user): bool
{
    global $LEVEL_USER;
    return @$user['leveluser'] && $user["leveluser"] == $LEVEL_USER["MASTER"];
}

