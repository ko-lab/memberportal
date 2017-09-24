<?php
include("../../../../../includes/php/top.php");
include("../../../../../includes/php/mysqli.php");

$customer    = $_GET["customer"];
$site        = $_GET["site"];
$device        = $_GET["device"];
$port = $_GET["port"];
$connection = $_GET["connection"];
$vlan = $_GET["vlan"];

// escape stings

$device        = mysqli_real_escape_string($dbhandle, $device);
$connection        = mysqli_real_escape_string($dbhandle, $connection);
$vlan        = mysqli_real_escape_string($dbhandle, $vlan);

if ($site == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/entry.php">';
    exit;
}
if ($connection == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/entry.php">';
    exit;
}
if ($vlan == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/entry.php">';
    exit;
}

$strQuery = "SELECT idPortConnectionsVlans FROM portconnectionsvlans WHERE CustomerSitesVlan = $vlan AND PortConnection = $connection;";
$result = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
$response    = mysqli_fetch_array($result);

if ($response==NULL) {
	$strQuery2 = "INSERT INTO `portconnectionsvlans` (`CustomerSitesVlan`, `PortConnection`) VALUES ('" . $vlan . "', '" . $connection . "');";
	$result2 = $dbhandle->query($strQuery2) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
	echo '<p>Vlan added/p>';
} else {
	echo '<p>Vlan is already conected</p>';
}

echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/devices/ports/portsedit.php?port=' . $port . '&customer=' . $customer . '&site=' . $site . '&device=' . $device . '">';

include("../../../../../includes/php/bottom.php");
?>