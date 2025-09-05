<?php 
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/finhead.php");
include_once("include/head.php");
$user = $_SERVER[PHP_AUTH_USER]; //login dans cette variable
//On inclus le footer apres la récupération de la variable $user; pour pouvoir la récupérer
include_once("include/elements/footer.php"); 
if ($user_stat== n) { 
	echo"<h1>$lang_statistique_droit";
	exit;  
}
$annee = date(Y);
$mois = date(m);
$calendrier = calendrier_local_mois ();
?>
<br/>
<form action="stat_depenses_mois.php" method="post">
<table class="main_table" width="500" align="center">
    <tr>
        <td class="main_table_header" colspan="2"><?php echo $lang_choisissez; ?> la p&eacute;riode</td> 
    </tr>
    <tr>
        <td class="main_table">
            <select name="mois_1">
            <?php
            foreach ($calendrier as $numero_mois => $nom_mois)
            {
            ?>
                <option value="<?php echo $numero_mois; ?>"><?php echo ucfirst($nom_mois); ?></option>
            <?php
            }
            ?>
            </select>
        </td>
        <td class="main_table">
            <select name="annee_1">
                <?php
				//Permet de lister les années ==> Changer $i < 2016 pour augmenter la valeur finale; changer $i=2004 pour modifier la valeur initiale
				for ($i=2004 ; $i < 2016 ; $i++) {
					echo '<option value="'.$i.'">'.$i.'</option>';
				}
				?>
            </select>
        </td>
    </tr>
    <tr>
        <td class="main_table_header" colspan="2"> <input type="submit" value='<?php echo $lang_envoyer; ?>' class="submit"></td>
    </tr>
</table>
</form>
<br/>
<?php 
$mois_1=isset($_POST['mois_1'])?$_POST['mois_1']:"";
$annee_1=isset($_POST['annee_1'])?$_POST['annee_1']:"";
if ($mois_1=='') {
 	$mois_1= $mois ;
} 
if ($annee_1=='') { 
 	$annee_1= $annee ; 
}
//stats mensuelles
$sql2 = "SELECT SUM(prix)FROM " . $tblpref ."depense WHERE MONTH(date) = $mois_1 AND YEAR(date) = $annee_1 ";
$req = mysql_query($sql2);
while ($data = mysql_fetch_array($req))
{
  	$total_gene = $data['SUM(prix)'];
}
$sql = "SELECT fournisseur, SUM(prix) FROM " . $tblpref ."depense WHERE MONTH(date) = $mois_1  AND YEAR(date) = $annee_1 GROUP BY fournisseur";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
?>
<table class="main_table" align="center" width="760px">
	<tr>
     	<td class="main_table_header" colspan="2"><?php echo "Tri des achats par fournisseur - Période : ".$mois_1."/".$annee_1; ?></td> 
   	</tr>
    <tr> 
        <th class="subtitle"><?php echo $lang_fournisseur; ?></th>
        <th class="subtitle"><?php echo $lang_total; ?></th>
    </tr>
    <?
	while($data = mysql_fetch_array($req))
   	{
		$four = $data['fournisseur'];
		$total = $data['SUM(prix)'];
		?>
        <tr> 
          	<td class='<?php echo couleur_alternee (); ?>'><?php echo $four; ?></td>
          	<td class='<?php echo couleur_alternee (FALSE,"nombre"); ?>'><?php echo montant_financier ($total); ?></td>
        </tr>
  	<?php
	}
	?>
    <tr> 
     	<th class='subtitle'><?php echo $lang_total; ?></th>
       	<th class="subtitle"><?php echo  montant_financier ($total_gene); ?></th>
    </tr>
</table>      
<?php
include_once("include/bas.php");
?>
</body>
</html>
