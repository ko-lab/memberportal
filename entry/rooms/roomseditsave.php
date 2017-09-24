<?php
include("../../includes/php/top.php");
include("../../includes/php/mysqli.php");

$customer = $_GET["customer"];
$site     = $_GET["site"];
$room     = $_GET["room"];
$name     = $_GET["name"];

// escape stings

$site   = mysqli_real_escape_string($dbhandle, $site);
$vlan   = mysqli_real_escape_string($dbhandle, $vlan);
$room   = mysqli_real_escape_string($dbhandle, $room);
$name   = mysqli_real_escape_string($dbhandle, $name);

if ($site == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/entry.php">';
    exit;
}
if ($room == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/entry.php">';
    exit;
}

$strQuery2 = "UPDATE `customerrooms` SET `Name`='" . $name . "' WHERE `idCustomerRooms`='" . $room . "';";
$result2 = $dbhandle->query($strQuery2) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");

echo '<p>Room changed</p>';
echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/entry.php?customer=' . $customer . '&site=' . $site . '">';

include("../../includes/php/bottom.php");
?>