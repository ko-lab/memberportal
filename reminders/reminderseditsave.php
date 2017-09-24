<?php
include("../includes/php/top.php");
include("../includes/php/mysqli.php");

$reminder=$_GET["reminder"];
$title=$_GET["title"];
$text=$_GET["text"];


$reminder = mysqli_real_escape_string($dbhandle , $reminder );
$title = mysqli_real_escape_string($dbhandle , $title );
$text = mysqli_real_escape_string($dbhandle , $text );

if ($reminder==NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'reminders/reminders.php">';
    exit;
}
if ($title==NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'reminders/reminders.php">';
    exit;
}
if ($text==NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'reminders/reminders.php">';
    exit;
}

$strQuery2 = "UPDATE `reminders` SET `title`='".$title."', `text`='".$text."' WHERE `idreminders`='".$reminder."' AND username = '" . $username . "';";
$result2 = $dbhandle->query($strQuery2) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
echo '<p>Herinering aangepast</p>';
echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'reminders/reminders.php">';

include("../includes/php/bottom.php");
?>