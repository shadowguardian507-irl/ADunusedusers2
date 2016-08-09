<?php
/*.
    require_module 'standard';
    require_module 'ldap';
.*/
?>
<?php
function dedupeunusedusersfromalldcs($ldaplinks,$ldapconf)
{
  foreach ($ldaplinks as $DCadldap) {
    $sr = ldap_search($DCadldap->getLdapConnection(), $ldapconf['basedn'] , '(&(!(lastlogon=*))(objectClass=user)(!(objectClass=computer)))', array('objectclass', 'distinguishedname', 'samaccountname'));
    $userentries = @ldap_get_entries($DCadldap->getLdapConnection(), $sr);

    foreach ($userentries as $auserobject) {
        if( $auserobject['samaccountname'][0] != '' )
        {
          $usernamesarry[$namearrayid][] = $auserobject['samaccountname'][0];
        }
    }
    $namearrayid = $namearrayid + 1;
  }

  $useroutputarry = array();
  foreach ($usernamesarry as $userarry) {
    $useroutputarry = array_unique(array_merge($useroutputarry,$userarry), SORT_REGULAR);
  }

  return $useroutputarry;
}
?>
