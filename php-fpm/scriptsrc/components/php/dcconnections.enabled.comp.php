<?php
/*.
    require_module 'standard';
    require_module 'ldap';
.*/
?>
<?php

function closedcconnections($ADldaplinkarray)
{
  foreach ($ADldaplinkarray as $DClink) {
        $DClink->close();
      }
}

function connecttodcs($dcsarry,$ldapconf)
{
  $bdn = $ldapconf['basedn'];
  $acctsif = $ldapconf['accountsuffix'];
  $lun = $ldapconf['linkaccountname'];
  $lup = $ldapconf['linkaccountpassword'];
  $rpg = $ldapconf['realprimarygroup'];
  $rg = $ldapconf['recursivegroups'];

  $dcid = 0;
  foreach ($dcsarry as $dc) {

    $dclinkarry = array($dc);
    $LdapConOptArry = array('base_dn'=>$bdn, 'domain_controllers'=>$dclinkarry, 'account_suffix'=>$acctsif, 'admin_username'=>$lun, 'admin_password'=>$lup, 'real_primarygroup'=>$rpg, 'recursive_groups'=>$rg );

    $adldapcons[$dcid] = new adLDAP($LdapConOptArry);
    try {
        $adldapcons[$dcid]->connect();
    }
    catch (adLDAPException $e) {
        echo $e; exit();
    }
    $dcid = $dcid + 1;
  }

  return $adldapcons;
}

?>
