<?php
include("../../../includes/php/top.php");
include("../../../includes/php/mysqli.php");

$port     = $_GET["port"];
$customer = $_GET["customer"];
$site     = $_GET["site"];
$device   = $_GET["device"];

// escape stings

$port = mysqli_real_escape_string($dbhandle, $port);
$customer = mysqli_real_escape_string($dbhandle, $customer);
$site = mysqli_real_escape_string($dbhandle, $site);
$device = mysqli_real_escape_string($dbhandle, $device);

if ($port == NULL) {
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

$strQuery = "SELECT ModelNr, SerialNumber FROM devices WHERE idDevices = $device;";
$result = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
$response = mysqli_fetch_array($result);
$bcModelNr = $response[ModelNr];
$bcSerialNumber = $response[SerialNumber];

$strQuery = "SELECT ports.Type FROM devicesports INNER JOIN ports ON devicesports.Port = ports.idPorts WHERE devicesports.idDevicesPorts = $port;";
$result = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
$response = mysqli_fetch_array($result);
$bcType = $response[Type];

?>
<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header"><?php echo $bcType; ?> <small><?php echo $CustomerName . ' ' . $Street . ' ' . $Number . ' ' . $ZIP . ' ' . $City . ' ' . $bcModelNr . ' ' . $bcSerialNumber; ?></small></h1>
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
      <li>
        <i class="fa fa-server"></i> <?php echo $bcModelNr . ' ' . $bcSerialNumber; ?>
      </li>
      <li class="active">
        <i class="fa fa-plug"></i> <?php echo $bcType; ?>
      </li>
    </ol>
  </div>
</div>
<?php

echo '<div class="row"><div class="col-lg-12"><div class="panel panel-default"><div class="panel-heading"><h3 class="panel-title"><i class="fa fa-plug fa-fw"></i> Connections</h3></div><div class="panel-body">';

$strQuery4 = "SELECT portconnections.idPortConnections, portconnections.DevicesPort, portconnections.DevicesPort1, devices.ModelNr, manufacturers.Name, devicetypes.Description, devices_1.ModelNr AS ModelNr1, manufacturers_1.Name AS Name1, devicetypes_1.Description AS Description1, devicesports.Device, devicesports_1.Device AS Device1
FROM (((((devices INNER JOIN ((portconnections INNER JOIN devicesports AS devicesports_1 ON portconnections.DevicesPort1 = devicesports_1.idDevicesPorts) INNER JOIN devicesports ON portconnections.DevicesPort = devicesports.idDevicesPorts) ON devices.idDevices = devicesports.Device) INNER JOIN devices AS devices_1 ON devicesports_1.Device = devices_1.idDevices) INNER JOIN manufacturers ON devices.Manufacturer = manufacturers.idManufacturer) INNER JOIN manufacturers AS manufacturers_1 ON devices_1.Manufacturer = manufacturers_1.idManufacturer) INNER JOIN devicetypes AS devicetypes_1 ON devices_1.DeviceType = devicetypes_1.idDeviceTypes) INNER JOIN devicetypes ON devices.DeviceType = devicetypes.idDeviceTypes
WHERE portconnections.DevicesPort = $port OR portconnections.DevicesPort1 = $port;";

$result4 = $dbhandle->query($strQuery4) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
$response4         = mysqli_fetch_array($result4);
$idPortConnections = $response4[idPortConnections];
$DevicesPort       = $response4[DevicesPort];
$DevicesPort1      = $response4[DevicesPort1];
$ModelNr           = $response4[ModelNr];
$Name              = $response4[Name];
$Description       = $response4[Description];
$Device            = $response4[Device];
$ModelNr1          = $response4[ModelNr1];
$Name1             = $response4[Name1];
$Description1      = $response4[Description1];
$Device1           = $response4[Device1];

if (!$idPortConnections == NULL) {
    if ($Device == $device) {
		
		$strQuery = "SELECT ports.Type FROM devicesports INNER JOIN ports ON devicesports.Port = ports.idPorts WHERE devicesports.idDevicesPorts = $Device1;";
		$result = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
		$response          = mysqli_fetch_array($result);
		$Connectedportname = $response[Type];
		
        echo 'Connected to ' . $ModelNr . ' ' . $DevicesPort . ' ' . $DevicesPort1 . '<br><br>';
        
        echo '<form role="form" action="' . $baseurl . 'entry/devices/ports/connections/connectionsremove.php" method="get">';
        echo '<input type="hidden" name="customer" value="' . $customer . '">';
        echo '<input type="hidden" name="site" value="' . $site . '">';
        echo '<input type="hidden" name="device" value="' . $device . '">';
        echo '<input type="hidden" name="port" value="' . $port . '">';
        echo '<input type="hidden" name="connection" value="' . $idPortConnections . '">';
        echo '<button type="submit" class="btn btn-default">Remove</button></form>';
        
        $strQuery4 = "SELECT portconnectionsvlans.idPortConnectionsVlans, customersitesvlans.Vlan, customersitesvlans.Description, customersitesvlans.Range, customersitesvlans.Subnet FROM portconnectionsvlans INNER JOIN customersitesvlans ON portconnectionsvlans.CustomerSitesVlan = customersitesvlans.idCustomerSitesVlans WHERE portconnectionsvlans.PortConnection = $idPortConnections ORDER BY customersitesvlans.VLan ASC;";
        $result4 = $dbhandle->query($strQuery4) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
        
        echo "<div class='table-responsive'><table class='table table-striped results'><thead><tr><th></th><th>Vlan</th><th>Description</th><th>Range</th></tr></thead><tbody>";
        
        while ($row = mysqli_fetch_array($result4)) {
            echo '<tr><td><a class="btn btn-primary btn-xs" href="entry/devices/ports/connections/vlans/vlansremove.php?vlan=' . $row['idPortConnectionsVlans'] . '&port=' . $port . '&device=' . $device . '&customer=' . $customer . '&site=' . $site . '">remove</a></td><td>' . $row['Vlan'] . '</td><td>' . $row['Description'] . '</td><td>' . $row['Range'] . '/' . $row['Subnet'] . '</td></tr>';
        }
        echo "</tbody></table></div>";
        
        echo '<form role="form" action="' . $baseurl . 'entry/devices/ports/connections/vlans/vlansadd.php" method="get">';
        echo '<input type="hidden" name="customer" value="' . $customer . '">';
        echo '<input type="hidden" name="site" value="' . $site . '">';
        echo '<input type="hidden" name="device" value="' . $device . '">';
        echo '<input type="hidden" name="port" value="' . $port . '">';
        echo '<input type="hidden" name="connection" value="' . $idPortConnections . '">';
		
		echo '<div class="form-group"><label for="vlan">Select a vlan:</label>';
		echo '<select name="vlan" class="form-control" id="vlan">';
		$strQuery = "SELECT idCustomerSitesVlans, Vlan, Description, `Range`, Subnet FROM customersitesvlans WHERE CustomerSite = $site ORDER BY Vlan ASC;";
		$result = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
		while ($row = mysqli_fetch_array($result)) {
			echo '<option value="' . $row['idCustomerSitesVlans'] . '"';
			echo '>' . $row['Vlan'] . ' &nbsp; ' . $row['Description'] . ' &nbsp; ' . $row['Range'] . ' / ' . $row['Subnet'] . '</option>';
		}
		echo '</select></div>';
		
        echo '<button type="submit" class="btn btn-default">Add</button></form>';
        
    } else {
		
		
		
		
		
        echo 'Connected to ' . $ModelNr . ' ' . $DevicesPort . ' ' . $DevicesPort1 . '<br><br>';
        
        echo '<form role="form" action="' . $baseurl . 'entry/devices/ports/connections/connectionsremove.php" method="get">';
        echo '<input type="hidden" name="customer" value="' . $customer . '">';
        echo '<input type="hidden" name="site" value="' . $site . '">';
        echo '<input type="hidden" name="device" value="' . $device . '">';
        echo '<input type="hidden" name="port" value="' . $port . '">';
        echo '<input type="hidden" name="connection" value="' . $idPortConnections . '">';
        echo '<button type="submit" class="btn btn-default">Remove</button></form>';
		
		$strQuery4 = "SELECT portconnectionsvlans.idPortConnectionsVlans, customersitesvlans.Vlan, customersitesvlans.Description, customersitesvlans.Range, customersitesvlans.Subnet FROM portconnectionsvlans INNER JOIN customersitesvlans ON portconnectionsvlans.CustomerSitesVlan = customersitesvlans.idCustomerSitesVlans WHERE portconnectionsvlans.PortConnection = $idPortConnections ORDER BY customersitesvlans.VLan ASC;";
        $result4 = $dbhandle->query($strQuery4) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
        
        echo "<div class='table-responsive'><table class='table table-striped results'><thead><tr><th></th><th>Vlan</th><th>Description</th><th>Range</th></tr></thead><tbody>";
        
        while ($row = mysqli_fetch_array($result4)) {
            echo '<tr><td><a class="btn btn-primary btn-xs" href="entry/devices/ports/connections/vlans/vlansremove.php?vlan=' . $row['idPortConnectionsVlans'] . '&port=' . $port . '&device=' . $device . '&customer=' . $customer . '&site=' . $site . '">remove</a></td><td>' . $row['Vlan'] . '</td><td>' . $row['Description'] . '</td><td>' . $row['Range'] . '/' . $row['Subnet'] . '</td></tr>';
        }
        echo "</tbody></table></div>";
		
		echo '<form role="form" action="' . $baseurl . 'entry/devices/ports/connections/vlans/vlansadd.php" method="get">';
        echo '<input type="hidden" name="customer" value="' . $customer . '">';
        echo '<input type="hidden" name="site" value="' . $site . '">';
        echo '<input type="hidden" name="device" value="' . $device . '">';
        echo '<input type="hidden" name="port" value="' . $port . '">';
        echo '<input type="hidden" name="connection" value="' . $idPortConnections . '">';
		
		echo '<div class="form-group"><label for="vlan">Select a vlan:</label>';
		echo '<select name="vlan" class="form-control" id="vlan">';
		$strQuery = "SELECT idCustomerSitesVlans, Vlan, Description, `Range`, Subnet FROM customersitesvlans WHERE CustomerSite = $site ORDER BY Vlan ASC;";
		$result = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
		while ($row = mysqli_fetch_array($result)) {
			echo '<option value="' . $row['idCustomerSitesVlans'] . '"';
			echo '>' . $row['Vlan'] . ' &nbsp; ' . $row['Description'] . ' &nbsp; ' . $row['Range'] . ' / ' . $row['Subnet'] . '</option>';
		}
		echo '</select></div>';
		
        echo '<button type="submit" class="btn btn-default">Add</button></form>';
        
    }
} else {
    echo 'Not connected to device<br><br>';
    
    echo '<form role="form" action="' . $baseurl . 'entry/devices/ports/connections/connectionsnew.php" method="get">';
    echo '<input type="hidden" name="customer" value="' . $customer . '">';
    echo '<input type="hidden" name="site" value="' . $site . '">';
    echo '<input type="hidden" name="device" value="' . $device . '">';
	echo '<input type="hidden" name="port" value="' . $port . '">';
    
    echo '<div class="form-group"><label for="condevice">Select a device:</label>';
    echo '<select name="condevice" class="form-control" id="condevice">';
    $strQuery = "SELECT devices.idDevices, customerrooms.Name AS Room, devices.ModelNr, manufacturers.Name, devices.Notes FROM (devices INNER JOIN manufacturers ON devices.Manufacturer = manufacturers.idManufacturer) INNER JOIN customerrooms ON devices.Room = customerrooms.idCustomerRooms WHERE devices.CustomerSite = $site;";
    $result = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
    while ($row = mysqli_fetch_array($result)) {
        echo '<option value="' . $row['idDevices'] . '"';
        echo '>' . $row['Name'] . ' &nbsp; ' . $row['ModelNr'] . ' &nbsp; ' . $row['Room'] . ' &nbsp; ' . $row['Notes'] . '</option>';
    }
    echo '</select></div>';
    
    echo '<button type="submit" class="btn btn-default">Add</button></form>';   
}

echo '</div></div></div></div>';

$strQuery2 = "SELECT Port, Note FROM devicesports WHERE idDevicesPorts = $port;";
$result2 = $dbhandle->query($strQuery2) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
$response2 = mysqli_fetch_array($result2);
$Note      = $response2[Note];
$Port      = $response2[Port];

echo '<form role="form" action="' . $baseurl . 'entry/devices/ports/portseditsave.php" method="get">';
echo '<input type="hidden" name="customer" value="' . $customer . '">';
echo '<input type="hidden" name="site" value="' . $site . '">';
echo '<input type="hidden" name="device" value="' . $device . '">';
echo '<input type="hidden" name="port" value="' . $port . '">';

echo '<div class="form-group"><label for="porttype">Select a port type:</label>';
echo '<select name="porttype" class="form-control" id="porttype">';
$strQuery = "SELECT idPorts, Type FROM ports ORDER BY Type ASC;";
$result = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
while ($row = mysqli_fetch_array($result)) {
    echo '<option value="' . $row['idPorts'] . '"';
    if ($row['idPorts'] == $Port) {
        echo ' selected';
    }
    echo '>' . $row['Type'] . '</option>';
}
echo '</select></div>';
echo '<div class="form-group"><label for="note">Note:</label><input type="text" class="form-control" name="note" id="note" value="' . $Note . '"></div>';

echo '<button type="submit" class="btn btn-default">Change</button></form>';

include("../../../includes/php/bottom.php");
?>