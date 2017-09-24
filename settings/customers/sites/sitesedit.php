<?php
include("../../../includes/php/top.php");
include("../../../includes/php/mysqli.php");

$site = $_GET["site"];
$customer = $_GET["customer"];

// escape stings

$site     = mysqli_real_escape_string($dbhandle, $site);
$customer = mysqli_real_escape_string($dbhandle, $customer);

if ($site == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'settings/customers/customers.php">';
    exit;
}

$strQuery1 = "SELECT CustomerName FROM customers WHERE idCustomers = $customer;";
$result1 = $dbhandle->query($strQuery1) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
$response1  = mysqli_fetch_array($result1);
$CustomerName   = $response1[CustomerName];

$strQuery2 = "SELECT Street, Number, City, ZIP FROM customersites WHERE idCustomerSites = $site;";
$result2 = $dbhandle->query($strQuery2) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
$response2  = mysqli_fetch_array($result2);
$Number   = $response2[Number];
$City   = $response2[City];
$Street   = $response2[Street];
$ZIP   = $response2[ZIP];

?>
<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">Customer site edit</h1>
    <ol class="breadcrumb">
      <li>
        <i class="fa fa-home"></i> Home
      </li>
	  <li>
        <i class="fa fa-gear"></i> Settings
      </li>
	  <li>
        <i class="fa fa-user"></i> Customers
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

echo '<div class="well"><h3>CONTACTS</h3>';

echo "<div class='table-responsive'><table class='table table-striped'><thead><tr><th></th><th>Name</th></tr></thead><tbody>";

$strQuery1 = "SELECT customersitescontacts.idCustomerSitesContacts, customercontacts.FirstName, customercontacts.LastName FROM customersitescontacts INNER JOIN customercontacts ON customersitescontacts.CustomerContact = customercontacts.idCustomerContact WHERE customersitescontacts.CustomerSite = $site ORDER BY customercontacts.FirstName ASC, customercontacts.LastName ASC;";
$result1 = $dbhandle->query($strQuery1) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
while ($row = mysqli_fetch_array($result1)) {
    echo '<tr><td><a class="btn btn-primary btn-xs" href="settings/customers/sites/sitescontactremove.php?contact=' . $row['idCustomerSitesContacts'] . '&customer=' . $customer . '&site=' . $site . '">Remove</a></td><td>' . $row['FirstName'] . ' ' . $row['LastName'] . '</td></tr>';
}
echo "</tbody></table></div>";

echo '<form role="form" action="' . $baseurl . 'settings/customers/sites/sitescontactnew.php" method="get">';
echo '<input type="hidden" name="site" value="' . $site . '">';
echo '<input type="hidden" name="customer" value="' . $customer . '">';

$strQuery = "SELECT idCustomerContact, FirstName, LastName FROM customercontacts WHERE Customer = $customer ORDER BY FirstName ASC, LastName ASC;";
$result = $dbhandle->query($strQuery) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");

echo '<div class="form-group"><label for="contact">Contact:</label><select name="contact" class="form-control" id="contact">';
while ($row = mysqli_fetch_array($result)) {
    echo '<option value="' . $row['idCustomerContact'] . '"';
    echo '>' . $row['FirstName'] . ' ' . $row['LastName'] . '</option>';
}
echo '</select></div>';

echo '<button type="submit" class="btn btn-default">Add</button></form>';

echo '</div>';

echo '<form role="form" action="' . $baseurl . 'settings/customers/sites/siteseditsave.php" method="get">';
echo '<input type="hidden" name="site" value="' . $site . '">';
echo '<input type="hidden" name="customer" value="' . $customer . '">';

echo '<div class="form-group"><label for="street">Street:</label><input type="text" class="form-control" name="street" id="street" value="' . $Street . '"></div>';
echo '<div class="form-group"><label for="nr">House number:</label><input type="text" class="form-control" name="nr" id="nr" value="' . $Number . '"></div>';
echo '<div class="form-group"><label for="zip">ZIP:</label><input type="text" class="form-control" name="zip" id="zip" value="' . $ZIP . '"></div>';
echo '<div class="form-group"><label for="city">City:</label><input type="text" class="form-control" name="city" id="city" value="' . $City . '"></div>';

echo '<button type="submit" class="btn btn-default">Change</button></form>';

echo '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';

include("../../../includes/php/bottom.php");
?>