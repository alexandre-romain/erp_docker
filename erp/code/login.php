<?php 
include_once("include/config/common.php");	 
$PHP_AUTH_USER = strtolower($_SERVER[PHP_AUTH_USER]);
$login=isset($_POST['login'])?$_POST['login']:"";
$pass=isset($_POST['pass'])?$_POST['pass']:"";
$lang=isset($_POST['lang'])?$_POST['lang']:"";
ini_set('session.save_path', 'include/session'); 
if ($lang=='') { 
$lang ="$default_lang";  
}
include_once("include/language/$lang.php");

  session_start();
  //session_register('login');
  $_SESSION['trucmuch'] = $login ;
	$_SESSION['lang'] = $lang ; 
  include_once("include/config/common.php");	    
  include_once("include/language/$lang.php");
  $message= "<h2>Authentification Apache & PHP Réussie <br><br> $lang_bienvenue $login</h2>";
	
?>
<?php 

include_once("include/config/common.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/finhead.php");
include_once("include/head.php");
?>
<script type="text/javascript">
var temps = 5; // Temps en secondes

window.onload = function ()
{
        debut = new Date();
    debut = debut.getTime();
   
        document.getElementById('compteur').innerHTML = temps +'s';
       
        cmp = setInterval('decompte();',990);
}



function decompte()
{
    var tmp = new Date();
        tmp = tmp.getTime();

    tmp = temps - ((tmp - debut)/1000);

    if (tmp > 0) {
        document.getElementById('compteur').innerHTML = Math.round(tmp) +'s';
    }
    else {
        clearInterval(cmp); // sinon le script se sent plus et il s'arrete pu
    }
}
</script>
<script language="JavaScript">
setTimeout("window.location='./accueil.php'",0);
</script>
<table width="760" border="0" class="page" align="center">
<tr>
<td class="page" align="center">
</td>
</tr>
<body>
<tr>
<td  class="page" align="center">
<?php 
if ($message!='') { 
 echo"<table align=\"center\"><tr><td>$message</td></tr><tr><td><h1>Vous allez &ecirc;tre redirig&eacute; vers votre tableau de bord dans <div id='compteur'></div></h1></td></tr></table>"; 
}
?>
</td>
</tr>
<tr><td><? include_once("include/bas.php"); ?></td></tr>
</table>
</body>
