<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script>
$(document).ready(function() {
	$("#show_serial").hide();
	$("#hide_serial").click(function(){
		$("#serial").hide(500);	
		$("#hide_serial").hide();
		$("#show_serial").show();
	});
	$("#show_serial").click(function(){
		$("#serial").show(500);	
		$("#hide_serial").show();
		$("#show_serial").hide();
	});
});
</script>
<?php 
//Ferme le <head>, ouvre le <body> & inclus le menu + ouverture content
include_once("include/finhead.php");
///FINHEAD
$quanti=isset($_POST['quanti'])?$_POST['quanti']:"";
$lib=isset($_POST['lib'])?$_POST['lib']:"";
$prix=isset($_POST['prix'])?$_POST['prix']:"";
$fourn=isset($_POST['fourn'])?$_POST['fourn']:"";
$fournisseur=isset($_POST['fournisseur'])?$_POST['fournisseur']:"";
$date=isset($_POST['date'])?$_POST['date']:"";
$ID_depense=isset($_POST['ID_depense'])?$_POST['ID_depense']:"";
$article=isset($_POST['article'])?$_POST['article']:"";
//on met a jour le stock
$sql03 = "SELECT stock FROM ". $tblpref ."article WHERE num = '$article'";
$req03 = mysql_query($sql03) or die('Erreur SQL !<br>'.$sql03.'<br>'.mysql_error());
$data03 = mysql_fetch_array($req03);
$stock_article = $data03['stock'];
$stock_article = $stock_article + $quanti;
$sql2 = "UPDATE " . $tblpref ."article SET stock = '$stock_article'  WHERE num = '$article'";
mysql_query($sql2) OR die("<p>Erreur Mysql1<br/>$sql2<br/>".mysql_error()."</p>");
?>
<!--SERIALS-->
<div class="portion">
    <!-- TITRE - SERIALS -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-key fa-stack-1x"></i>
        </span>
        Serial Numbers
        <span class="fa-stack fa-lg add" style="float:right" id="show_serial">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_serial">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - SERIALS -->
    <div class="content_traitement" id="serial">
        <form name="formu2" method="post" action="form_achatsmarchandises_suite.php" >
        <table class="base" width="100%">
            <?
            $i = 1;
            while ($i <= $quanti)
            {
            ?>
                <tr>
                    <td class="right" width="50%"><? echo $i.":"; ?></td>
                    <td class="left" width="50%"><input name="serial[]" type="text" id="serial[]" size="40" class="styled"></td>
                </tr>
                <?
                $i = $i+1;
            }
            ?>   
        </table> 
        <div class="center">
            <button class="button_act button--shikoba button--border-thin medium" type="submit" name="Submit"><i class="button__icon fa fa-floppy-o"></i><span>Enregistrer</span></button>
        </div>
        <input type="hidden" name="prix" value="<?php echo $prix; ?>">
        <input type="hidden" name="lib" value="<?php echo $lib; ?>">
        <input type="hidden" name="fourn" value="<?php echo $fourn; ?>">
        <input type="hidden" name="fournisseur" value="<?php echo $fournisseur; ?>">
        <input type="hidden" name="date" value="<?php echo $date; ?>">
        <input type="hidden" name="page" value="suite2">
        <input type="hidden" name="article"  value="<? echo $article; ?>">
        <input type="hidden" name="ID_depense"  value="<? echo $ID_depense; ?>">
        </form>
	</div>
</div>        
<?php 
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>