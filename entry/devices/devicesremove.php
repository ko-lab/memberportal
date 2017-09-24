<?php
include("../../includes/php/top.php");
include("../../includes/php/mysqli.php");

$device = $_GET["device"];
$customer     = $_GET["customer"];
$site         = $_GET["site"];

// escape stings

$device = mysqli_real_escape_string($dbhandle, $device);

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

echo '<h3>REMOVING DEVICE</h3>';
echo '<p>';

// Remove ip addreses

$strQuery = "DELETE FROM `customerdevicesipadresses` WHERE `Device`='" . $device . "';";
$result = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
echo 'ip addreses removed<br>';

// Remove services

$strQuery = "DELETE FROM `devicesservices` WHERE `Device`='" . $device . "';";
$result = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
echo 'Services removed<br>';

// Remove Ports

$strQuery = "SELECT idDevicesPorts FROM devicesports WHERE Device = $device;";
$result = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
while ($row = mysqli_fetch_array($result)) {
    $strQuery2 = "SELECT idPortConnections FROM portconnections WHERE DevicesPort = " . $row['idDevicesPorts'] . " OR DevicesPort1 = " . $row['idDevicesPorts'] . ";";
    $result2 = $dbhandle->query($strQuery2) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
	while ($row = mysqli_fetch_array($result2)) {
		$strQuery3 = "DELETE FROM `portconnectionsvlans` WHERE `PortConnection`='" . $row['idPortConnections'] . "';";
		$result3 = $dbhandle->query($strQuery3) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
	}
	echo 'Port connections vlans removed<br>';
	$strQuery4 = "DELETE FROM `portconnections` WHERE `DevicesPort`='" . $row['idDevicesPorts'] . "' OR `DevicesPort1`='" . $row['idDevicesPorts'] . "';";
	$result4 = $dbhandle->query($strQuery4) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
	echo 'Port connections removed<br>';
}
$strQuery = "DELETE FROM `devicesports` WHERE `Device`='" . $device . "';";
$result = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
echo 'Ports removed<br>';

// Remove Device

$strQuery = "DELETE FROM `devices` WHERE `idDevices`='" . $device . "';";
$result = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
echo 'Device removed';

echo '</p>';
echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/entry.php?customer=' . $customer . '&site=' . $site . '">';

include("../../includes/php/bottom.php");
?>