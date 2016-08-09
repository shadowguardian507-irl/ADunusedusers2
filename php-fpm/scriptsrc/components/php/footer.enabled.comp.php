<?php
/*.
    require_module 'standard';
.*/
?>
<div id="banner-bottom">
  <div id="banner-content-bottom">
    <div id="banner-content-bottom-left">
         <?php
         if(file_exists ( "./config.d/active/appversion.conf.php"))
         {
           echo "Version ".$versiondata['version'];
           if(file_exists ( "./config.d/active/version.conf.php"))
           {
             if(isset($versiondata['id'])){
               if ($versiondata['id'] != "" ){
                 echo " (ID - " .$versiondata['id'].")";
               }
               else {
                 echo " ID not defined";
               }
             }
             else {
               echo " data missing";
             }
           }
         }
         else {
           echo "No app version data";
         }
         ?>
    </div>
    <div id="banner-content-bottom-right">
         Released under GNU LGPL3.0
    </div>
  </div>
</div>
