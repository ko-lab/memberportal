<?php

include("../includes/php/top.php");
include("../includes/php/mysqli.php");
include("../includes/php/ldap.php");

?>
<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">Leden</h1>
    <ol class="breadcrumb">
      <li>
        <i class="fa fa-home"></i> Home
      </li>
      <li class="active">
        <i class="fa fa-users"></i> Leden
      </li>
    </ol>
  </div>
</div>
<?php

echo "<div class='table-responsive'><table class='table table-striped'><thead><tr><th> </th><th>Naam</th></tr></thead><tbody>";

if ($bind = ldap_bind($ldaplogin, $usernamecn, $password)) {
    
    $search_filter = '(|(objectClass=inetOrgPerson))';
    $attr = array("memberof","displayName","uidNumber");
    
    $result = ldap_search($ldaplogin, $memberouldap, $search_filter, $attr) or exit("Unable to search LDAP server");
    
    if (FALSE !== $result){
        
        $entries = ldap_get_entries($ldaplogin, $result);
        
        for ($x=0; $x<$entries['count']; $x++){
            
            echo '<tr><td>';
            
            if($Admin == 1) {
                
                echo '<a class="btn btn-primary btn-xs" href="members/memeber.php?uid=' . $entries[$x]['uidnumber'][0] . '">Bewerk</a>';
                
            }
            
            echo ' </td><td>' . $entries[$x]['displayname'][0] . '</tr>';
            
        }
        
    }
    
}

echo "</tbody></table></div>";

if($Admin == 1) {
    
    echo '<form role="form" action="' . $baseurl . 'members/membernew.php" method="post">';
    echo '<div class="form-group"><label for="firstname">Voornaam:</label>';
    echo '<input type="text" class="form-control" name="firstname" id="firstname"></div>';
    echo '<div class="form-group"><label for="lastname">Achternaam:</label>';
    echo '<input type="text" class="form-control" name="lastname" id="lastname"></div>';
    echo '<div class="form-group"><label for="username">Gebruikersnaam:</label>';
    echo '<input type="text" class="form-control" name="username" id="username"></div>';
    echo '<button type="submit" class="btn btn-primary">Aanmaken</button></form>';
    
}

include("../includes/php/bottom.php");
?>