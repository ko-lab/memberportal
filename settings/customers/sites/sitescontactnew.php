<?php
include("../../../includes/php/top.php");
include("../../../includes/php/mysqli.php");

$site        = $_GET["site"];
$customer        = $_GET["customer"];
$contact     = $_GET["contact"];

// escape stings

$site        = mysqli_real_escape_string($dbhandle, $site);
$contact     = mysqli_real_escape_string($dbhandle, $contact);

if ($site == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'settings/contacts/contacts.php">';
    exit;
}
if ($contact == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'settings/contacts/contacts.php">';
    exit;
}

$strQuery2 = "INSERT INTO `customersitescontacts` (`CustomerContact`, `CustomerSite`) VALUES ('" . $contact . "', '" . $site . "');";
$result2 = $dbhandle->query($strQuery2) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
echo '<p>Contact Added</p>';
echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'settings/customers/sites/sitesedit.php?site=' . $site . '&customer=' . $customer . '">';

include("../../../includes/php/bottom.php");
?>