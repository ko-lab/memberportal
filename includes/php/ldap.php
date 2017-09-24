<?php
$ldaplogin = ldap_connect($hostldap, $portldap)
    or die("Could not connect to LDAP server.");
ldap_set_option($ldaplogin, LDAP_OPT_PROTOCOL_VERSION, 3);
?>