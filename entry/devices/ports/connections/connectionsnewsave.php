<?php
include("../../../../includes/php/top.php");
include("../../../../includes/php/mysqli.php");

$customer = $_GET["customer"];
$site     = $_GET["site"];
$device         = $_GET["device"];
$conport   = $_GET["conport"];
$port        = $_GET["port"];

// escape stings

$customer = mysqli_real_escape_string($dbhandle, $customer);
$site   = mysqli_real_escape_string($dbhandle, $site);
$device        = mysqli_real_escape_string($dbhandle, $device);
$conport     = mysqli_real_escape_string($dbhandle, $conport);
$port = mysqli_real_escape_string($dbhandle, $port);

if ($customer == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/entry.php">';
    exit;
}
if ($site == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/entry.php">';
    exit;
}
if ($device == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/entry.php">';
    exit;
}
if ($conport == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/entry.php">';
    exit;
}
if ($port == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/entry.php">';
    exit;
}

// add device

$strQuery = "INSERT INTO `portconnections` (`DevicesPort`, `DevicesPort1`) VALUES ('" . $port . "', '" . $conport . "');";
$result = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");

echo '<p>Connection added</p>';
echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/devices/ports/portsedit.php?port=' . $port . '&customer=' . $customer . '&site=' . $site . '&device=' . $device . '">';

include("../../../../includes/php/bottom.php");
?>