<?php
include("../../../../includes/php/top.php");
include("../../../../includes/php/mysqli.php");

$customer    = $_GET["customer"];
$site        = $_GET["site"];
$device        = $_GET["device"];
$port = $_GET["port"];
$connection = $_GET["connection"];

// escape stings

$connection        = mysqli_real_escape_string($dbhandle, $connection);

if ($site == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/entry.php">';
    exit;
}
if ($device == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/entry.php">';
    exit;
}
if ($connection == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/entry.php">';
    exit;
}

$strQuery = "DELETE FROM `portconnections` WHERE `idPortConnections`='" . $connection . "';";
$result = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");

echo '<p>Connection removed</p>';

echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/devices/ports/portsedit.php?port=' . $port . '&customer=' . $customer . '&site=' . $site . '&device=' . $device . '">';

include("../../../../includes/php/bottom.php");
?>