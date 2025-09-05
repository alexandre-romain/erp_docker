<?php 
include_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/config/var.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/finhead.php");
?>


<table width="760" border="0" class="page" align="center">
<tr>
<td class="page" align="center">
<?php
include_once("include/head.php");
?>
</td>
</tr>
<tr>
<td  class="page" align="center">
<?php

$client=isset($_POST['listeville'])?$_POST['listeville']:"";
$date=isset($_POST['date'])?$_POST['date']:"";
list($jour, $mois, $annee) = preg_split('/\//', $date, 3);


include_once("include/language/$lang.php"); 
if($client=='0')
    {
    echo "<p><center><h1>$lang_choix_client</p>";
    include('form_interventions.php');
    exit;
    }
 ?>
    <?php 

$sql_nom = "SELECT  nom, nom2, tel, gsm FROM " . $tblpref ."client WHERE num_client = $client";
$req = mysql_query($sql_nom) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data = mysql_fetch_array($req))
{
  $nom = $data['nom'];
	$nom = htmlentities($nom, ENT_QUOTES);
  $nom2 = $data['nom2'];
  	$nom2 = htmlentities($nom2, ENT_QUOTES);
  $tel = $data['tel'];
  $gsm = $data['gsm'];
  $phrase = "Intervention Créée pour";
  echo "<h2>$phrase $nom"; if ($nom2 != $nom) {echo " $nom2</h2>"; } else {echo "</h2>";}
}
mysql_select_db($db) or die ("Could not select $db database");
$sql1 = "INSERT INTO " . $tblpref ."interventions(client_num, date) VALUES ('$client', '$annee-$mois-$jour')";
mysql_query($sql1) or die('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());

$sql0 = "SELECT MAX(num_inter) As Maxi FROM " . $tblpref ."interventions";
$result0 = mysql_query($sql0) or die('Erreur');
$max = mysql_result($result0, 'Maxi');

// on sélectionne l'abonnement du client s'il existe
$sql2 = "SELECT  ID, date, tarif, temps_restant, deplacements_restant FROM " . $tblpref ."abos WHERE client = $client AND actif = 'oui'";
$req2 = mysql_query($sql2) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
while($data2 = mysql_fetch_array($req2))
{
	$ID_abo = $data2['ID'];
	$date_abo = $data2['date'];
	$tarif_abo = $data2['tarif'];
	$temps_restant_abo = $data2['temps_restant'];
	$deplacements_restant = $data2['deplacements_restant'];
	$heures = floor ($temps_restant_abo / 60);
	$minutes = floor(($temps_restant_abo - ($heures * 60)));
    if ($minutes < 10)
    {
	$minutes = "0".$minutes;
	}
	$temps_restant_affiche = $heures.':'.$minutes;

		if ($ID_abo != '')
		{
		// on sélectionne les infos sur le tarif	
		$sql3 = "SELECT  description, validite FROM " . $tblpref ."tarifs WHERE ID = $tarif_abo";
		$req3 = mysql_query($sql3) or die('Erreur SQL !<br>'.$sql3.'<br>'.mysql_error());
		while($data3 = mysql_fetch_array($req3))
		{
		$validite_tarif = $data3['validite'];
		$description_tarif = $data3['description'];
		}
		/* on vérifie que l'abo n'est pas périmé
		$timestamp_actuel = time();
		$timestamp_fin_abo = $date_abo + 86400 * $validite_tarif;
			
			if ($timestamp_actuel > $timestamp_fin_abo)
			{
			//on désactive l'abo si date de validité dépassée
			$sql4 = "UPDATE " . $tblpref ."abos 
			SET actif='non'
			WHERE client = '".$client."'";
			mysql_query($sql4) OR die("<p>Erreur Mysql<br/>$sql4<br/>".mysql_error()."</p>");
			echo "<h2>Abonnement Périmé !!<h2>";
			// on vide les variables
			$date_abo = '';
			$tarif_abo = '';
			$temps_restant_abo = '';
			$deplacements_restant = '';
			}*/
		}
}
?>
    <form name='formu2' method='post' action='interventions_suite.php'>
<SCRIPT LANGUAGE="JavaScript">
function SetHeureDebut() {
Today = new Date;
Heure = Today.getHours();
Min = Today.getMinutes();
if (Min < 10) {
Min = "0" + Min;
}
HeureMin = Heure + ":" + Min;
document.formu2.heure_debut.value = HeureMin;
}
function SetHeureFin() {
Today = new Date;
Heure = Today.getHours();
Min = Today.getMinutes();
if (Min < 10) {
Min = "0" + Min;
}
HeureMin = Heure + ":" + Min;
document.formu2.heure_fin.value = HeureMin;
}

</SCRIPT>
        <table class="boiteaction">
          <caption>
          D&eacute;tail de l'Intervention 
          </caption>
          <tr> 
            <td width="50%" class="texte0"> <input type="button" value="D&eacute;but Intervention" onClick="javascript:SetHeureDebut();"> 
              <b>-&gt;</b> <input name="heure_debut" type="text" id="heure_debut" size="10" maxlength="6"> 
            </td>
            <td width="50%" rowspan="4" class="texte0"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr> 
                  <td colspan="2"><div align="center"><strong>Coordonn&eacute;es Client</strong></div></td>
                </tr>
                <tr> 
                  <td colspan="2">&nbsp;</td>
                </tr>
                <tr> 
                  <td width="50%">Nom : <? echo "$nom"; if ($nom2 != $nom){echo "<br>Contact : ".$nom2;} ?></td>
                  <td width="50%">Tarif : <? if ($description_tarif != ''){ echo $description_tarif;} else { echo "Tarif Horaire"; } ?></td>
                </tr>
                <tr> 
                  <td width="50%">T&eacute;l. : 
                    <? if ($tel != ""){echo "$tel";} if ($gsm != ""){echo "<br>GSM : ".$gsm;} ?>
                  </td>
                  <td width="50%"><? if ($temps_restant_abo != '' && $temps_restant_abo >= '15'){echo "Temps restant : ".$temps_restant_affiche." h";} elseif ($temps_restant_abo != '' && $temps_restant_abo < '15'){echo "<font color=\"#FF0000\">Temps restant : ".$temps_restant_abo." h</font>";} else { echo "Intervention sera facturée";} ?></td>
                </tr>
              </table></td>
          </tr>
          <tr> 
            <td width="50%" class="texte0">&nbsp;</td>
          </tr>
          <tr> 
            <td width="50%" class="texte0"><strong>Cause de l'Intervention :</strong> <br> <input name="cause" type="text" id="cause" size="60" maxlength="150"> 
            </td>
          </tr>
          <tr> 
            <td width="50%" class="texte0"><strong>D&eacute;tail de l'intervention :</strong></td>
          </tr>
          <tr> 
            <td colspan="2" class="texte0" align="center"><div > <textarea name="detail" cols="100" rows="8" wrap="VIRTUAL" id="detail"></textarea> 
            </td>
          </tr>
          <tr> 
            <td colspan="2" class="submit">&nbsp;</td>
          </tr>
          <tr> 
            <td class="texte0" align="center"><strong>Commentaires / Conseils :</strong><br> <textarea name="coment" cols="50" rows="3" wrap="VIRTUAL" id="coment"></textarea> 
            </td>
            <td class="texte0"><table width="100%" align="center" class="boiteaction">
                <tr> 
                  <td><strong>D&eacute;placement :</strong></td>
                  <td><select name="deplacement" id="deplacement">
                      <option value="0">Aucun</option>
                      <option value="1" selected>- 20km</option>
                      <option value="2">20 - 40km</option>
                      <option value="3">40+ km</option>
                    </select></td>
                </tr>
                <tr> 
                  <td><strong>Tarif Sp&eacute;cial :</strong></td>
                  <td><select name="tarif_special" id="tarif_special">
                      <option value="1" selected>Non</option>
                      <option value="2">19h+</option>
                      <option value="3">Dimanche / F&eacute;ri&eacute; / 22h+</option>
                      <option value="4">Tarif r&eacute;duit</option>
					  <option value="5">Contrat Maintenance</option>
                    </select></td>
                </tr>
                <tr> 
                  <td><strong>Nombre intervenant(s) </strong></td>
                  <td><select name="nombreTrav" id="nombreTrav">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                  </select></td>
                </tr>
                <tr> 
                  <td colspan="2"><div align="center"> 
                      <input type="button" value="Fin Intervention" onClick="javascript:SetHeureFin();">
                      <b>-&gt;</b> 
                      <input name="heure_fin" type="text" id="heure_fin" size="10" maxlength="6">
                    </div></td>
                </tr>
                <tr> 
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr> 
                  <td colspan="2"><div align="center"> </div></td>
                </tr>
              </table></td>
          </tr>
          <tr> 
            <td colspan="2" class="submit"><div align="center"> 
                <input type="submit" name="Submit22" value="Finaliser">
              </div></td>
          </tr>
          <tr> 
            <td colspan="2" class="texte0">&nbsp;</td>
          </tr>
          <tr> 
            <td colspan="2" class="submit"><strong>Historique Interventions 
                pour <? echo "$nom"; ?></strong></td>
          </tr>
          <tr>
            <td colspan="2" class="texte0">ICI APPARAITRONT LES INTERVENTIONS 
              AYANT DEJA ETE EFFECTUEES POUR CE CLIENT DANS UN BUT DE CONSULTATION</td>
          </tr>
        </table>
      <input name="client_num" type="hidden" id="client_num" value='<?php echo $client; ?>'>
	  <input name="num_inter" type="hidden" id="num_inter" value='<?php echo $max; ?>'>
	  <input name="abo" type="hidden" id="abo" value='<?php echo $ID_abo; ?>'>
    </form>
    
</td></tr><tr><td>

<?php
include_once("include/bas.php");
?>
</td></tr></table>
</body>
</html>