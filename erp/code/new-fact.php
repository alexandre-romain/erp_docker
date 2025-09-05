<?php 
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");
include_once("include/headers.php");
include_once("include/finhead.php");?>
<table width="760" border="0" class="page" align="center">
<tr>
<td class="page" align="center">
<?php
include_once("include/head.php");
if ($user_admin != y) { 
echo "<h1>$lang_admin_droit";
exit;
}
?>
</td>
</tr>
<?php
$date_deb=isset($_POST['date_deb'])?$_POST['date_deb']:"";
list($jour_deb, $mois_deb,$annee_deb) = preg_split('/\//', $date_deb, 3);
$date_fin=isset($_POST['date_fin'])?$_POST['date_fin']:"";
list($jour_f, $mois_f,$annee_f) = preg_split('/\//', $date_fin, 3);
$date_fact1=isset($_POST['date_fact'])?$_POST['date_fact']:"";
list($jour_fact, $mois_fact,$annee_fact) = preg_split('/\//', $date_fact1, 3);
$client=isset($_POST['listeville'])?$_POST['listeville']:"";
$annee_fac=isset($_POST['annee_fac'])?$_POST['annee_fac']:"";
$debut = "$annee_deb-$mois_deb-$jour_deb" ;
$fin = "$annee_f-$mois_f-$jour_f" ;
$date_fact ="$annee_fact-$mois_fact-$jour_fact";

	if($client=='null' || $date_deb==''|| $date_fin=='' || $date_fact=='' )
	{
	$message= "<h1>$lang_oubli_champ</h1>";
	include('form_facture.php');
	exit;
	}
	
	// on recupere les infos client
	$sql = " SELECT nom, nom2 From " . $tblprefluc ."client WHERE num_client = $client ";
	$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
	while($data = mysql_fetch_array($req))
		{
		$nom = $data['nom'];
		$nom =  stripslashes ($nom);
		$nom2 = $data['nom2'];
		}
?>
<tr>
	<td class='page'>

<form action="new-fact_fin.php" method="post" name="fact" id="fact">
<table class='boiteaction'>
<caption>
Documents à facturer
</caption>
<tr>
	<td colspan='7'>&nbsp;</td>
</tr>
<tr>
	<td colspan='7'><h2>Bons de Livraison</h2></td>
</tr>
<tr>
	<td colspan='7'>&nbsp;</td>
</tr>
<tr>
	<th>N°</th>
	<th>Client</th>
	<th>Date</th>
	<th>BDC</th>
	<th>Total HT</th>
	<th>Total TTC</th>
	<th>Facturer ?</th>
</tr>

<?
$sql = "SELECT num_bl, bon_num, tot_htva, tot_tva, DATE_FORMAT(date,'%d/%m/%Y') AS date
		FROM " . $tblprefluc ."bl
		WHERE " . $tblprefluc ."bl.client_num = '".$client."' 
		AND " . $tblprefluc ."bl.date >= '".$debut."' 
		and " . $tblprefluc ."bl.date <= '".$fin."'
		and fact='0'";
		
		$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$nombre= 1;//1ere ligne du tableau foncee
while($data = mysql_fetch_array($req))
{
$num_bl = $data['num_bl'];
$bon_num = $data['bon_num'];
$date = $data['date'];
$tot_htva = $data['tot_htva'];
$tot_tva = $data['tot_tva'];

		$nombre = $nombre +1;
		if($nombre & 1){
		$line="0";
		}else{
		$line="1";
		}
?>
<tr class="texte<?php echo"$line" ?>" onmouseover="this.className='highlight'" onmouseout="this.className='texte<?php echo"$line" ?>'">
	<td class="highlight"><? echo $num_bl; ?></td>
	<td class="highlight"><? echo $nom; ?></td>
	<td class="highlight"><? echo $date; ?></td>
	<td class="highlight"><? echo $bon_num; ?></td>
	<td class="highlight"><? echo $tot_htva; ?></td>
	<td class="highlight"><? echo $tot_tva; ?></td>
	<td class="highlight"><input type="checkbox" name="liste_bl[]" value="<? echo $num_bl; ?>" CHECKED></td>
</tr>
<?
} ?>
</table>
<table class='boiteaction'>

