<?php

//todo edit en delete knop/pagina

include("../includes/php/top.php");
include("../includes/php/mysqli.php");

?>
<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">Projecten</h1>
    <ol class="breadcrumb">
      <li>
        <i class="fa fa-home"></i> Home
      </li>
      <li class="active">
        <i class="fa fa-code-fork"></i> Projecten
      </li>
    </ol>
  </div>
</div>
<?php

echo "<div class='table-responsive'><table class='table table-striped'><thead><tr><th></th><th>Titel</th><th>Omschrijving</th></tr></thead><tbody>";

$strQuery1 = "SELECT idprojects, name, description FROM projects;";
$result1 = $dbhandle->query($strQuery1) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
while ($row = mysqli_fetch_array($result1)) {
    
    echo '<tr><td><a class="btn btn-primary btn-xs" href="projects/projectsedit.php?reminder=' . $row['idprojects'] . '">Bewerk</a></td><td>' . $row['name'] . '</td><td>' . $row['description'] . '</td></tr>';
    
}
echo "</tbody></table>";

echo '<form role="form" action="' . $baseurl . 'projects/projectsnew.php" method="get">';
echo '<div class="form-group"><label for="name">Titel:</label>';
echo '<input type="text" class="form-control" name="name" id="name"></div>';
echo '<div class="form-group"><label for="description">Omschrijving:</label>';
echo '<input type="text" class="form-control" name="description" id="description"></div>';
echo '<button type="submit" class="btn btn-default">Aanmaken</button></form>';

echo"</div>";

include("../includes/php/bottom.php");
?>