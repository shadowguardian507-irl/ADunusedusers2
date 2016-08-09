<?php
/*.
    require_module 'standard';
.*/
?>
<?php

function checkldapconfigexists(){
  if (!file_exists ( "./config.d/active/ldap.conf.php"))
  {
    return false;
  }
  else
  {
    return true;
  }
}


function checkthemeconfigexists(){
  if (!file_exists ( "./config.d/active/theme.conf.php"))
  {
    return false;
  }
  else
  {
    return true;
  }
}
?>
