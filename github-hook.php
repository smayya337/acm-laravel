<?php
$logfile = "/l/mrf8t/var/html/acm/autodeploy.log";
$fp = fopen($logfile,"a");
fprintf ($fp, "Auto-deploy at " . date("r") . " from " . (isset($_SERVER['REMOTE_ADDR'])?$_SERVER['REMOTE_ADDR']:"(no ip)") . "\n");
fprintf ($fp, "Commit info: " . (isset($_POST['payload'])?$_POST['payload']:"(no payload)") . "\n\n");
fclose($fp);
echo "<pre>" . `cd /l/mrf8t/var/html/www/; git pull; php composer.phar install; npm i; npm run build; php artisan migrate` . "</pre>";
system ("cd /l/mrf8t/var/html/www; git pull; php composer.phar install; npm i; npm run build; php artisan migrate \\;");
system ("cd /l/mrf8t/var/html; find . -type d -exec chmod 0755 {} \\;");
system ("cd /l/mrf8t/var/html; find . -type f -exec chmod 0644 {} \\;");
?>
