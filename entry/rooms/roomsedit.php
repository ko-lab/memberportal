<?php
include("../../includes/php/top.php");
include("../../includes/php/mysqli.php");

$room     = $_GET["room"];
$customer = $_GET["customer"];
$site     = $_GET["site"];

// escape stings

$room = mysqli_real_escape_string($dbhandle, $room);
$customer = mysqli_real_escape_string($dbhandle, $customer);
$site = mysqli_real_escape_string($dbhandle, $site);

if ($room == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/entry.php">';
    exit;
}

$strQuery2 = "SELECT Name FROM customerrooms WHERE idCustomerRooms = $room;";
$result2 = $dbhandle->query($strQuery2) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
$response2 = mysqli_fetch_array($result2);
$Name      = $response2[Name];

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

?>
<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header"><?php echo $Name; ?> <small><?php echo $CustomerName . ' ' . $Street . ' ' . $Number . ' ' . $ZIP . ' ' . $City; ?></small></h1>
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
        <i class="fa fa-globe"></i> <?php echo $Name; ?>
      </li>
    </ol>
  </div>
</div>
<?php

echo '<form role="form" action="' . $baseurl . 'entry/rooms/roomseditsave.php" method="get">';
echo '<input type="hidden" name="customer" value="' . $customer . '">';
echo '<input type="hidden" name="site" value="' . $site . '">';
echo '<input type="hidden" name="room" value="' . $room . '">';

echo '<div class="form-group"><label for="name">Name:</label><input type="text" class="form-control" name="name" id="name" value="' . $Name . '"></div>';

echo '<button type="submit" class="btn btn-default">Change</button></form>';

include("../../includes/php/bottom.php");
?>