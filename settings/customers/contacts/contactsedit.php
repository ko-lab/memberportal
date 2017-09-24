<?php
include("../../../includes/php/top.php");
include("../../../includes/php/mysqli.php");

$contact = $_GET["contact"];
$customer = $_GET["customer"];

// escape stings

$contact  = mysqli_real_escape_string($dbhandle, $contact);
$customer = mysqli_real_escape_string($dbhandle, $customer);

if ($contact == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'settings/customers/customers.php">';
    exit;
}

$strQuery1 = "SELECT CustomerName FROM customers WHERE idCustomers = $customer;";
$result1 = $dbhandle->query($strQuery1) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
$response1  = mysqli_fetch_array($result1);
$CustomerName   = $response1[CustomerName];

$strQuery2 = "SELECT FirstName, LastName, Email, Phone, Mobile FROM customercontacts WHERE idCustomerContact = $contact;";
$result2 = $dbhandle->query($strQuery2) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
$response2  = mysqli_fetch_array($result2);
$FirstName   = $response2[FirstName];
$LastName   = $response2[LastName];
$Email   = $response2[Email];
$Phone   = $response2[Phone];
$Mobile   = $response2[Mobile];

?>
<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">Customer contact edit</h1>
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
        <i class="fa fa-user"></i> <?php echo $FirstName . ' ' . $LastName; ?>
      </li>
    </ol>
  </div>
</div>
<?php

echo '<form role="form" action="' . $baseurl . 'settings/customers/contacts/contactseditsave.php" method="get">';
echo '<input type="hidden" name="contact" value="' . $contact . '">';
echo '<input type="hidden" name="customer" value="' . $customer . '">';

echo '<div class="form-group"><label for="firstname">FirstName:</label><input type="text" class="form-control" name="firstname" id="firstname" value="' . $FirstName . '"></div>';
echo '<div class="form-group"><label for="lastname">LastName:</label><input type="text" class="form-control" name="lastname" id="lastname" value="' . $LastName . '"></div>';
echo '<div class="form-group"><label for="email">Email:</label><input type="text" class="form-control" name="email" id="email" value="' . $Email . '"></div>';
echo '<div class="form-group"><label for="phone">Phone:</label><input type="text" class="form-control" name="phone" id="phone" value="' . $Phone . '"></div>';
echo '<div class="form-group"><label for="mobile">Mobile:</label><input type="text" class="form-control" name="mobile" id="mobile" value="' . $Mobile . '"></div>';

echo '<button type="submit" class="btn btn-default">Change</button></form>';

include("../../../includes/php/bottom.php");
?>