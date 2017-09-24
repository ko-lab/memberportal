<?php

// include files

include("../includes/php/top.php");
include("../includes/php/mysqli.php");

// get variables

$customer = $_GET["customer"];
$site     = $_GET["site"];

// escape stings

$customer = mysqli_real_escape_string($dbhandle, $customer);
$site = mysqli_real_escape_string($dbhandle, $site);

$strQuery = "SELECT SettingValue FROM settings WHERE idSettings = 1;";
$result = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
$response = mysqli_fetch_array($result);
$mapsenable = $response[SettingValue];

$strQuery = "SELECT Street, Number, ZIP, City, Lat, Lng, NagiosRemoteIp, Nagios, NagiosUser, NagiosPassword FROM customersites WHERE idCustomerSites = $site;";
$result = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
$response = mysqli_fetch_array($result);
$Street = $response[Street];
$Number = $response[Number];
$ZIP = $response[ZIP];
$City = $response[City];
$Lat = $response[Lat];
$Lng = $response[Lng];
$NagiosRemoteIp = $response[NagiosRemoteIp];
$Nagios = $response[Nagios];
$NagiosUser = $response[NagiosUser];
$NagiosPassword = $response[NagiosPassword];

$strQuery = "SELECT CustomerName FROM customers WHERE idCustomers = $customer;";
$result = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
$response = mysqli_fetch_array($result);
$CustomerName = $response[CustomerName];

?>
<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header"><?php echo $CustomerName; ?> <small><?php echo $Street . ' ' . $Number . ' ' . $ZIP . ' ' . $City; ?></small></h1>
    <ol class="breadcrumb">
      <li>
        <i class="fa fa-home"></i> Home
      </li>
      <li>
        <i class="fa fa-user"></i> <?php echo $CustomerName; ?>
      </li>
      <li class="active">
        <i class="fa fa-map-marker"></i> <?php echo $Street . ' ' . $Number . ' ' . $ZIP . ' ' . $City; ?>
      </li>
    </ol>
  </div>
