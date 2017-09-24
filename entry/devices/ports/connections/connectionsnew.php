<?php
include("../../../../includes/php/top.php");
include("../../../../includes/php/mysqli.php");

$customer     = $_GET["customer"];
$site = $_GET["site"];
$device     = $_GET["device"];
$condevice     = $_GET["condevice"];
$port     = $_GET["port"];

// escape stings

$device = mysqli_real_escape_string($dbhandle, $device);
$condevice = mysqli_real_escape_string($dbhandle, $condevice);
$site = mysqli_real_escape_string($dbhandle, $site);

if ($device == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/entry.php">';
    exit;
}
if ($condevice == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/entry.php">';
    exit;
}
if ($site == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/entry.php">';
    exit;
}

echo '<form role="form" action="' . $baseurl . 'entry/devices/ports/connections/connectionsnewsave.php" method="get">';
echo '<input type="hidden" name="customer" value="' . $customer . '">';
echo '<input type="hidden" name="site" value="' . $site . '">';
echo '<input type="hidden" name="device" value="' . $device . '">';
echo '<input type="hidden" name="port" value="' . $port . '">';

echo '<div class="form-group"><label for="conport">Select a port:</label>';
echo '<select name="conport" class="form-control" id="conport">';

$strQuery = "SELECT devicesports.idDevicesPorts, ports.Type, devicesports.Note FROM devicesports INNER JOIN ports ON devicesports.Port = ports.idPorts WHERE Device = $condevice ORDER BY ports.Type ASC;";
$result = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
while ($row = mysqli_fetch_array($result)) {
    echo '<option value="' . $row['idDevicesPorts'] . '"';
    echo '>' . $row['Type'] . ' &nbsp; ' . $row['Note'] . '</option>';
}
echo '</select></div>';

echo '<button type="submit" class="btn btn-default">Save</button></form>';

include("../../../../includes/php/bottom.php");
?>