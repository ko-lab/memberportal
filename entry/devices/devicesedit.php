<?php
include("../../includes/php/top.php");
include("../../includes/php/mysqli.php");

echo '<script src="includes/tinymce/tinymce.min.js"></script>';
echo "<script>tinymce.init({ selector:'textarea', language: 'en', menubar: false });</script>";

$device   = $_GET["device"];
$customer = $_GET["customer"];
$site     = $_GET["site"];

// escape stings

$device = mysqli_real_escape_string($dbhandle, $device);
$customer = mysqli_real_escape_string($dbhandle, $customer);
$site = mysqli_real_escape_string($dbhandle, $site);

if ($device == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/entry.php">';
    exit;
}

$strQuery = "SELECT Street, Number, ZIP, City FROM customersites WHERE idCustomerSites = $site;";
$result = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
$response = mysqli_fetch_array($result);
$Street = $response[Street];
$Number = $response[Number];
$ZIP = $response[ZIP];
$City = $response[City];

$strQuery = "SELECT CustomerName FROM customers WHERE idCustomers = $customer;";
$result = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
$response = mysqli_fetch_array($result);
$CustomerName = $response[CustomerName];

$strQuery = "SELECT ModelNr, SerialNumber, Hostname FROM devices WHERE idDevices = $device;";
$result = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
$response = mysqli_fetch_array($result);
$bcModelNr = $response[ModelNr];
$bcSerialNumber = $response[SerialNumber];
$Hostname = $response[Hostname];

?>
<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header"><?php echo $bcModelNr . ' ' . $bcSerialNumber; ?> <small><?php echo $CustomerName . ' ' . $Street . ' ' . $Number . ' ' . $ZIP . ' ' . $City; ?></small></h1>
    <ol class="breadcrumb">
      <li>
        <i class="fa fa-home"></i> Home
      </li>
	  <li>
        <i class="fa fa-user"></i> <?php echo $CustomerName; ?>
      </li>
	  <li>
        <i class="fa fa-map-marker"></i> <?php echo $Street . ' ' . $Number . ' ' . $ZIP . ' ' . $City; ?>
      </li>
	  <li class="active">
        <i class="fa fa-server"></i> <?php echo $bcModelNr . ' ' . $bcSerialNumber; ?>
      </li>
    </ol>
  </div>
</div>
<?php

echo '<div class="row"><div class="col-lg-6"><div class="panel panel-default"><div class="panel-heading"><h3 class="panel-title"><i class="fa fa-hand-paper-o fa-fw"></i> Services</h3></div><div class="panel-body">';

$strQuery4 = "SELECT devicesservices.idDevicesServices, services.Name, services.Port FROM devicesservices INNER JOIN services ON devicesservices.Service = services.idServices WHERE Device = $device ORDER BY services.Port ASC;";
$result4 = $dbhandle->query($strQuery4) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");

echo "<div class='table-responsive'><table class='table table-striped'><thead><tr><th></th><th>Name</th><th>Port</th></tr></thead><tbody>";

while ($row = mysqli_fetch_array($result4)) {
    echo '<tr><td><a class="btn btn-primary btn-xs" href="entry/devices/services/servicesremove.php?service=' . $row['idDevicesServices'] . '&customer=' . $customer . '&site=' . $site . '&device=' . $device . '">Remove</a></td><td>' . $row['Name'] . '</td><td>' . $row['Port'] . ' ' . $row['protocolsName'] . '</td></tr>';
}
echo "</tbody></table></div>";

echo '<form role="form" action="' . $baseurl . 'entry/devices/services/servicesnew.php" method="get">';
echo '<input type="hidden" name="customer" value="' . $customer . '">';
echo '<input type="hidden" name="site" value="' . $site . '">';
echo '<input type="hidden" name="device" value="' . $device . '">';

echo '<div class="form-group"><label for="service">Select a service:</label>';
echo '<select name="service" class="form-control" id="service">';
$strQuery = "SELECT idServices, Name, Port FROM services ORDER BY Port ASC;";
$result = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
while ($row = mysqli_fetch_array($result)) {
    echo '<option value="' . $row['idServices'] . '"';
    echo '>' . $row['Port'] . ' ' . $row['Name'] . '</option>';
}
echo '</select></div>';

echo '<button type="submit" class="btn btn-default">Add</button></form>';

echo '</div></div></div>';

echo '<div class="col-lg-6"><div class="panel panel-default"><div class="panel-heading"><h3 class="panel-title"><i class="fa fa-bolt fa-fw"></i> Ip Adresses</h3></div><div class="panel-body">';

$strQuery4 = "SELECT customerdevicesipadresses.idCustomerDevicesIpAdresses, customerdevicesipadresses.Adress, customerdevicesipadresses.Note, customersitesvlans.Vlan FROM customersitesvlans INNER JOIN customerdevicesipadresses ON customersitesvlans.idCustomerSitesVlans = customerdevicesipadresses.CustomerSitesVlan WHERE customerdevicesipadresses.Device = $device ORDER BY customersitesvlans.Vlan ASC;";
$result4 = $dbhandle->query($strQuery4) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");

echo "<div class='table-responsive'><table class='table table-striped'><thead><tr><th></th><th>Adress</th><th>Note</th><th>Vlan</th></tr></thead><tbody>";

while ($row = mysqli_fetch_array($result4)) {
    echo '<tr><td><a class="btn btn-primary btn-xs" href="entry/devices/adresses/adressesedit.php?adress=' . $row['idCustomerDevicesIpAdresses'] . '&customer=' . $customer . '&site=' . $site . '&device=' . $device . '">Edit</a></td><td>' . $row['Adress'] . '</td><td>' . $row['Note'] . '</td><td>' . $row['Vlan'] . '</td></tr>';
}
echo "</tbody></table></div>";

