<?php
include("../../includes/php/top.php");
include("../../includes/php/mysqli.php");

$manufacturer     = $_GET["manufacturer"];
$customer = $_GET["customer"];
$site     = $_GET["site"];
$devicetype     = $_GET["devicetype"];

// escape stings

$manufacturer = mysqli_real_escape_string($dbhandle, $manufacturer);
$devicetype = mysqli_real_escape_string($dbhandle, $devicetype);

if ($customer == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/entry.php">';
    exit;
}
if ($site == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/entry.php">';
    exit;
}

echo '<form role="form" action="' . $baseurl . 'entry/devices/devicesnew2.php" method="get">';
echo '<input type="hidden" name="customer" value="' . $customer . '">';
echo '<input type="hidden" name="site" value="' . $site . '">';
echo '<input type="hidden" name="manufacturer" value="' . $manufacturer . '">';
echo '<input type="hidden" name="devicetype" value="' . $devicetype . '">';

echo '<div class="form-group"><label for="model">Select a model:</label>';
echo '<select name="model" class="form-control" id="model">';

if ($devicetype==0) {
	$strQuery = "SELECT idDeviceTemplates, Name FROM devicetemplates WHERE Manufacturer = $manufacturer ORDER BY Name ASC;";
} else {
	$strQuery = "SELECT idDeviceTemplates, Name FROM devicetemplates WHERE Manufacturer = $manufacturer AND DeviceType = $devicetype ORDER BY Name ASC;";
}

$result = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
while ($row = mysqli_fetch_array($result)) {
    echo '<option value="' . $row['idDeviceTemplates'] . '"';
    echo '>' . $row['Name'] . '</option>';
}
echo '</select></div>';

echo '<button type="submit" class="btn btn-default">Next step</button></form>';

include("../../includes/php/bottom.php");
?>