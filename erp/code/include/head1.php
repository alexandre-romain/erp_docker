<?php 
include_once("include/config/common.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/configav.php");
include_once("include/themes/FAST_IT/menu.inc.php");
require ("include/del_pdf.php");
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
<center>
<?php 
include_once("javascripts/date.js");
?>
</center>
  