<tr class='submit'>
	<td colspan='6'>&nbsp;</td>
</tr>
<tr>
	<td colspan='6'>&nbsp;</td>
</tr>
<tr>
	<td colspan='6'><h2>Interventions</h2></td>
</tr>
<tr>
	<td colspan='6'>&nbsp;</td>
</tr>
<tr>
	<th>N°</th>
	<th>Client</th>
	<th>Date</th>
	<th>Duree</th>
	<th>Raison de l'Intervention</th>
	<th>Facturer ?</th>
</tr>
<?
$sql = "SELECT num_inter, fin, cause, debut, DATE_FORMAT(date,'%d/%m/%Y') AS date
		FROM " . $tblprefluc ."interventions
		WHERE " . $tblprefluc ."interventions.client_num = '".$client."' 
		AND " . $tblprefluc ."interventions.date >= '".$debut."' 
		and " . $tblprefluc ."interventions.date <= '".$fin."'
		and fact='0'";
		
		$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$nombre=1;//1ere ligne du tableau foncée
while($data = mysql_fetch_array($req))
{
$num_inter = $data['num_inter'];
$date = $data['date'];
$fin = $data['fin'];
$debut = $data['debut'];
$cause = stripslashes ($data['cause']);

  //calcul de la durée
  $duree_s = $fin - $debut;
  
  $duree_h = (int)($duree_s / 3600);
  $reste = (int)($duree_s % 3600);
  $duree_m = (int)($reste / 60);
  if ($duree_m < 10)
  {
  $duree_m = "0".$duree_m;
  }
  $duree = $duree_h.":".$duree_m;

		$nombre = $nombre +1;
		if($nombre & 1){
		$line="0";
		}else{
		$line="1";
		}
?>
<tr class="texte<?php echo"$line" ?>" onmouseover="this.className='highlight'" onmouseout="this.className='texte<?php echo"$line" ?>'">
	<td class="highlight"><? echo $num_inter; ?></td>
	<td class="highlight"><? echo $nom; ?></td>
	<td class="highlight"><? echo $date; ?></td>
	<td class="highlight"><? echo $duree." h"; ?></td>
	<td class="highlight"><? echo $cause; ?></td>
	<td class="highlight"><input type="checkbox" name="liste_inter[]" value="<? echo $num_inter; ?>" CHECKED></td>
</tr>
<?
} ?>
<tr class='submit'>
  <td colspan='6'>&nbsp;</td>
</tr>
<tr>
  <td colspan='6'><table width="100%"  border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><div align="center"><h2>Commentaires : </h2></div></td>
    </tr>
    <tr>
      <td><div align="center">
        <textarea name="coment" cols="45" rows="3" id="coment"></textarea>
      </div></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="50%">
        <h2>Acompte :&nbsp;<input name="acompte" type="text" id="acompte" size="8"> 
        &euro;</h2>
      </td>
    </tr>
	    <tr>
      <td width="50%">
        <h2>Delai paiement :&nbsp;
          <input name="delai" type="text" id="delai" value="3" size="8"> 
        jours</h2>
      </td>
    </tr>
  </table></td>
</tr>
<tr>
	<td colspan='6'>&nbsp;</td>
</tr>
<tr class="submit">
	<td colspan='6'><div align="center">
	  <input type="submit" name="Submit" value="Facturer les bons s&eacute;lectionn&eacute;s">
	  <input type="hidden" name="client" value="<? echo $client;?>">
	  <input type="hidden" name="date_deb" value="<? echo $date_deb;?>">
	  <input type="hidden" name="date_fin" value="<? echo $date_fin;?>">
	  <input type="hidden" name="date_fact" value="<? echo $date_fact1;?>">
	  <input type="hidden" name="annee_fac" value="<? echo $annee_fac;?>">

	</div></td>
</tr>
</table>
<br><hr>
</form>
<tr>
	<td>
	<?php
	include_once("include/bas.php");
	?> 
	</td>
</tr>
</table>