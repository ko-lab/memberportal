<?php
include("../../../includes/php/top.php");
include("../../../includes/php/mysqli.php");

$customer   = $_GET["customer"];
$site   = $_GET["site"];
$port   = $_GET["port"];
$porttype   = $_GET["porttype"];
$note   = $_GET["note"];
$device   = $_GET["device"];

// escape stings

$customer   = mysqli_real_escape_string($dbhandle, $customer);
$site   = mysqli_real_escape_string($dbhandle, $site);
$port   = mysqli_real_escape_string($dbhandle, $port);
$porttype   = mysqli_real_escape_string($dbhandle, $porttype);
$note   = mysqli_real_escape_string($dbhandle, $note);

if ($site == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/entry.php">';
    exit;
}
if ($port == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/entry.php">';
    exit;
}

$strQuery2 = "UPDATE `devicesports` SET `Port`='" . $porttype . "', `Note`='" . $note . "' WHERE `idDevicesPorts`='" . $port . "';";
$result2 = $dbhandle->query($strQuery2) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");

echo '<p>Vlan changed</p>';
echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/devices/devicesedit.php?device=' . $device . '&customer=' . $customer . '&site=' . $site . '">';

include("../../../includes/php/bottom.php");
?>