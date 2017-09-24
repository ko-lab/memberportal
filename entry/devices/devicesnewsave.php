<?php
include("../../includes/php/top.php");
include("../../includes/php/mysqli.php");

$manufacturer = $_GET["manufacturer"];
$customer     = $_GET["customer"];
$site         = $_GET["site"];
$devicetype   = $_GET["devicetype"];
$model        = $_GET["model"];
$serialnumber = $_GET["serialnumber"];
$notes        = $_GET["notes"];
$room         = $_GET["room"];
$rack         = $_GET["rack"];
$unit         = $_GET["unit"];
$hostname     = $_GET["hostname"];

// escape stings

$manufacturer = mysqli_real_escape_string($dbhandle, $manufacturer);
$devicetype   = mysqli_real_escape_string($dbhandle, $devicetype);
$model        = mysqli_real_escape_string($dbhandle, $model);
$serialnumber = mysqli_real_escape_string($dbhandle, $serialnumber);
$notes        = mysqli_real_escape_string($dbhandle, $notes);
$room         = mysqli_real_escape_string($dbhandle, $room);
$rack         = mysqli_real_escape_string($dbhandle, $rack);
$unit         = mysqli_real_escape_string($dbhandle, $unit);
$site         = mysqli_real_escape_string($dbhandle, $site);
$hostname     = mysqli_real_escape_string($dbhandle, $hostname);

if ($customer == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/entry.php">';
    exit;
}
if ($site == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/entry.php">';
    exit;
}
if ($model == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/entry.php">';
    exit;
}

echo '<h3>ADDING DEVICE</h3>';

// add device

$strQuery = "SELECT Name, Manufacturer, DeviceType FROM devicetemplates WHERE idDeviceTemplates = $model;";
$result = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
$response = mysqli_fetch_array($result);
$DeviceName = $response[Name];
$manufacturer = $response[Manufacturer];
$DeviceType = $response[DeviceType];

$strQuery = "INSERT INTO `devices` (`SerialNumber`, `Notes`, `CustomerSite`, `Room`, `Rack`, `Unit`, `Manufacturer`, `DeviceType`, `ModelNr`, `Hostname`) VALUES ('" . $serialnumber . "', '" . $notes . "', '" . $site . "', '" . $room . "', '" . $rack . "', '" . $unit . "', '" . $manufacturer . "', '" . $DeviceType . "', '" . $DeviceName . "', '" . $hostname . "');";
$result = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
$deviceid = $dbhandle->insert_id;
echo '<p>Device added<br>';

//add ports

$strQuery1 = "SELECT Port FROM devicetemplatesports WHERE DeviceTemplate = $model;";
$result1 = $dbhandle->query($strQuery1) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
while ($row = mysqli_fetch_array($result1)) {
    $strQuery2 = "INSERT INTO `devicesports` (`Device`, `Port`) VALUES ('" . $deviceid . "', '" . $row['Port'] . "');";
	$result2 = $dbhandle->query($strQuery2) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
	
	echo 'added port '. $row['Port'] . '<br>';
}

// add services

$strQuery1 = "SELECT Service FROM devicetemplateservices WHERE DeviceTemplate = $model;";
$result1 = $dbhandle->query($strQuery1) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
while ($row = mysqli_fetch_array($result1)) {
    $strQuery2 = "INSERT INTO `devicesservices` (`Device`, `Service`) VALUES ('" . $deviceid . "', '" . $row['Service'] . "');";
	$result2 = $dbhandle->query($strQuery2) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
	
	echo 'added service '. $row['Service'] . '<br>';
}

echo '</p>';
echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/entry.php?customer=' . $customer . '&site=' . $site . '">';

include("../../includes/php/bottom.php");
?>