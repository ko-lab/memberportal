<?php
include("../../includes/php/top.php");
include("../../includes/php/mysqli.php");

$customer = $_GET["customer"];

// escape stings

$customer = mysqli_real_escape_string($dbhandle, $customer);

if ($customer == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'settings/customers/customers.php">';
    exit;
}

$strQuery2 = "SELECT CustomerName FROM customers WHERE idCustomers = $customer;";
$result2 = $dbhandle->query($strQuery2) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
$response2  = mysqli_fetch_array($result2);
$CustomerName   = $response2[CustomerName];

?>
<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">Customer edit</h1>
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
	  <li class="active">
        <i class="fa fa-user"></i> <?php echo $CustomerName; ?>
      </li>
    </ol>
  </div>
</div>
<?php

echo '<h2>' . $CustomerName . '</h2>';

echo '<div class="well"><h3>SITES</h3>';

echo "<div class='table-responsive'><table class='table table-striped'><thead><tr><th></th><th>Address</th></tr></thead><tbody>";

$strQuery1 = "SELECT idCustomerSites, Street, Number, City, ZIP FROM customersites WHERE Customer = $customer ORDER BY City ASC;";
$result1 = $dbhandle->query($strQuery1) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
while ($row = mysqli_fetch_array($result1)) {
    echo '<tr><td><a class="btn btn-primary btn-xs" href="settings/customers/sites/sitesedit.php?site=' . $row['idCustomerSites'] . '&customer=' . $customer . '">Edit</a></td><td>' . $row['Street'] . ' ' . $row['Number'] . ' ' . $row['ZIP'] . ' ' . $row['City'] . '</td></tr>';
}
echo "</tbody></table></div>";

echo '<form role="form" action="' . $baseurl . 'settings/customers/sites/sitesnew.php" method="get">';
echo '<input type="hidden" name="customer" value="' . $customer . '">';

echo '<div class="form-group"><label for="street">Street:</label><input type="text" class="form-control" name="street" id="street"></div>';
echo '<div class="form-group"><label for="nr">House number:</label><input type="text" class="form-control" name="nr" id="nr"></div>';
echo '<div class="form-group"><label for="zip">ZIP:</label><input type="text" class="form-control" name="zip" id="zip"></div>';
echo '<div class="form-group"><label for="city">City:</label><input type="text" class="form-control" name="city" id="city"></div>';

echo '<button type="submit" class="btn btn-default">Create</button></form>';

echo '</div>';

echo '<div class="well"><h3>CONTACTS</h3>';

echo "<div class='table-responsive'><table class='table table-striped'><thead><tr><th></th><th>Name</th><th>Email</th><th>Phone</th><th>Mobile</th></tr></thead><tbody>";

$strQuery3 = "SELECT idCustomerContact, FirstName, LastName, Email, Phone, Mobile FROM customercontacts WHERE Customer = $customer ORDER BY FirstName ASC, LastName ASC;";
$result3 = $dbhandle->query($strQuery3) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
while ($row = mysqli_fetch_array($result3)) {
    echo '<tr><td><a class="btn btn-primary btn-xs" href="settings/customers/contacts/contactsedit.php?contact=' . $row['idCustomerContact'] . '&customer=' . $customer . '">Edit</a></td><td>' . $row['FirstName'] . ' ' . $row['LastName'] . '</td><td>' . $row['Email'] . '</td><td>' . $row['Phone'] . '</td><td>' . $row['Mobile'] . '</td></tr>';
}
echo "</tbody></table></div>";

echo '<form role="form" action="' . $baseurl . 'settings/customers/contacts/contactsnew.php" method="get">';
echo '<input type="hidden" name="customer" value="' . $customer . '">';

echo '<div class="form-group"><label for="firstname">FirstName:</label><input type="text" class="form-control" name="firstname" id="firstname"></div>';
echo '<div class="form-group"><label for="lastname">LastName:</label><input type="text" class="form-control" name="lastname" id="lastname"></div>';
echo '<div class="form-group"><label for="email">Email:</label><input type="text" class="form-control" name="email" id="email"></div>';
echo '<div class="form-group"><label for="phone">Phone:</label><input type="text" class="form-control" name="phone" id="phone"></div>';
echo '<div class="form-group"><label for="mobile">Mobile:</label><input type="text" class="form-control" name="mobile" id="mobile"></div>';

echo '<button type="submit" class="btn btn-default">Create</button></form>';

echo '</div>';

echo '<form role="form" action="' . $baseurl . 'settings/customers/customerseditsave.php" method="get">';
echo '<input type="hidden" name="customer" value="' . $customer . '">';

echo '<div class="form-group"><label for="name">Name:</label><input type="text" class="form-control" name="name" id="name" value="' . $CustomerName . '"></div>';

echo '<button type="submit" class="btn btn-default">Change</button></form>';

include("../../includes/php/bottom.php");
?>