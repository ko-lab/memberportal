<?php

include("../includes/php/top.php");
include("../includes/php/mysqli.php");

$department = $_GET["department"];

if ($department == NULL) {
    echo '<META http-equiv="refresh" content="0;URL=' . $baseurl . 'departments/departments.php">';
    exit;
}

$department = mysqli_real_escape_string($dbhandle, $department);

$strQuery2 = "SELECT name, picture, description FROM departments WHERE iddepartments = '" . $department . "';";
$result2 = $dbhandle->query($strQuery2) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
$response2     = mysqli_fetch_array($result2);

?>
<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header"><?php echo $response2['name'];?></h1>
    <ol class="breadcrumb">
      <li>
        <i class="fa fa-home"></i> Home
      </li>
      <li>
        <i class="fa fa-fighter-jet"></i><a href="departments/departments.php"> Afdelingen</a>
      </li>
      <li>
        <i class="fa fa-fighter-jet"></i> <?php echo $response2['name']; ?>
      </li>
    </ol>
  </div>
</div>
<?php

echo '<p>Omschrijving: ' . $response2['description'] . '</p>';

echo '<img class="img-responsive" src="' . $baseurl . 'departments/pictures/' . $response2['name'] . '.jpg" alt="Chania">';

include("../includes/php/bottom.php");
?>