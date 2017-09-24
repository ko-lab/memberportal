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
      <li class="active">
        <i class="fa fa-sticky-note"></i> Herineringen
      </li>
    </ol>
  </div>
</div>
<?php

echo "<div class='table-responsive'><table class='table table-striped'><thead><tr><th></th><th>Titel</th><th>Text</th><th>aanmaak datum</th></tr></thead><tbody>";

$strQuery1 = "SELECT idreminders, title, text, creationtime FROM reminders WHERE username = '" . $username . "';";
$result1 = $dbhandle->query($strQuery1) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
while ($row = mysqli_fetch_array($result1)) {
    
    echo '<tr><td><a class="btn btn-primary btn-xs" href="reminders/remindersedit.php?reminder=' . $row['idreminders'] . '">Bewerk</a> &nbsp; <a class="btn btn-primary btn-xs" href="reminders/remindersdelete.php?reminder=' . $row['idreminders'] . '">Verwijder</a></td><td>' . $row['title'] . '</td><td>' . $row['text'] . '</td><td>' . $row['creationtime'] . '</td></tr>';
    
}
echo "</tbody></table>";

echo '<form role="form" action="' . $baseurl . 'reminders/remindersnew.php" method="get">';
echo '<div class="form-group"><label for="title">Titel:</label>';
echo '<input type="text" class="form-control" name="title" id="title"></div>';
echo '<div class="form-group"><label for="text">Text:</label><textarea class="form-control" rows="5" name="text" id="text"></textarea></div>';
echo '<button type="submit" class="btn btn-default">Aanmaken</button></form>';

echo"</div>";

include("../includes/php/bottom.php");
?>