</div>
<?php
if (!$customer == NULL) {
    if (!$site == NULL) {
        
        echo '<div class="btn-group btn-group-justified"><a href="' . $baseurl . 'entry/printpreview.php?customer=' . $customer . '&site=' . $site . '" class="btn btn-primary">Print Preview</a><a href="' . $baseurl . 'entry/print.php?customer=' . $customer . '&site=' . $site . '" class="btn btn-primary">Print</a><a href="#" class="btn btn-primary">Statistics</a></div><br>';
        
        if ($Nagios == 1) {
            
            $context = stream_context_create(array(
                'http' => array(
                    'header' => 'Authorization: Basic ' . base64_encode($NagiosUser . ":" . $NagiosPassword)
                )
            ));
            
            $json = file_get_contents('http://' . $NagiosRemoteIp . '/nagios/cgi-bin/statusjson.cgi?query=servicecount', false, $context);
            $obj  = json_decode($json);
            
            $NagiosServiceok           = $obj->data->count->ok;
            $NagiosServicewarning      = $obj->data->count->warning;
            $NagiosServicecritical     = $obj->data->count->critical;
            $NagiosServiceTotal        = $NagiosServiceok + $NagiosServicewarning + $NagiosServicecritical;
            $NagiosServiceokperc       = $NagiosServiceok / $NagiosServiceTotal * 100;
            $NagiosServicewarningperc  = $NagiosServicewarning / $NagiosServiceTotal * 100;
            $NagiosServicecriticalperc = $NagiosServicecritical / $NagiosServiceTotal * 100;
            
            echo '<div class="progress"><div class="progress-bar progress-bar-success" style="width: ' . $NagiosServiceokperc . '%"><span class="sr-only">' . $NagiosServiceokperc . '% Complete (success)</span>Up</div><div class="progress-bar progress-bar-warning" style="width: ' . $NagiosServicewarningperc . '%"><span class="sr-only">' . $NagiosServicewarningperc . '% Complete (warning)</span>Warning</div><div class="progress-bar progress-bar-danger" style="width: ' . $NagiosServicecriticalperc . '%"><span class="sr-only">' . $NagiosServicecriticalperc . '% Complete (danger)</span>Down</div></div>';
            
            $context = stream_context_create(array(
                'http' => array(
                    'header' => 'Authorization: Basic ' . base64_encode($NagiosUser . ":" . $NagiosPassword)
                )
            ));
            
            $json = file_get_contents('http://' . $NagiosRemoteIp . '/nagios/cgi-bin/statusjson.cgi?query=hostcount', false, $context);
            $obj  = json_decode($json);
            
            $NagiosHostup          = $obj->data->count->up;
            $NagiosHostdown        = $obj->data->count->down;
            $NagiosHostunreachable = $obj->data->count->unreachable;
            
            $NagiosHostTotal           = $NagiosHostup + $NagiosHostdown + $NagiosHostunreachable;
            $NagiosHostupperc          = $NagiosHostup / $NagiosHostTotal * 100;
            $NagiosHostdownperc        = $NagiosHostdown / $NagiosHostTotal * 100;
            $NagiosHostunreachableperc = $NagiosHostunreachable / $NagiosHostTotal * 100;
            
            echo '<div class="progress"><div class="progress-bar progress-bar-success" style="width: ' . $NagiosHostupperc . '%"><span class="sr-only">' . $NagiosHostupperc . '% Complete (success)</span>Up</div><div class="progress-bar progress-bar-warning" style="width: ' . $NagiosHostunreachableperc . '%"><span class="sr-only">' . $NagiosHostunreachableperc . '% Complete (warning)</span>Warning</div><div class="progress-bar progress-bar-danger" style="width: ' . $NagiosHostdownperc . '%"><span class="sr-only">' . $NagiosHostdownperc . '% Complete (danger)</span>Down</div></div>';
            
        }
        
        if ($mapsenable == 1) {
            
            $strQuery = "SELECT SettingValue FROM settings WHERE idSettings = 2;";
            $result = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
            $response   = mysqli_fetch_array($result);
            $mapsapikey = $response[SettingValue];
            
            echo '<div class="row"><div class="col-lg-12"><div class="panel panel-default"><div class="panel-heading"><h3 class="panel-title"><i class="fa fa-map fa-fw"></i> Location</h3></div><div class="panel-body">';
            echo '<div id="map" style="width:100%;height:400px"></div>';
            
            echo '<script>function myMap() {var myCenter = new google.maps.LatLng(' . $Lat . ',' . $Lng . '); var mapCanvas = document.getElementById("map"); var mapOptions = {center: myCenter, zoom: 10, scrollwheel: false}; var map = new google.maps.Map(mapCanvas, mapOptions); var marker = new google.maps.Marker({position:myCenter}); marker.setMap(map); }</script>';
            echo '<script src="https://maps.googleapis.com/maps/api/js?callback=myMap&key=' . $mapsapikey . '"></script>';
            
            echo '</div></div></div></div>';
        }
        
        echo '<div class="row"><div class="col-lg-6"><div class="panel panel-default"><div class="panel-heading"><h3 class="panel-title"><i class="fa fa-plug fa-fw"></i> Vlans</h3></div><div class="panel-body">';
        
        $strQuery4 = "SELECT idCustomerSitesVlans, Vlan, Description, `Range`, Subnet FROM customersitesvlans WHERE CustomerSite = $site ORDER BY VLan ASC;";
        $result4 = $dbhandle->query($strQuery4) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
        
        echo "<div class='table-responsive'><table class='table table-striped results'><thead><tr><th></th><th>Vlan</th><th>Description</th><th>Range</th></tr></thead><tbody>";
        
        while ($row = mysqli_fetch_array($result4)) {
            echo '<tr><td><a class="btn btn-primary btn-xs" href="entry/vlans/vlansedit.php?vlan=' . $row['idCustomerSitesVlans'] . '&customer=' . $customer . '&site=' . $site . '&device=' . $device . '">Edit</a></td><td>' . $row['Vlan'] . '</td><td>' . $row['Description'] . '</td><td>' . $row['Range'] . '/' . $row['Subnet'] . '</td></tr>';
        }
        echo "</tbody></table></div>";
        
        echo '<form role="form" action="' . $baseurl . 'entry/vlans/vlansnew.php" method="get">';
        echo '<input type="hidden" name="customer" value="' . $customer . '">';
        echo '<input type="hidden" name="site" value="' . $site . '">';
        
        echo '<div class="row"><div class="col-sm-6"><div class="form-group"><label for="vlan">Select a vlan:</label>';
        echo '<select name="vlan" class="form-control" id="vlan">';
        $strQuery = "SELECT idVlans FROM vlans;";
        $result = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
        while ($row = mysqli_fetch_array($result)) {
            echo '<option value="' . $row['idVlans'] . '"';
            echo '>' . $row['idVlans'] . '</option>';
        }
        echo '</select></div></div>';
        echo '<div class="col-sm-6"><div class="form-group"><label for="description">Description:</label><input type="text" class="form-control" name="description" id="description"></div></div></div>';
        echo '<div class="row"><div class="col-sm-6"><div class="form-group"><label for="range">Range:</label><input type="text" class="form-control" name="range" id="range"></div></div>';
        echo '<div class="col-sm-6"><div class="form-group"><label for="subnet">Subnet:</label><input type="text" class="form-control" name="subnet" id="subnet"></div></div></div>';
        
        echo '<button type="submit" class="btn btn-default">Create</button></form>';
        
        echo '</div></div></div>';
        
        echo '<div class="col-lg-6"><div class="panel panel-default"><div class="panel-heading"><h3 class="panel-title"><i class="fa fa-globe fa-fw"></i> Rooms</h3></div><div class="panel-body">';
        
        $strQuery4 = "SELECT idCustomerRooms, Name FROM customerrooms WHERE CustomerSite = $site ORDER BY Name ASC;";
        $result4 = $dbhandle->query($strQuery4) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
        
        echo "<div class='table-responsive'><table class='table table-striped results'><thead><tr><th></th><th>Name</th></tr></thead><tbody>";
        
        while ($row = mysqli_fetch_array($result4)) {
            echo '<tr><td><a class="btn btn-primary btn-xs" href="entry/rooms/roomsedit.php?room=' . $row['idCustomerRooms'] . '&customer=' . $customer . '&site=' . $site . '">Edit</a></td><td>' . $row['Name'] . '</td></tr>';
        }
        echo "</tbody></table></div>";
        
        echo '<form role="form" action="' . $baseurl . 'entry/rooms/roomsnew.php" method="get">';
        echo '<input type="hidden" name="customer" value="' . $customer . '">';
        echo '<input type="hidden" name="site" value="' . $site . '">';
        
        echo '<div class="form-group"><label for="name">Name:</label><input type="text" class="form-control" name="name" id="name"></div>';
        
        echo '<button type="submit" class="btn btn-default">Create</button></form>';
        
        echo '</div></div></div></div>';
        
        echo '<div class="row"><div class="col-lg-12"><div class="panel panel-default"><div class="panel-heading"><h3 class="panel-title"><i class="fa fa-server fa-fw"></i> Devices</h3></div><div class="panel-body">';
        
        $strQuery4 = "SELECT devices.idDevices, devices.SerialNumber, devices.Hostname, customerrooms.Name, devices.Rack, devices.Unit, devices.ModelNr, manufacturers.Name AS manufacturersName, devicetypes.Description FROM devicetypes INNER JOIN ((devices INNER JOIN customerrooms ON devices.Room = customerrooms.idCustomerRooms) INNER JOIN manufacturers ON devices.Manufacturer = manufacturers.idManufacturer) ON devicetypes.idDeviceTypes = devices.DeviceType WHERE devices.CustomerSite = $site ORDER BY manufacturers.Name ASC, devices.ModelNr ASC;";
        $result4 = $dbhandle->query($strQuery4) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
        
        echo "<div class='table-responsive'><table class='table table-striped'><thead><tr><th></th><th>Hostname</th><th>Serial Number</th><th>Model Number</th><th>Manufacturer</th><th>Location</th></tr></thead><tbody>";
        
        while ($row = mysqli_fetch_array($result4)) {
            echo '<tr><td><a class="btn btn-primary btn-xs" href="entry/devices/devicesedit.php?device=' . $row['idDevices'] . '&customer=' . $customer . '&site=' . $site . '">Edit</a> &nbsp; <a class="btn btn-primary btn-xs" href="entry/devices/devicesremove.php?device=' . $row['idDevices'] . '&customer=' . $customer . '&site=' . $site . '">Remove</a></td><td>' . $row['Hostname'] . '</td><td>' . $row['SerialNumber'] . '</td><td>' . $row['ModelNr'] . '</td><td>' . $row['manufacturersName'] . '</td><td>' . $row['Name'] . ' R ' . $row['Rack'] . ' U ' . $row['Unit'] . '</td></tr>';
        }
        echo "</tbody></table></div>";
        
        echo '<form role="form" action="' . $baseurl . 'entry/devices/devicesnew.php" method="get">';
        echo '<input type="hidden" name="customer" value="' . $customer . '">';
        echo '<input type="hidden" name="site" value="' . $site . '">';
        
        echo '<div class="form-group"><label for="manufacturer">Select a Manufacturer:</label>';
        echo '<select name="manufacturer" class="form-control" id="manufacturer">';
        $strQuery = "SELECT idManufacturer, Name FROM manufacturers;";
        $result = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
        while ($row = mysqli_fetch_array($result)) {
            echo '<option value="' . $row['idManufacturer'] . '"';
            echo '>' . $row['Name'] . '</option>';
        }
        echo '</select></div>';
        
        echo '<div class="form-group"><label for="devicetype">Select a device type:</label>';
        echo '<select name="devicetype" class="form-control" id="devicetype">';
        echo '<option value="0">All</option>';
        $strQuery = "SELECT idDeviceTypes, Description FROM devicetypes;";
        $result = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
        while ($row = mysqli_fetch_array($result)) {
            echo '<option value="' . $row['idDeviceTypes'] . '"';
            echo '>' . $row['Description'] . '</option>';
        }
        echo '</select></div>';
        
        echo '<button type="submit" class="btn btn-default">Next step</button></form>';
        
        echo '</div></div></div></div>';
    }
}
include("../includes/php/bottom.php");
?>