echo '<form role="form" action="' . $baseurl . 'entry/devices/adresses/adressesnew.php" method="get">';
echo '<input type="hidden" name="customer" value="' . $customer . '">';
echo '<input type="hidden" name="site" value="' . $site . '">';
echo '<input type="hidden" name="device" value="' . $device . '">';

echo '<div class="form-group"><label for="vlan">Select a vlan:</label>';
echo '<select name="vlan" class="form-control" id="vlan">';
$strQuery15 = "SELECT idCustomerSitesVlans, Vlan, Description, `Range`, Subnet FROM customersitesvlans WHERE CustomerSite =$site ORDER BY Vlan ASC;";
$result15 = $dbhandle->query($strQuery15) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
while ($row = mysqli_fetch_array($result15)) {
    echo '<option value="' . $row['idCustomerSitesVlans'] . '"';
    echo '>' . $row['Vlan'] . ' ' . $row['Description'] . ' ' . $row['Range'] . ' / ' . $row['Subnet'] . '</option>';
}
echo '</select></div>';

echo '<div class="form-group"><label for="adress">Adress:</label><input type="text" class="form-control" name="adress" id="adress"></div>';
echo '<div class="form-group"><label for="note">Note:</label><input type="text" class="form-control" name="note" id="note"></div>';

echo '<button type="submit" class="btn btn-default">Add</button></form>';

echo '</div></div></div></div>';

echo '<div class="row"><div class="col-lg-12"><div class="panel panel-default"><div class="panel-heading"><h3 class="panel-title"><i class="fa fa-plug fa-fw"></i> Ports</h3></div><div class="panel-body">';

$strQuery4 = "SELECT devicesports.idDevicesPorts, ports.Type, devicesports.Note FROM devicesports INNER JOIN ports ON devicesports.Port = ports.idPorts WHERE devicesports.Device = $device ORDER BY ports.idPorts ASC;";
$result4 = $dbhandle->query($strQuery4) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");

echo "<div class='table-responsive'><table class='table table-striped'><thead><tr><th></th><th>Type</th><th>Note</th></tr></thead><tbody>";

while ($row = mysqli_fetch_array($result4)) {
    echo '<tr><td><a class="btn btn-primary btn-xs" href="entry/devices/ports/portsedit.php?port=' . $row['idDevicesPorts'] . '&customer=' . $customer . '&site=' . $site . '&device=' . $device . '">Edit</a></td><td>' . $row['Type'] . '</td><td>' . $row['Note'] . '</td></tr>';
}
echo "</tbody></table></div>";

echo '<form role="form" action="' . $baseurl . 'entry/devices/ports/portsnew.php" method="get">';
echo '<input type="hidden" name="customer" value="' . $customer . '">';
echo '<input type="hidden" name="site" value="' . $site . '">';
echo '<input type="hidden" name="device" value="' . $device . '">';

echo '<div class="form-group"><label for="porttype">Select a port type:</label>';
echo '<select name="porttype" class="form-control" id="porttype">';
$strQuery = "SELECT idPorts, Type FROM ports;";
$result = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
while ($row = mysqli_fetch_array($result)) {
    echo '<option value="' . $row['idPorts'] . '"';
    echo '>' . $row['Type'] . '</option>';
}
echo '</select></div>';

echo '<div class="form-group"><label for="note">Note:</label><input type="text" class="form-control" name="note" id="note"></div>';

echo '<button type="submit" class="btn btn-default">Add</button></form>';

echo '</div></div></div></div>';

$strQuery2 = "SELECT SerialNumber, Notes, Room, Rack, Unit FROM devices WHERE idDevices = $device;";
$result2 = $dbhandle->query($strQuery2) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
$response2    = mysqli_fetch_array($result2);
$SerialNumber = $response2[SerialNumber];
$Notes        = $response2[Notes];
$Room         = $response2[Room];
$Rack         = $response2[Rack];
$Unit         = $response2[Unit];

echo '<form role="form" action="' . $baseurl . 'entry/devices/deviceseditsave.php" method="get">';
echo '<input type="hidden" name="customer" value="' . $customer . '">';
echo '<input type="hidden" name="site" value="' . $site . '">';
echo '<input type="hidden" name="device" value="' . $device . '">';

echo '<div class="form-group"><label for="hostname">Hostname:</label><input type="text" class="form-control" name="hostname" id="hostname" value="' . $Hostname . '"></div>';
echo '<div class="form-group"><label for="serialnumber">SerialNumber:</label><input type="text" class="form-control" name="serialnumber" id="serialnumber" value="' . $SerialNumber . '"></div>';

echo '<div class="form-group"><label for="room">Select a room:</label>';
echo '<select name="room" class="form-control" id="room">';
$strQuery = "SELECT idCustomerRooms, Name FROM customerrooms WHERE CustomerSite =$site ORDER BY Name ASC;";
$result = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
while ($row = mysqli_fetch_array($result)) {
    echo '<option value="' . $row['idCustomerRooms'] . '"';
        if ($row['idCustomerRooms'] == $Room) {
            echo ' selected';
        }
        echo '>' . $row['Name'] . '</option>';
}
echo '</select></div>';

echo '<div class="form-group"><label for="rack">Rack:</label><input type="text" class="form-control" name="rack" id="rack" value="' . $Rack . '"></div>';
echo '<div class="form-group"><label for="unit">Unit:</label><input type="text" class="form-control" name="unit" id="unit" value="' . $Unit . '"></div>';

echo '<textarea name="notes" id="notes">' . $Notes . '</textarea><br>';

echo '<button type="submit" class="btn btn-default">Change</button></form>';

include("../../includes/php/bottom.php");
?>