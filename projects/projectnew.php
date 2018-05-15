<?php
include("../includes/php/top.php");
include("../includes/php/mysqli.php");

$name        = $_GET["name"];
$description = $_GET["description"];

// escape stings

$name        = mysqli_real_escape_string($dbhandle, $name);
$description = mysqli_real_escape_string($dbhandle, $description);

if ($name        == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'projects/projects.php">';
    exit;
}
if ($description == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'projects/projects.php">';
    exit;
}

$strQuery2 = "INSERT INTO `kolabportal`.`projects` (`name`, `description`) VALUES ('" . $name . "', '" . $description . "');";
$result2 = $dbhandle->query($strQuery2) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
echo '<p>Project added</p>';
echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'projects/projects.php">';

include("../includes/php/bottom.php");
?>