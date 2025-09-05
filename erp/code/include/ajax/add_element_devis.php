<?php
include_once("../config/common.php");
$article=$_REQUEST['article'];
$nom=$_REQUEST['nom'];
$cible=$_REQUEST['cible'];
//On va récupérer les informations de l'article, pour affichage.
$sql="SELECT * FROM ".$tblpref."article WHERE num='".$article."'";
$req=mysql_query($sql);
$obj=mysql_fetch_object($req);
$alea=mt_rand()
?>
<div class="styled-div" id="<?php echo $alea;?>">
<?php echo $obj->marque.' | '.$obj->article.' | '.$obj->reference;?><i class="fa fa-times fa-2x del" style="float:right;margin-top:-1%;" onclick="del_element('<?php echo $alea;?>', '<?php echo $cible;?>')"></i>
<input type="hidden" name="<?php echo $nom;?>" value="<?php echo $article;?>">
</div>
