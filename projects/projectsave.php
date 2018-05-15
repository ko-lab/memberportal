<?php
include("../includes/php/top.php");
include("../includes/php/mysqli.php");

$project=$_GET["project"];
$text=$_GET["text"];

$project = mysqli_real_escape_string($dbhandle , $project );
$text = mysqli_real_escape_string($dbhandle , $text );

if ($project==NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'projects/projects.php">';
    exit;
}
if ($text==NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'projects/projects.php">';
    exit;
}

$strQuery2 = "INSERT INTO `projectupdates` (`project`, `text`) VALUES ('" . $project . "', '" . $text . "');";
$result2 = $dbhandle->query($strQuery2) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
echo '<p>Update added</p>';
echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'projects/project.php?project=' . $project . '">';

include("../includes/php/bottom.php");
?>