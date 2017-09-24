<?php
include("../../../includes/php/top.php");
include("../../../includes/php/mysqli.php");

$contact        = $_GET["contact"];
$site      = $_GET["site"];
$customer      = $_GET["customer"];

// escape stings

$contact        = mysqli_real_escape_string($dbhandle, $contact);

if ($contact == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'settings/customers/customers.php">';
    exit;
}

$strQuery2 = "DELETE FROM `customersitescontacts` WHERE `idCustomerSitesContacts`='" . $contact . "';";
$result2 = $dbhandle->query($strQuery2) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
echo '<p>Contact removed</p>';
echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'settings/customers/sites/sitesedit.php?site=' . $site . '&customer=' . $customer . '">';

include("../../../includes/php/bottom.php");
?>