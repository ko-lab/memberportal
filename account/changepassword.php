<?php

   // include site files
include("../includes/php/settings.php");
include("../includes/php/mysqli.php");
include("../includes/php/ldap.php");
include("../includes/php/top.php");


if ($username == Null) {
    echo "<META http-equiv='refresh' content='0;URL=/account/login.php'><p>Log in,</p>";
    include("../includes/php/bottom.php");
}

// redirect to form only

if (empty($_POST)) {
    goto form;
}

$newpassword = @$_POST['newpassword'];

// escape stings

$newpassword = mysqli_real_escape_string($dbhandle , $newpassword);

if (empty($newpassword)) {
    goto wrongpassword;
}

$encrypted_password = '{SHA}' . base64_encode(sha1( $newpassword, TRUE ));

// save to ldap

if ($bind = ldap_bind($ldaplogin, $userldap, $passldap)) {
    
    $updateuser["userPassword"] = $encrypted_password;
    
    $userfull = "uid=" . $username . ",ou=members,dc=internal,dc=ko-lab,dc=space";
    
    $result = ldap_mod_add($ldaplogin, $userfull, $updateuser);
    
}


echo "<div class='alert alert-success'><strong>Het wachtwoord is veranderd.</strong></div>";

goto form;

wrongpassword:
    
    echo "<div class='alert alert-danger'><strong>Wachtwoord incorect.</strong></div>";
    goto form;
    
    
form:
    
    echo '<h2>VERANDER WACHTWOORD</h2>';
    echo '<form role="form" action="account/changepassword.php" method="post"><div class="form-group"><label for="newpassword">Nieuw wachtwoord:</label><input type="password" class="form-control" name="newpassword" required></div><button type="submit" class="btn btn-primary">Verzend</button></form>';

include("../includes/php/bottom.php");
?>