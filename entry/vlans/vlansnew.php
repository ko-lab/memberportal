<?php
include("../../includes/php/top.php");
include("../../includes/php/mysqli.php");

$customer    = $_GET["customer"];
$site        = $_GET["site"];
$vlan        = $_GET["vlan"];
$description = $_GET["description"];
$range       = $_GET["range"];
$subnet      = $_GET["subnet"];

// escape stings

$site        = mysqli_real_escape_string($dbhandle, $site);
$vlan        = mysqli_real_escape_string($dbhandle, $vlan);
$description = mysqli_real_escape_string($dbhandle, $description);
$range       = mysqli_real_escape_string($dbhandle, $range);
$subnet      = mysqli_real_escape_string($dbhandle, $subnet);

if ($site == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/entry.php">';
    exit;
}
if ($vlan == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/entry.php">';
    exit;
}

$strQuery2 = "INSERT INTO `customersitesvlans` (`CustomerSite`, `Vlan`, `Description`, `Range`, `Subnet`) VALUES ('" . $site . "', '" . $vlan . "', '" . $description . "', '" . $range . "', '" . $subnet . "');";
$result2 = $dbhandle->query($strQuery2) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
echo '<p>Vlan created</p>';
echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/entry.php?customer=' . $customer . '&site=' . $site . '">';

include("../../includes/php/bottom.php");
?>