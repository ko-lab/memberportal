<?php
include("../includes/php/top.php");
include("../includes/php/mysqli.php");

$title       = $_GET["title"];
$text        = $_GET["text"];

// escape stings

$title       = mysqli_real_escape_string($dbhandle, $title);
$text        = mysqli_real_escape_string($dbhandle, $text);

if ($title == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'reminders/reminders.php">';
    exit;
}
if ($text == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'reminders/reminders.php">';
    exit;
}

$strQuery2 = "INSERT INTO `reminders` (`title`,`text`,`username`) VALUES ('" . $title . "','" . $text . "','" . $username . "');";
$result2 = $dbhandle->query($strQuery2) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
echo '<p>Herinering toegevoegd</p>';
echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'reminders/reminders.php">';

include("../includes/php/bottom.php");
?>