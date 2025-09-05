<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script>
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
//Ferme le <head>, ouvre le <body> & inclus le menu + ouverture content
include_once("include/finhead.php");
//FINHEAD
if ($dev_num =='') { 
$num_dev=isset($_GET['num_dev'])?$_GET['num_dev']:"";  
}
$nom=isset($_GET['article'])?$_GET['article']:"";
include("form_editer_devis.php");
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>