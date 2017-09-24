<?php
include("../../../includes/php/top.php");
include("../../../includes/php/mysqli.php");

$customer    = $_GET["customer"];
$site        = $_GET["site"];
$device        = $_GET["device"];
$vlan = $_GET["vlan"];
$adress = $_GET["adress"];
$note = $_GET["note"];

// escape stings

$device        = mysqli_real_escape_string($dbhandle, $device);
$vlan        = mysqli_real_escape_string($dbhandle, $vlan);
$adress        = mysqli_real_escape_string($dbhandle, $adress);
$note        = mysqli_real_escape_string($dbhandle, $note);

if ($site == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/entry.php">';
    exit;
}
if ($device == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/entry.php">';
    exit;
}
if ($vlan == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/entry.php">';
    exit;
}

$strQuery2 = "INSERT INTO `customerdevicesipadresses` (`Adress`, `Note`, `Device`, `CustomerSitesVlan`) VALUES ('" . $adress . "', '" . $note . "', '" . $device . "', '" . $vlan . "');";
$result2 = $dbhandle->query($strQuery2) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
echo '<p>IP adress added</p>';

echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/devices/devicesedit.php?device=' . $device . '&customer=' . $customer . '&site=' . $site . '">';

include("../../../includes/php/bottom.php");
?>