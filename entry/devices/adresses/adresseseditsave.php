<?php
include("../../../includes/php/top.php");
include("../../../includes/php/mysqli.php");

$customer   = $_GET["customer"];
$site   = $_GET["site"];
$device   = $_GET["device"];
$adress   = $_GET["adress"];
$ipadress   = $_GET["ipadress"];
$vlan   = $_GET["vlan"];
$note   = $_GET["note"];


// escape stings

$customer   = mysqli_real_escape_string($dbhandle, $customer);
$site   = mysqli_real_escape_string($dbhandle, $site);
$adress   = mysqli_real_escape_string($dbhandle, $adress);
$ipadress   = mysqli_real_escape_string($dbhandle, $ipadress);
$vlan   = mysqli_real_escape_string($dbhandle, $vlan);
$note   = mysqli_real_escape_string($dbhandle, $note);

if ($site == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/entry.php">';
    exit;
}
if ($adress == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/entry.php">';
    exit;
}

$strQuery2 = "UPDATE `customerdevicesipadresses` SET `Adress`='" . $ipadress . "', `Note`='" . $note . "', `CustomerSitesVlan`='" . $vlan . "' WHERE `idCustomerDevicesIpAdresses`='" . $adress . "';";
$result2 = $dbhandle->query($strQuery2) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");

echo '<p>Ip adress changed</p>';
echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/devices/devicesedit.php?device=' . $device . '&customer=' . $customer . '&site=' . $site . '">';

include("../../../includes/php/bottom.php");
?>