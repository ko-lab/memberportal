<?php

include("../../includes/php/top.php");
include("../../includes/php/mysqli.php");

?>
<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">Customers</h1>
    <ol class="breadcrumb">
      <li>
        <i class="fa fa-home"></i> Home
      </li>
	  <li>
        <i class="fa fa-gear"></i> Settings
      </li>
	  <li class="active">
        <i class="fa fa-user"></i> Customers
      </li>
    </ol>
  </div>
</div>
<?php

echo "<div class='table-responsive'><table class='table table-striped'><thead><tr><th></th><th>Customer name</th></tr></thead><tbody>";

$strQuery1 = "SELECT idCustomers, CustomerName FROM customers ORDER BY CustomerName ASC;";
$result1 = $dbhandle->query($strQuery1) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
while ($row = mysqli_fetch_array($result1)) {
    echo '<tr><td><a class="btn btn-primary btn-xs" href="settings/customers/customersedit.php?customer=' . $row['idCustomers'] . '">Edit</a></td><td>' . $row['CustomerName'] . '</td></tr>';
}
echo "</tbody></table></div>";

echo '<form role="form" action="' . $baseurl . 'settings/customers/customersnew.php" method="get">';
echo '<div class="form-group"><label for="name">Customer name:</label>';
echo '<input type="text" class="form-control" name="name" id="name"></div>';

echo '<button type="submit" class="btn btn-default">Create</button></form>';

echo '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';

include("../../includes/php/bottom.php");
?>