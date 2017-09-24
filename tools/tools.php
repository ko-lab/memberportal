<?php

// open bestanden
include("../includes/php/top.php");
include("../includes/php/mysqli.php");

?>
<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">Gereedschap</h1>
    <ol class="breadcrumb">
      <li>
        <i class="fa fa-home"></i> Home
      </li>
      <li class="active">
        <i class="fa fa-wrench"></i> Gereedschap
      </li>
    </ol>
  </div>
</div>
<?php

echo '<div class="form-group pull-right"><input type="text" class="search form-control" placeholder="Wat zoek je?"></div><span class="counter pull-right"></span><br><br>';

echo "<table class='table table-striped results'><thead><tr><th></th><th>Merk</th><th>Modelnummer</th><th>Omschrijving</th><th>Locatie</th><th>Opleiding vereist</th></tr></thead><tbody>";

$strQuery1 = "SELECT tools.idtools, brands.name AS brandname, tools.modelnumber, tools.description, tools.manual, departments.name AS departmentname, trainings.description AS trainingdescription, trainings.fee
FROM ((tools INNER JOIN trainings ON tools.training = trainings.idtrainings) INNER JOIN departments ON tools.department = departments.iddepartments) INNER JOIN brands ON tools.brand = brands.idbrands ORDER BY tools.idtools ;";
$result1 = $dbhandle->query($strQuery1) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
while ($row = mysqli_fetch_array($result1)) {
    
    echo '<tr><td><a class="btn btn-primary btn-xs" href="tools/tool.php?tool=' . $row['idtools'] . '">Bekijk</a></td><td>' . $row['brandname'] . '</td><td>' . $row['modelnumber'] . '</td><td>' . $row['description'] . '</td><td>' . $row['departmentname'] . '</td><td>' . $row['trainingdescription'] . '</td></tr>';
    
}
echo "</tbody></table>";

?>
<script>
$(document).ready(function() {
  $(".search").keyup(function () {
    var searchTerm = $(".search").val();
    var listItem = $('.results tbody').children('tr');
    var searchSplit = searchTerm.replace(/ /g, "'):containsi('")
    
  $.extend($.expr[':'], {'containsi': function(elem, i, match, array){
        return (elem.textContent || elem.innerText || '').toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
    }
  });
    
  $(".results tbody tr").not(":containsi('" + searchSplit + "')").each(function(e){
    $(this).attr('visible','false');
  });

  $(".results tbody tr:containsi('" + searchSplit + "')").each(function(e){
    $(this).attr('visible','true');
  });

  var jobCount = $('.results tbody tr[visible="true"]').length;
    $('.counter').text(jobCount + ' items');

  if(jobCount == '0') {$('.no-result').show();}
    else {$('.no-result').hide();}
		  });
});
</script>
<?php

include("../includes/php/bottom.php");
?>