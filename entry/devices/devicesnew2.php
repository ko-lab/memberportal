<?php
include("../../includes/php/top.php");
include("../../includes/php/mysqli.php");

$manufacturer     = $_GET["manufacturer"];
$customer = $_GET["customer"];
$site     = $_GET["site"];
$devicetype     = $_GET["devicetype"];
$model     = $_GET["model"];

// escape stings

$manufacturer = mysqli_real_escape_string($dbhandle, $manufacturer);
$devicetype = mysqli_real_escape_string($dbhandle, $devicetype);
$model = mysqli_real_escape_string($dbhandle, $model);

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

echo '<form role="form" action="' . $baseurl . 'entry/devices/devicesnewsave.php" method="get">';
echo '<input type="hidden" name="customer" value="' . $customer . '">';
echo '<input type="hidden" name="site" value="' . $site . '">';
echo '<input type="hidden" name="manufacturer" value="' . $manufacturer . '">';
echo '<input type="hidden" name="devicetype" value="' . $devicetype . '">';
echo '<input type="hidden" name="model" value="' . $model . '">';

echo '<div class="form-group"><label for="serialnumber">Serial number:</label><input type="text" class="form-control" name="serialnumber" id="serialnumber"></div>';
echo '<div class="form-group"><label for="notes">Notes:</label><input type="text" class="form-control" name="notes" id="notes"></div>';

echo '<div class="form-group"><label for="devicetype">Select a room:</label>';
echo '<select name="room" class="form-control" id="room">';
$strQuery = "SELECT idCustomerRooms, Name FROM customerrooms WHERE CustomerSite =$site;";
$result = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
while ($row = mysqli_fetch_array($result)) {
    echo '<option value="' . $row['idCustomerRooms'] . '"';
    echo '>' . $row['Name'] . '</option>';
}
echo '</select></div>';

echo '<div class="form-group"><label for="rack">Rack:</label><input type="text" class="form-control" name="rack" id="rack"></div>';
echo '<div class="form-group"><label for="unit">Unit:</label><input type="text" class="form-control" name="unit" id="unit"></div>';
echo '<div class="form-group"><label for="hostname">Hostname:</label><input type="text" class="form-control" name="hostname" id="hostname"></div>';

echo '<button type="submit" class="btn btn-default">Add</button></form>';

include("../../includes/php/bottom.php");
?>