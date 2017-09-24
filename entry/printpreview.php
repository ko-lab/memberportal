<?php

$print=1;

// include files

include("../includes/php/top.php");
include("../includes/php/mysqli.php");

// get variables

$customer = $_GET["customer"];
$site     = $_GET["site"];

// escape stings

$customer = mysqli_real_escape_string($dbhandle, $customer);
$leerling = mysqli_real_escape_string($dbhandle, $leerling);

$strQuery = "SELECT CustomerName FROM customers WHERE idCustomers = $customer;";
$result = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
$response = mysqli_fetch_array($result);
$CustomerName = $response[CustomerName];

?>
<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">Print preview</h1>
    <ol class="breadcrumb">
      <li>
        <i class="fa fa-home"></i> Home
      </li>
      <li>
        <i class="fa fa-user"></i> <?php echo $CustomerName; ?>
      </li>
      <li class="active">
        <i class="fa fa-print"></i> Print preview
      </li>
    </ol>
  </div>
</div>
<?php

if (!$customer == NULL) {
    if (!$site == NULL) {
        
        echo '<h1>Index</h1>';
        
        echo '<p>1. Vlans<br>2. Rooms<br>3. Devices<br>3.1  Devices details<br>4. Diagram</p>';
        
        echo '<h2>Vlans</h2>';
        
        $strQuery4 = "SELECT idCustomerSitesVlans, Vlan, Description, `Range`, Subnet FROM customersitesvlans WHERE CustomerSite = $site ORDER BY VLan ASC;";
        $result4 = $dbhandle->query($strQuery4) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
        
        echo "<div class='table-responsive'><table class='table table-striped results'><thead><tr><th></th><th>Description</th><th>Range</th></tr></thead><tbody>";
        
        while ($row = mysqli_fetch_array($result4)) {
            echo '<tr></td><td>' . $row['Vlan'] . '</td><td>' . $row['Description'] . '</td><td>' . $row['Range'] . '/' . $row['Subnet'] . '</td></tr>';
        }
        echo "</tbody></table></div>";
        
        echo '<h2>Rooms</h2>';
        
        $strQuery4 = "SELECT idCustomerRooms, Name FROM customerrooms WHERE CustomerSite = $site ORDER BY Name ASC;";
        $result4 = $dbhandle->query($strQuery4) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
        
        echo "<div class='table-responsive'><table class='table table-striped results'><thead><tr><th>Name</th></tr></thead><tbody>";
        
        while ($row = mysqli_fetch_array($result4)) {
            echo '<tr><td>' . $row['Name'] . '</td></tr>';
        }
        echo "</tbody></table></div>";
        
        echo '<h2>Devices</h2>';
        
        $strQuery4 = "SELECT devices.idDevices, devices.Hostname, devices.SerialNumber, customerrooms.Name, devices.Rack, devices.Unit, devices.ModelNr, manufacturers.Name AS manufacturersName FROM manufacturers INNER JOIN (devices INNER JOIN customerrooms ON devices.Room = customerrooms.idCustomerRooms) ON manufacturers.idManufacturer = devices.Manufacturer WHERE devices.CustomerSite = $site ORDER BY manufacturers.Name ASC, devices.ModelNr ASC;";
        $result4 = $dbhandle->query($strQuery4) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
        
        echo "<div class='table-responsive'><table class='table table-striped'><thead><tr><th>Hostname</th><th>Serial Number</th><th>Model Number</th><th>Manufacturer</th><th>Location</th></tr></thead><tbody>";
        
        while ($row = mysqli_fetch_array($result4)) {
            
            echo '<tr><td>' . $row['Hostname'] . '</td><td>' . $row['SerialNumber'] . '</td><td>' . $row['ModelNr'] . '</td><td>' . $row['manufacturersName'] . '</td><td>' . $row['Name'];
            
            if (!$row['Rack']==NULL) {
                
                echo ' R ' . $row['Rack'];
                
            }
            
            if (!$row['Unit']==NULL) {
                
                echo ' U ' . $row['Unit'];
                
            }
            
            echo '</td></tr>';
            
        }
        echo "</tbody></table></div>";
        
        echo '<h2>Devices details</h2>';
        
        $strQuery4 = "SELECT devices.idDevices, devices.Hostname, devices.SerialNumber, customerrooms.Name, devices.Rack, devices.Unit, devices.ModelNr, manufacturers.Name AS manufacturersName, devices.Notes FROM manufacturers INNER JOIN (devices INNER JOIN customerrooms ON devices.Room = customerrooms.idCustomerRooms) ON manufacturers.idManufacturer = devices.Manufacturer WHERE devices.CustomerSite = $site ORDER BY manufacturers.Name ASC, devices.ModelNr ASC;";
        $result4 = $dbhandle->query($strQuery4) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
        
        while ($row = mysqli_fetch_array($result4)) {
            
            $idDevices = $row['idDevices'];
            
            echo '<div class="well"><h3>' . $row['Hostname'] . '</h3>';
            
            echo "<div class='table-responsive'><table class='table table-striped'>";
            
            echo '<tr><td>Model number</td><td>' . $row['ModelNr'] . '</td></tr>';
            echo '<tr><td>Manufacturer</td><td>' . $row['manufacturersName'] . '</td></tr>';
            
            if (!$row['SerialNumber']==NULL) {
                
                echo '<tr><td>Serial number</td><td>' . $row['SerialNumber'] . '</td></tr>';
                
            }
            
            echo '<tr><td>Room</td><td>' . $row['Name'] . '</td></tr>';
            
            if (!$row['Rack']==NULL) {
                
                echo '<tr><td>Rack</td><td>' . $row['Rack'] . '</td></tr>';
                
            }
            
            if (!$row['Unit']==NULL) {
                
                echo '<tr><td>Unit</td><td>' . $row['Unit'] . '</td></tr>';
                
            }
            
            echo "</table></div>";
            
            if (!$row['Notes']==NULL) {
                
                echo '<h4>Notes</h4><div>' . $row['Notes'] . '</div>';
                
            }
            
            $strQuery5 = "SELECT Adress, Note, CustomerSitesVlan FROM customerdevicesipadresses WHERE Device = " . $idDevices . " ORDER BY CustomerSitesVlan ASC;";
            $result5 = $dbhandle->query($strQuery5) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
            $response5 = mysqli_fetch_array($result5);
            
            if (!$response5==NULL) {
                echo '<h4>IP Adresses</h4>';
                
                $strQuery5 = "SELECT Adress, Note, CustomerSitesVlan FROM customerdevicesipadresses WHERE Device = " . $row['idDevices'] . " ORDER BY CustomerSitesVlan ASC;";
                $result5 = $dbhandle->query($strQuery5) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
                
                echo "<div class='table-responsive'><table class='table table-striped'><thead><tr><th>IP adress</th><th>Note</th><th>Vlan</th></tr></thead><tbody>";
                
                while ($row = mysqli_fetch_array($result5)) {
                    
                    echo '<tr><td>' . $row['Adress'] . '</td><td>' . $row['Note'] . '</td><td>' . $row['CustomerSitesVlan'] . '</td></tr>';
                    
                }
                
                echo "</tbody></table></div>";
                
            }
            
            $strQuery5 = "SELECT devicesservices.idDevicesServices, services.Name, services.Port FROM devicesservices INNER JOIN services ON devicesservices.Service = services.idServices  WHERE devicesservices.Device = " . $idDevices . " ORDER BY services.Port ASC;";
            $result5 = $dbhandle->query($strQuery5) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
            $response5 = mysqli_fetch_array($result5);
            
            if (!$response5==NULL) {
                echo '<h4>Services</h4>';
                echo "<div class='table-responsive'><table class='table table-striped'><thead><tr><th>Service</th><th>Port</th></tr></thead><tbody>";
                
                $strQuery5 = "SELECT devicesservices.idDevicesServices, services.Name, services.Port FROM devicesservices INNER JOIN services ON devicesservices.Service = services.idServices  WHERE devicesservices.Device = " . $idDevices . " ORDER BY services.Port ASC;";
                $result5 = $dbhandle->query($strQuery5) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
                
                while ($row = mysqli_fetch_array($result5)) {
                    
                    echo '<tr><td>' . $row['Name'] . '</td><td>' . $row['Port'] . '</td><td>' . $row['CustomerSitesVlan'] . '</td></tr>';
                    
                }
                
                echo "</tbody></table></div>";
                
            }
            echo '</div>';
             
        }
        echo '<h2>Graph</h2>';
        
        echo '<div id="graphviz_svg_div"></div>';
        
        echo "<input type='hidden' id='graphviz_data' value='";
        
        echo 'digraph G {
 ratio=auto;
';
        
        $strQuery4 = "SELECT devices.idDevices, devices.SerialNumber, customerrooms.Name, devices.Rack, devices.Unit, devices.ModelNr, manufacturers.Name AS manufacturersName, devicetypes.graphvizStyle, devices.Hostname FROM devicetypes INNER JOIN (manufacturers INNER JOIN (devices INNER JOIN customerrooms ON devices.Room = customerrooms.idCustomerRooms) ON manufacturers.idManufacturer = devices.Manufacturer) ON devicetypes.idDeviceTypes = devices.DeviceType WHERE devices.CustomerSite = $site;";
        $result4 = $dbhandle->query($strQuery4) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
        
        while ($row = mysqli_fetch_array($result4)) {
            echo ' "' . $row['idDevices'] . '" [ label="' . $row['Hostname'] . '\nModel: ' . $row['ModelNr'] . '\nS#: ' . $row['SerialNumber'] . '\nManufacturer: ' . $row['manufacturersName'] . '\nRoom: ' . $row['Name'] . ' ' . $row['Rack'] . ' ' . $row['Unit'] . '",';
            
            if (!$row['ModelNr']==NULL) {
                echo $row['graphvizStyle'];
            } else {
                echo 'shape="hexagon",style="filled",color="red"';
            }
            echo ' ];
';
        }
        
        $strQuery4 = "SELECT portconnectionsvlans.CustomerSitesVlan, devices.idDevices AS idDevices1, devices_1.idDevices AS idDevices2 FROM (devices INNER JOIN ((devicesports INNER JOIN (portconnections INNER JOIN devicesports AS devicesports_1 ON portconnections.DevicesPort1 = devicesports_1.idDevicesPorts) ON devicesports.idDevicesPorts = portconnections.DevicesPort) INNER JOIN devices AS devices_1 ON devicesports_1.Device = devices_1.idDevices) ON devices.idDevices = devicesports.Device) INNER JOIN portconnectionsvlans ON portconnections.idPortConnections = portconnectionsvlans.PortConnection WHERE devices.CustomerSite = $site";
        $result4 = $dbhandle->query($strQuery4) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
        
        while ($row = mysqli_fetch_array($result4)) {
            echo ' "' . $row['idDevices1'] . '" -> "' . $row['idDevices2'] . '" [ label=" ",color="blue",arrowhead="none" ];
';
        }
        
        echo "}
        
'>";
        echo '<script language="javascript" type="text/javascript" src="includes/js/gviz/viz.js"></script><script language="javascript" type="text/javascript" src="includes/js/gviz/site.js"> </script>';
        
    }
}
include("../includes/php/bottom.php");
?>