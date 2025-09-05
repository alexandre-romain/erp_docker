<?php 
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/configav.php");
?><html>
<head>

 <title>Fast IT Service : Module de gestion intégrée</title>
 <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="include/themes/<?php echo"$theme";?>/style.css">
<link rel="shortcut icon" type="image/x-icon" href="image/favicon.ico" >
</head>

<body>
<table width="760" border="0" class="page" align="center">
<tr>
<td class="page" align="center">
<?php
if ($dev_num =='') { 
$num_dev=isset($_GET['num_dev'])?$_GET['num_dev']:"";  
}

$nom=isset($_GET['article'])?$_GET['article']:"";

?>
</td>
</tr>
<tr>
<td  class="page" align="center">
<SCRIPT language="JavaScript" type="text/javascript">
		function confirmDelete()
		{
		var agree=confirm("<?php echo 'Désirez vous vraiment effacer cette ligne du devis ?'; ?>");
		if (agree)
		 return true ;
		else
		 return false ;
		}
		</script>

<?php


include ("new-form_editer_devis.php");

?>
<?php 
include("include/bas.php");
?>
</td></tr>
</table>
<?php
include_once("include/bas.php");
?>
</body>
</html>
