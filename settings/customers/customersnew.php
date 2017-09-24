<?php
include("../../includes/php/top.php");
include("../../includes/php/mysqli.php");

$name        = $_GET["name"];

// escape stings

$name        = mysqli_real_escape_string($dbhandle, $name);

if ($name == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'settings/customers/customers.php">';
    exit;
}

$strQuery2 = "INSERT INTO `customers` (`CustomerName`) VALUES ('" . $name . "');";
$result2 = $dbhandle->query($strQuery2) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
echo '<p>Customer created</p>';
echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'settings/customers/customers.php">';

include("../../includes/php/bottom.php");
?>