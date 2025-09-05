<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script>
$(document).ready(function() {
	$("#show_filter").hide();
	$("#hide_filter").click(function(){
		$("#filter").hide(500);	
		$("#hide_filter").hide();
		$("#show_filter").show();
	});
	$("#show_filter").click(function(){
		$("#filter").show(500);	
		$("#hide_filter").show();
		$("#show_filter").hide();
	});
	$("#show_stats").hide();
	$("#hide_stats").click(function(){
		$("#stats").hide(500);	
		$("#hide_stats").hide();
		$("#show_stats").show();
	});
	$("#show_stats").click(function(){
		$("#stats").show(500);	
		$("#hide_stats").show();
		$("#show_stats").hide();
	});
});
</script>
<?php 
//Ferme le <head>, ouvre le <body> & inclus le menu + ouverture content
include_once("include/finhead.php");
///FINHEAD
//Gestion des messages informatifs
include_once("include/message_info.php");
//Utile pour date du mois par défault
$annee = date('Y');
$mois = date('m');
$mois_1=isset($_POST['mois_1'])?$_POST['mois_1']:"";
$annee_1=isset($_POST['annee_1'])?$_POST['annee_1']:"";
if ($mois_1=='') {
 	$mois_1= $mois ;
} 
if ($annee_1=='') { 
 	$annee_1= $annee ; 
}
?>
<!--FILTRES-->
<div class="portion">
    <!-- TITRE - FILTRES -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-filter fa-stack-1x"></i>
        </span>
        Filtres
        <span class="fa-stack fa-lg add" style="float:right" id="show_filter">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_filter">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - FILTRES -->
    <div class="content_traitement" id="filter">
        <form action="stats_dep.php" method="post">
            <table class="base" width="100%">
                <tr>
                	<td class="right" width="50%">Choix du mois :</td>
                    <td class="left" width="50%">
                    	<div class="styled-select-inline" style="width:40%">
                        <select name="mois_1" class="styled-inline">
                            <option value="1" <?php if ($mois_1 == '1') { echo 'selected';}?>>Janvier</option>
                            <option value="2" <?php if ($mois_1 == '2') { echo 'selected';}?>>Février</option>
                            <option value="3" <?php if ($mois_1 == '3') { echo 'selected';}?>>Mars</option>
                            <option value="4" <?php if ($mois_1 == '4') { echo 'selected';}?>>Avril</option>
                            <option value="5" <?php if ($mois_1 == '5') { echo 'selected';}?>>Mai</option>
                            <option value="6" <?php if ($mois_1 == '6') { echo 'selected';}?>>Juin</option>
                            <option value="7" <?php if ($mois_1 == '7') { echo 'selected';}?>>Juillet</option>
                            <option value="8" <?php if ($mois_1 == '8') { echo 'selected';}?>>Août</option>
                            <option value="9" <?php if ($mois_1 == '9') { echo 'selected';}?>>Septembre</option>
                            <option value="10" <?php if ($mois_1 == '10') { echo 'selected';}?>>Octobre</option>
                            <option value="11" <?php if ($mois_1 == '11') { echo 'selected';}?>>Novembre</option>
                            <option value="12" <?php if ($mois_1 == '12') { echo 'selected';}?>>Decembre</option>
                        </select>
                        </div>
                    </td>
                </tr>
                <tr>
                	<td class="right">Choix de l'ann&eacute;e :</td>
                    <td class="left">
                    	<div class="styled-select-inline" style="width:40%">
                        <select name="annee_1" class="styled-inline">
                            <?php
                            //Permet de lister les années ==> Changer $i < 2016 pour augmenter la valeur finale; changer $i=2004 pour modifier la valeur initiale
                            for ($i=2004 ; $i < 2020 ; $i++) {
								if ($annee_1 == $i) {
									echo '<option value="'.$i.'" selected>'.$i.'</option>';
								}
								else {
                                	echo '<option value="'.$i.'">'.$i.'</option>';
								}
                            }
                            ?>
                        </select>
                        </div>
                    </td>
                </tr>
            </table>
            <div class="center">
                <button class="button_act button--shikoba button--border-thin medium" type="submit"><i class="button__icon fa fa-filter"></i><span>Filtrer</span></button>
            </div>
        </form>
	</div>
</div>
<?php 
//stats mensuelles
$sql2 = "SELECT SUM(prix)FROM " . $tblpref ."depense WHERE MONTH(date) = $mois_1 AND YEAR(date) = $annee_1 ";
$req = mysql_query($sql2);
while ($data = mysql_fetch_array($req))
{
	$total_gene = $data['SUM(prix)'];
}
?>
<!--STATS-->
<div class="portion">
    <!-- TITRE - STATS -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-pie-chart fa-stack-1x"></i>
        </span>
        Statistiques
        <span class="fa-stack fa-lg add" style="float:right" id="show_stats">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_stats">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - STATS -->
    <div class="content_traitement" id="stats">
    	<div class="portion_subtitle"><i class="fa fa-bar-chart fa-fw"></i> Statistiques mensuelles</div>
        <table class='base' width="100%">
			<?php
            $sql = "SELECT fournisseur, SUM(prix) FROM " . $tblpref ."depense WHERE MONTH(date) = $mois_1  AND YEAR(date) = $annee_1 GROUP BY fournisseur";
            $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
            ?>
            <tr>
                <td class='right' width="50%">Fournisseur</td>
                <td class='left' width="50%"><?php echo $lang_total; ?></td>
            </tr>
            <?php
            while($data = mysql_fetch_array($req))
            {
                $four = $data['fournisseur'];
                $total = $data['SUM(prix)'];
                ?>
                <tr>
                    <td class="right"><?php echo $four; ?></td>
                    <td class='left'><?php echo montant_financier ($total); ?></td>
                </tr>
            <?php
            }
            ?>
            <tr>
                <td class='right'><?php echo " $lang_total"; ?></td>
                <td class="left"><?php echo montant_financier($total_gene); ?></td>
            </tr>
        </table>
        <?php
        //stats annuelles
        $sql2 = "SELECT SUM(prix)FROM " . $tblpref ."depense WHERE YEAR(date) = $annee_1";
        $req = mysql_query($sql2);
        while ($data = mysql_fetch_array($req))
        {
            $total_gene = $data['SUM(prix)'];
        }
        ?>
        <div class="portion_subtitle"><i class="fa fa-bar-chart fa-fw"></i> Statistiques annuelles</div>
        <table class='base' width="100%">
            <?php
            $sql = "SELECT fournisseur, SUM(prix) FROM " . $tblpref ."depense WHERE YEAR(date) = $annee_1 GROUP  BY fournisseur ORDER  BY fournisseur";
            $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
            ?>
            <tr>
                <td class='right' width="50%">Fournisseur</td>
                <td class='left' width="50%"><?php echo $lang_total; ?></td>
            </tr>
            <?php
            while($data = mysql_fetch_array($req))
            {
                $four = $data['fournisseur'];
                $total = $data['SUM(prix)'];
                ?>
                <tr>
                    <td class='right'><?php echo $four; ?></td>
                    <td class='left'><?php echo montant_financier($total); ?></td>
                </tr>
            <?php
            }
            ?>
            <tr>
                <td class='right'><?php echo $lang_total; ?></td>
                <td class='left'><?php echo montant_financier($total_gene); ?></td>
            </tr>
        </table>
	</div>
</div>
<?php 
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>