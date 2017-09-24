<?php
include("../../includes/php/top.php");
include("../../includes/php/mysqli.php");

$vlan     = $_GET["vlan"];
$customer = $_GET["customer"];
$site     = $_GET["site"];

// escape stings

$vlan = mysqli_real_escape_string($dbhandle, $vlan);
$customer = mysqli_real_escape_string($dbhandle, $customer);
$site = mysqli_real_escape_string($dbhandle, $site);

if ($vlan == NULL) {
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

$strQuery2 = "SELECT Vlan, Description, `Range`, Subnet FROM customersitesvlans WHERE idCustomerSitesVlans = $vlan;";
$result2 = $dbhandle->query($strQuery2) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
$response2 = mysqli_fetch_array($result2);
$Vlan      = $response2[Vlan];
$Description      = $response2[Description];
$Range      = $response2[Range];
$Subnet      = $response2[Subnet];

?>
<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header"><?php echo $Vlan . ' ' . $Description; ?> <small><?php echo $CustomerName . ' ' . $Street . ' ' . $Number . ' ' . $ZIP . ' ' . $City; ?></small></h1>
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
        <i class="fa fa-plug"></i> <?php echo $Vlan . ' ' . $Description; ?>
      </li>
    </ol>
  </div>
</div>
<?php

echo '<form role="form" action="' . $baseurl . 'entry/vlans/vlanseditsave.php" method="get">';
echo '<input type="hidden" name="customer" value="' . $customer . '">';
echo '<input type="hidden" name="site" value="' . $site . '">';
echo '<input type="hidden" name="vlan" value="' . $vlan . '">';

echo '<div class="form-group"><label for="vlanid">Select a vlan:</label>';
echo '<select name="vlanid" class="form-control" id="vlanid">';
$strQuery = "SELECT idVlans FROM vlans;";
$result = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
while ($row = mysqli_fetch_array($result)) {
    echo '<option value="' . $row['idVlans'] . '"';
    echo '>' . $row['idVlans'] . '</option>';
}
echo '</select></div>';
echo '<div class="form-group"><label for="description">Description:</label><input type="text" class="form-control" name="description" id="description" value="' . $Description . '"></div>';
echo '<div class="form-group"><label for="range">Range:</label><input type="text" class="form-control" name="range" id="range" value="' . $Range . '"></div>';
echo '<div class="form-group"><label for="subnet">Subnet:</label><input type="text" class="form-control" name="subnet" id="subnet" value="' . $Subnet . '"></div>';

echo '<button type="submit" class="btn btn-default">Change</button></form>';

include("../../includes/php/bottom.php");
?>