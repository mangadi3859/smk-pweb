<?php
require_once "utils/conn.php";

if (!isAuth($conn)) {
    header("Location: index.php");
    exit();
}

$query = "DELETE FROM auth WHERE token = '{$_SESSION['auth']}'";
queryData($conn, $query);
session_destroy();

header("Location: login.php");