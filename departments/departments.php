<?php

// todo: openen pagina met alle gegevens.

include("../includes/php/top.php");
include("../includes/php/mysqli.php");

?>
<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">Afdelingen</h1>
    <ol class="breadcrumb">
      <li>
        <i class="fa fa-home"></i> Home
      </li>
      <li class="active">
        <i class="fa fa-fighter-jet"></i> Afdelingen
      </li>
    </ol>
  </div>
</div>
<?php

echo "<div class='table-responsive'><table class='table table-striped'><thead><tr><th></th><th>Naam</th><th>Omschrijving</th></tr></thead><tbody>";

$strQuery1 = "SELECT iddepartments, name, description FROM departments";
$result1 = $dbhandle->query($strQuery1) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
while ($row = mysqli_fetch_array($result1)) {
    
    echo '<tr><td><a class="btn btn-primary btn-xs" href="departments/department.php?department=' . $row['iddepartments'] . '">Bekijk</a></td><td>' . $row['name'] . '</td><td>' . $row['description'] . '</td></tr>';
    
}
echo "</tbody></table></div>";

include("../includes/php/bottom.php");
?>