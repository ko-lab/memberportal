<?php
include("../../../../../includes/php/top.php");
include("../../../../../includes/php/mysqli.php");

$customer    = $_GET["customer"];
$site        = $_GET["site"];
$device        = $_GET["device"];
$port = $_GET["port"];
$vlan = $_GET["vlan"];

// escape stings

$device        = mysqli_real_escape_string($dbhandle, $device);
$vlan        = mysqli_real_escape_string($dbhandle, $vlan);

if ($site == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/entry.php">';
    exit;
}
if ($vlan == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/entry.php">';
    exit;
}

$strQuery2 = "DELETE FROM `portconnectionsvlans` WHERE `idPortConnectionsVlans`='" . $vlan . "';";
$result2 = $dbhandle->query($strQuery2) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
echo '<p>Vlan removed/p>';

echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/devices/ports/portsedit.php?port=' . $port . '&customer=' . $customer . '&site=' . $site . '&device=' . $device . '">';

include("../../../../../includes/php/bottom.php");
?>