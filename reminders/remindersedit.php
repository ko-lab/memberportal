<?php

//todo edit en delete knop/pagina

include("../includes/php/top.php");
include("../includes/php/mysqli.php");

?>
<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">Herineringen</h1>
    <ol class="breadcrumb">
      <li>
        <i class="fa fa-home"></i> Home
      </li>
      <li>
        <i class="fa fa-sticky-note"></i> Herineringen
      </li>
      <li>
        <i class="fa fa-pen"></i> Herineringen bewerk
      </li>
    </ol>
  </div>
</div>
<?php

$reminder = $_GET["reminder"];

$reminder = mysqli_real_escape_string($dbhandle, $reminder);

if ($reminder == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'reminders/reminders.php">';
    exit;
}

$strQuery2 = "SELECT title, text FROM reminders WHERE idreminders = '" . $reminder . "' AND username = '" . $username . "';";
$result2 = $dbhandle->query($strQuery2) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
$response2     = mysqli_fetch_array($result2);

echo '<form role="form" action="' . $baseurl . 'reminders/reminderseditsave.php" method="get"><div class="form-group">';
echo '<input type="hidden" name="reminder" value="' . $reminder . '">';
echo '<label for="title">Titel:</label><input type="text" class="form-control" name="title" id="title" value="' . $response2[title] . '">';
echo '<div class="form-group"><label for="text">Text:</label><textarea class="form-control" rows="5" name="text" id="text">' . $response2[text] . '</textarea></div>';
echo '<button type="submit" class="btn btn-default">Aanpassen</button></form>';



include("../includes/php/bottom.php");
?>