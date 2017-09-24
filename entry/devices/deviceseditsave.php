<?php
include("../../includes/php/top.php");
include("../../includes/php/mysqli.php");
require_once '../../includes/htmlpurifier/HTMLPurifier.auto.php';

$customer   = $_GET["customer"];
$site   = $_GET["site"];
$device   = $_GET["device"];
$serialnumber   = $_GET["serialnumber"];
$notes   = $_GET["notes"];
$rack   = $_GET["rack"];
$unit   = $_GET["unit"];
$room   = $_GET["room"];
$hostname   = $_GET["hostname"];

// escape stings

$site   = mysqli_real_escape_string($dbhandle, $site);
$device   = mysqli_real_escape_string($dbhandle, $device);
$serialnumber   = mysqli_real_escape_string($dbhandle, $serialnumber);
$notes   = mysqli_real_escape_string($dbhandle, $notes);
$rack   = mysqli_real_escape_string($dbhandle, $rack);
$unit   = mysqli_real_escape_string($dbhandle, $unit);
$room   = mysqli_real_escape_string($dbhandle, $room);
$hostname   = mysqli_real_escape_string($dbhandle, $hostname);

if ($site == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/entry.php">';
    exit;
}
if ($device == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/entry.php">';
    exit;
}

$config = HTMLPurifier_Config::createDefault();
$purifier = new HTMLPurifier($config);
$notes = $purifier->purify($notes);

$strQuery2 = "UPDATE `devices` SET `SerialNumber`='" . $serialnumber . "', `Notes`='" . $notes . "', `Room`='" . $room . "', `Rack`='" . $rack . "', `Unit`='" . $unit . "', `Hostname`='" . $hostname . "' WHERE `idDevices`='" . $device . "';";
$result2 = $dbhandle->query($strQuery2) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");

echo '<p>Device changed</p>';
echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/entry.php?customer=' . $customer . '&site=' . $site . '">';

include("../../includes/php/bottom.php");
?>