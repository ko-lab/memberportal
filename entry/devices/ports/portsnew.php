<?php
include("../../../includes/php/top.php");
include("../../../includes/php/mysqli.php");

$customer    = $_GET["customer"];
$site        = $_GET["site"];
$device        = $_GET["device"];
$porttype = $_GET["porttype"];
$note = $_GET["note"];

// escape stings

$device        = mysqli_real_escape_string($dbhandle, $device);
$porttype        = mysqli_real_escape_string($dbhandle, $porttype);
$note        = mysqli_real_escape_string($dbhandle, $note);

if ($site == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/entry.php">';
    exit;
}
if ($device == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/entry.php">';
    exit;
}
if ($porttype == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/entry.php">';
    exit;
}

$strQuery = "SELECT idDevicesPorts FROM devicesports WHERE Device = $device AND Port = $porttype;";
$result = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
$response    = mysqli_fetch_array($result);

if ($response==NULL) {
	$strQuery2 = "INSERT INTO `devicesports` (`Device`, `Port`, `Note`) VALUES ('" . $device . "', '" . $porttype . "', '" . $note . "');";
	$result2 = $dbhandle->query($strQuery2) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
	echo '<p>Port created</p>';
} else {
	echo '<p>Port already exists</p>';
}

echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/devices/devicesedit.php?device=' . $device . '&customer=' . $customer . '&site=' . $site . '">';

include("../../../includes/php/bottom.php");
?>