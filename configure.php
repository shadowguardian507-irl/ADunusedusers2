<?php
$versionfiletarget = "php-fpm/version.conf.php";
echo "starting up \n";
$fetchheadstring = file_get_contents (".git/FETCH_HEAD");
$fetchheadstringarry = explode("	", $fetchheadstring);
echo "Version ID = " . $fetchheadstringarry[0] ;
echo "\n";
$versionfiletext= '<?php $versiondata["id"] = "'.$fetchheadstringarry[0].'" ?>' ;
file_put_contents($versionfiletarget,$versionfiletext);
exec("cp appversion.conf.php ./php-fpm/appversion.conf.php");
echo "now run docker-compose up --build to activate";
echo "\n";
//exec("docker-compose up --build");
?>
