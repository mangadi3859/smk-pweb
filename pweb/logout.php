<?php
require_once "utils/conn.php";

session_destroy();
header("Location: login.php");