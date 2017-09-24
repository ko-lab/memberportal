<?php
include("../../includes/php/top.php");
include("../../includes/php/mysqli.php");

$customer    = $_GET["customer"];
$site        = $_GET["site"];
$name        = $_GET["name"];

// escape stings

$site        = mysqli_real_escape_string($dbhandle, $site);
$name        = mysqli_real_escape_string($dbhandle, $name);

if ($site == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/entry.php">';
    exit;
}
if ($name == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/entry.php?customer=' . $customer . '&site=' . $site . '">';
    exit;
}

$strQuery2 = "INSERT INTO `customerrooms` (`CustomerSite`, `Name`) VALUES ('" . $site . "', '" . $name . "');";
$result2 = $dbhandle->query($strQuery2) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
echo '<p>Room created</p>';
echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'entry/entry.php?customer=' . $customer . '&site=' . $site . '">';

include("../../includes/php/bottom.php");
?>