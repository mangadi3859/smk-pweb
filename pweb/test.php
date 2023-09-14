<?php
require_once "utils/conn.php";

echo time() . " + " . $SESSION_EXPIRES . " = " . time() + $SESSION_EXPIRES;

echo "<br/>";

echo json_encode($_SESSION);

?>