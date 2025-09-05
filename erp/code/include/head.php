<?php 
include_once("include/themes/$theme/menu.inc.php");

$filename = 'installeur';

if (file_exists($filename)) {
   echo "<center><h1>$lang_erreur_insta</h1></center><br>";
}
if (file_exists('dump/backup.sql')) {
   echo "<center><h1>$lang_erreur_backup</h1></center><br>";
}
if (is_writable("include/config/common.php")) {
echo "<center><h1> $lang_erreur_common</h1></center><br>";
}

if (is_writable("include/config/var.php")) {
echo "<center><h1>$lang_erreur_var</h1></center><br>";
}
?>
  