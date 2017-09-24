<?php
include("../../../includes/php/top.php");
include("../../../includes/php/mysqli.php");

$customer   = $_GET["customer"];
$contact   = $_GET["contact"];
$firstname   = $_GET["firstname"];
$lastname   = $_GET["lastname"];
$email   = $_GET["email"];
$phone   = $_GET["phone"];
$mobile   = $_GET["mobile"];

// escape stings

$customer   = mysqli_real_escape_string($dbhandle, $customer);
$firstname   = mysqli_real_escape_string($dbhandle, $firstname);
$lastname   = mysqli_real_escape_string($dbhandle, $lastname);
$email   = mysqli_real_escape_string($dbhandle, $email);
$phone   = mysqli_real_escape_string($dbhandle, $phone);
$mobile   = mysqli_real_escape_string($dbhandle, $mobile);

if ($customer == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'settings/customers/customers.php">';
    exit;
}

$strQuery2 = "UPDATE `customercontacts` SET `FirstName`='" . $firstname . "', `LastName`='" . $lastname . "', `Email`='" . $email . "', `Phone`='" . $phone . "', `Mobile`='" . $mobile . "' WHERE `idCustomerContact`='" . $contact . "';";
$result2 = $dbhandle->query($strQuery2) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");

echo '<p>Customer changed</p>';
echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'settings/customers/customersedit.php?customer=' . $customer .'">';

include("../../../includes/php/bottom.php");
?>