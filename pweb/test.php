<?php
require_once "utils/conn.php";
require_once "utils/functions.php";

echo time() . " + " . $SESSION_EXPIRES . " = " . time() + $SESSION_EXPIRES;

echo "<br/>";
echo "Test query :" . (is_nan((int) NULL) ? "NaN" : "No") . "<br/>";
echo dirname(dirname(__FILE__));
echo "<br/>";
echo json_encode(parse_url($_SERVER["REQUEST_URI"]));
echo "<br/>";
echo json_encode($_SESSION);
echo htmlspecialchars("<br/>");

echo generateBreadcrumb($_SERVER["REQUEST_URI"]);
// session_destroy();

$file = __FILE__;
$file_dir = dirname(__FILE__);
$file_dirdir = dirname(dirname(__FILE__));
// echo __FILE__;
echo <<<ayy
        $file
        <br />
        $file_dir
        <br />
        $file_dirdir
    ayy;


echo @2;
echo is_nan(0) ? "true" : "false";
?>
