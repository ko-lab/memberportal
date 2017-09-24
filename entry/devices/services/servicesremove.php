<?php
include("../../../includes/php/top.php");
include("../../../includes/php/mysqli.php");

$customer = $_GET["customer"];
$site     = $_GET["site"];
$device         = $_GET["device"];
$service   = $_GET["service"];

// escape stings

$customer = mysqli_real_escape_string($dbhandle, $customer);
$site   = mysqli_real_escape_string($dbhandle, $site);
$device        = mysqli_real_escape_string($dbhandle, $device);
$service     = mysqli_real_escape_string($dbhandle, $service);

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
if ($service == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/entry.php">';
    exit;
}

$strQuery = "DELETE FROM `devicesservices` WHERE `idDevicesServices`='" . $service . "';";
$result = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");

echo '</p>Service removed</p>';
echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/devices/devicesedit.php?device=' . $device . '&customer=' . $customer . '&site=' . $site . '">';

include("../../../includes/php/bottom.php");
?>