<?php
include("../../includes/php/top.php");
include("../../includes/php/mysqli.php");

$customer   = $_GET["customer"];
$site   = $_GET["site"];
$vlan   = $_GET["vlan"];
$description   = $_GET["description"];
$range   = $_GET["range"];
$subnet   = $_GET["subnet"];
$vlanid   = $_GET["vlanid"];

// escape stings

$site   = mysqli_real_escape_string($dbhandle, $site);
$vlan   = mysqli_real_escape_string($dbhandle, $vlan);
$description   = mysqli_real_escape_string($dbhandle, $description);
$range   = mysqli_real_escape_string($dbhandle, $range);
$subnet   = mysqli_real_escape_string($dbhandle, $subnet);
$vlanid   = mysqli_real_escape_string($dbhandle, $vlanid);

if ($site == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/entry.php">';
    exit;
}
if ($vlan == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/entry.php">';
    exit;
}
if ($vlanid == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/entry.php">';
    exit;
}

$strQuery2 = "UPDATE `customersitesvlans` SET `Vlan`='" . $vlanid . "', `Description`='" . $description . "', `Range`='" . $range . "', `Subnet`='" . $subnet . "' WHERE `idCustomerSitesVlans`='" . $vlan . "';";
$result2 = $dbhandle->query($strQuery2) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");

echo '<p>Vlan changed</p>';
echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/entry.php?customer=' . $customer . '&site=' . $site . '">';

include("../../includes/php/bottom.php");
?>