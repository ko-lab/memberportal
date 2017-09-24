<?php
include("../../includes/php/top.php");
include("../../includes/php/mysqli.php");

$customer   = $_GET["customer"];
$name   = $_GET["name"];

// escape stings

$customer   = mysqli_real_escape_string($dbhandle, $customer);
$name   = mysqli_real_escape_string($dbhandle, $name);

if ($customer == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'settings/customers/customers.php">';
    exit;
}
if ($name == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'settings/customers/customers.php">';
    exit;
}

$strQuery2 = "UPDATE `customers` SET `CustomerName`='" . $name . "' WHERE `idCustomers`='" . $customer . "';";
$result2 = $dbhandle->query($strQuery2) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");

echo '<p>Customer changed</p>';
echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'settings/customers/customers.php">';

include("../../includes/php/bottom.php");
?>