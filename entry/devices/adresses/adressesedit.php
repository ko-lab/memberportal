<?php
include("../../../includes/php/top.php");
include("../../../includes/php/mysqli.php");

$adress   = $_GET["adress"];
$customer = $_GET["customer"];
$site     = $_GET["site"];
$device   = $_GET["device"];

// escape stings

$adress = mysqli_real_escape_string($dbhandle, $adress);
$site   = mysqli_real_escape_string($dbhandle, $site);
$device   = mysqli_real_escape_string($dbhandle, $device);
$customer   = mysqli_real_escape_string($dbhandle, $customer);


if ($adress == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/entry.php">';
    exit;
}

$strQuery2 = "SELECT Adress, Note, CustomerSitesVlan FROM customerdevicesipadresses WHERE idCustomerDevicesIpAdresses = $adress;";
$result2 = $dbhandle->query($strQuery2) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
$response2         = mysqli_fetch_array($result2);
$Adress            = $response2[Adress];
$Note              = $response2[Note];
$CustomerSitesVlan = $response2[CustomerSitesVlan];

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

?>
<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header"><?php echo $Adress; ?> <small><?php echo $CustomerName . ' ' . $Street . ' ' . $Number . ' ' . $ZIP . ' ' . $City . ' ' . $bcModelNr . ' ' . $bcSerialNumber; ?></small></h1>
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
        <i class="fa fa-plug"></i> <?php echo $Adress; ?>
      </li>
    </ol>
  </div>
</div>
<?php

echo '<form role="form" action="' . $baseurl . 'entry/devices/adresses/adresseseditsave.php" method="get">';
echo '<input type="hidden" name="customer" value="' . $customer . '">';
echo '<input type="hidden" name="site" value="' . $site . '">';
echo '<input type="hidden" name="device" value="' . $device . '">';
echo '<input type="hidden" name="adress" value="' . $adress . '">';

echo '<div class="form-group"><label for="ipadress">Adress:</label><input type="text" class="form-control" name="ipadress" id="ipadress" value="' . $Adress . '"></div>';
echo '<div class="form-group"><label for="note">Note:</label><input type="text" class="form-control" name="note" id="note" value="' . $Note . '"></div>';

echo '<div class="form-group"><label for="vlan">Select a vlan:</label>';
echo '<select name="vlan" class="form-control" id="vlan">';
$strQuery = "SELECT idCustomerSitesVlans, Vlan, Description, `Range`, Subnet FROM customersitesvlans WHERE CustomerSite =$site ORDER BY Vlan ASC;";
$result = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
while ($row = mysqli_fetch_array($result)) {
    echo '<option value="' . $row['idCustomerSitesVlans'] . '"';
        if ($row['idCustomerSitesVlans'] == $CustomerSitesVlan) {
            echo ' selected';
        }
        echo '>' . $row['Vlan'] . ' ' . $row['Description'] . ' ' . $row['Range'] . ' / ' . $row['Subnet'] . '</option>';
}
echo '</select></div>';

echo '<button type="submit" class="btn btn-default">Change</button></form>';

include("../../../includes/php/bottom.php");
?>