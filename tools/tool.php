<?php

include("../includes/php/top.php");
include("../includes/php/mysqli.php");

$tool = $_GET["tool"];

if ($tool == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'tools/tools.php">';
    exit;
}

$tool = mysqli_real_escape_string($dbhandle, $tool);

$strQuery2 = "SELECT brands.name AS brandname, tools.modelnumber, tools.description, tools.manual, departments.name AS departmentname, trainings.description AS trainingdescription, trainings.fee, tools.training
FROM ((tools INNER JOIN trainings ON tools.training = trainings.idtrainings) INNER JOIN departments ON tools.department = departments.iddepartments) INNER JOIN brands ON tools.brand = brands.idbrands WHERE tools.idtools = '" . $tool . "' ORDER BY tools.idtools ;";
$result2 = $dbhandle->query($strQuery2) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
$response2     = mysqli_fetch_array($result2);

?>
<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header"><?php echo $response2['brandname'] . ' ' . $response2['modelnumber']; ?></h1>
    <ol class="breadcrumb">
      <li>
        <i class="fa fa-home"></i> Home
      </li>
      <li>
        <i class="fa fa-wrench"></i><a href="tools/tool.php"> Gereedschap</a>
      </li>
      <li>
        <i class="fa fa-wrench"></i> <?php echo $response2['brandname'] . ' ' . $response2['modelnumber']; ?>
      </li>
    </ol>
  </div>
</div>
<?php

echo '<p>Omschrijving: ' . $response2['description'] . '</p>';

echo '<p>Opleiding vereist: ' . $response2['trainingdescription'] . '</p>';

$strQuery3 = "SELECT idmembertrainings FROM membertrainings WHERE training = '" . $response2['training'] . "' AND username = '" . $username . "';";
$result3 = $dbhandle->query($strQuery3) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
$response3     = mysqli_fetch_array($result3);

if ($response3 == NULL) {
    
    echo '<p>U heeft deze opleiding nog niet.</p>';
    echo '<p>Volgende leden hebben deze wel:</p>';
    
    echo "<div class='table-responsive'><table class='table table-striped results'><thead><tr><th></th><th>Voornaam</th><th>Achternaam</th></tr></thead><tbody>";
    
    $strQuery4 = "SELECT tools.idtools, brands.name AS brandname, tools.modelnumber, tools.description, tools.manual, departments.name AS departmentname, trainings.description AS trainingdescription, trainings.fee
FROM ((tools INNER JOIN trainings ON tools.training = trainings.idtrainings) INNER JOIN departments ON tools.department = departments.iddepartments) INNER JOIN brands ON tools.brand = brands.idbrands ORDER BY tools.idtools ;";
$result4 = $dbhandle->query($strQuery4) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
while ($row = mysqli_fetch_array($result4)) {
    
    echo '<tr><td><a class="btn btn-primary btn-xs" href="members/member.php?username=' . $row['idtools'] . '">Naar profiel</a></td><td>' . $row['brandname'] . '</td><td>' . $row['modelnumber'] . '</td></tr>';
    
}
echo "</tbody></table></div>";
	
    
} else {
    
    echo '<p>U heeft de vereiste opleiding.</p>';
    
}

if ($response2['manual'] == 1) {
    
    echo '<iframe id="evidence-frame" src="' . $baseurl . 'tools/manuals/' . str_replace(' ', '', $response2['brandname']) . str_replace(' ', '', $response2['modelnumber']) . '.pdf#page=1&zoom=150" width="100%" style="height:66em"></iframe>';
    
}

include("../includes/php/bottom.php");
?>