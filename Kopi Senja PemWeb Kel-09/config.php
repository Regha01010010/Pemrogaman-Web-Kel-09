<?php
$serverName = "DESKTOP-04TP3QQ\UMARFARUQ";
$connectionOptions = array(
    "Database" => "Kopi_Senja",
    "Uid" => "Kopi Senja",
    "PWD" => "pemweb09"
);

$conn = sqlsrv_connect($serverName, $connectionOptions);
if (!$conn) {
    die("Connection failed: " . print_r(sqlsrv_errors(), true));
}
?>