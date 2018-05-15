<?php

//todo edit en delete knop/pagina

include("../includes/php/top.php");
include("../includes/php/mysqli.php");

?>
<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">Project</h1>
    <ol class="breadcrumb">
      <li>
        <i class="fa fa-home"></i> Home
      </li>
      <li>
        <i class="fa fa-code-fork"></i> Projecten
      </li>
      <li>
        <i class="fa fa-pen"></i> Project
      </li>
    </ol>
  </div>
</div>
<?php

$project = $_GET["project"];

$project = mysqli_real_escape_string($dbhandle, $project);

if ($project == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'projects/projects.php">';
    exit;
}

echo "<h1>Project titel</h1><p>Project omschrijving</p><div>";

$strQuery1 = "SELECT text, timestamp FROM projectupdates WHERE project = '" . $project . "';";
$result1 = $dbhandle->query($strQuery1) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
while ($row = mysqli_fetch_array($result1)) {
    
    echo '<h3>Update: ' . $row['timestamp'] . '</h3><p>' . $row['text'] . '</p>';
    
}
echo "</div>";

echo '<form role="form" action="' . $baseurl . 'projects/projectsave.php" method="get"><div class="form-group">';
echo '<input type="hidden" name="project" value="' . $project . '">';
echo '<label for="text">Update text:</label><textarea class="form-control" name="text" id="text"></textarea></div>';

echo '<button type="submit" class="btn btn-primary">Submit</button></form>';



include("../includes/php/bottom.php");
?>