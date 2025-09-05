<?php 
$sql = "SELECT  * FROM " . $tblpref ."tarifs WHERE ID = $ID";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$data = mysql_fetch_array($req);
  $ID = $data['ID'];
  $description = $data['description'];
  $prix = $data['prix'];
  $duree = $data['duree'];
  $validite = $data['validite'];
  $deplacements = $data['deplacements'];

?>
<table class="boiteaction">
  <caption>
  <?php echo "Modifier le tarif ".$description; ?> 
  </caption>
  <th> Description</th>
  <th>Prix (HTVA)</th>
  <th>Durée (heures)</th>
  <th>Validité (jours)</th>
  <th>Déplacements</th>
  <form name="form1" method="post" action="update_tarifs.php">
    <tr> 
      <td colspan="5" class="texte0">&nbsp;</td>
    </tr>
    <tr> 
          <td class="texte0"> <div align="center">
              <input type="hidden" name="ID" value="<? echo $ID ?>">
              <input name="description" type="text" value="<? echo $description; ?>" maxlength="50">
            </div></td>
          <td class="texte0"> <div align="center">
              <input name="prix" type="text" value="<? echo $prix; ?>" size="6" maxlength="6">
              &euro; </div></td>
          <td class="texte0"> <div align="center">
              <input name="duree" type="text" value="<? echo $duree; ?>" size="6" maxlength="6">
              h </div></td>
          <td class="texte0"> <div align="center">
              <input name="validite" type="text" value="<? echo $validite; ?>" size="6" maxlength="6">
              j</div></td>
          <td class="texte0"> <div align="center">
              <input name="deplacements" type="text" value="<? echo $deplacements; ?>" size="6" maxlength="6">
            </div></td>
    </tr>
    <tr> 
      <td colspan="5" class="texte0">&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="5" class="submit"><div align="center"> 
          <input type="submit" name="Submit" value="Modifier le tarif">
        </div></td>
    </tr>
  </form>
</table>
