<?php 
require_once("include/verif.php");
include_once("include/config/common.php");
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
<tr><TD>
<?php
$num=isset($_GET['num'])?$_GET['num']:"";
$sql = " SELECT * FROM " . $tblprefluc ."client WHERE num_client='$num'";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
while($data = mysql_fetch_array($req))
{
  $nom = htmlentities($data['nom'], ENT_QUOTES);
  $nom2 = htmlentities($data['nom2'], ENT_QUOTES);
  $rue = htmlentities($data['rue'], ENT_QUOTES);
  $boite = htmlentities($data['boite'], ENT_QUOTES);
  $numero = htmlentities($data['numero'], ENT_QUOTES);
  $ville = htmlentities($data['ville'], ENT_QUOTES);
  $cp = htmlentities($data['cp'], ENT_QUOTES);
  $tva = htmlentities($data['num_tva'], ENT_QUOTES);
  $mail =htmlentities($data['mail'], ENT_QUOTES);
  $login = htmlentities($data['login'], ENT_QUOTES);
	$civ = htmlentities($data['civ'], ENT_QUOTES);
	$tel = htmlentities($data['tel'], ENT_QUOTES);
	$gsm = htmlentities($data['gsm'], ENT_QUOTES);
	$fax = htmlentities($data['fax'], ENT_QUOTES);
}
?>
<form name="new-edit_client" method="post" action="new-client_update.php" onsubmit="return confirmUpdate()">
        <table class="boiteaction">
          <caption>
          <?php echo "$lang_client_modifier $nom"; ?> 
          </caption>
          <tr> 
            <td class="texte0">Civilité</td>
            <td class="texte0"> <input name="civ" type="text" id="civ" value='<?php echo "$civ"; ?>'></td>
          </tr>
          <tr> 
            <td class="texte1"><?php echo $lang_nom; ?></td>
            <td class="texte1"> <input name="nom" type="text" id="nom" value="<?php echo "$nom"; ?>"></td>
          </tr>
          <tr> 
            <td class="texte0"> <?php echo $lang_complement; ?> </td>
            <td class="texte0"><input name="nom_sup" type="text" id="nom_sup"
	    value='<?php echo "$nom2"; ?>'> </td>
          </tr>
          <tr> 
            <td class="texte1"> <?php echo $lang_rue; ?> </td>
            <td class="texte1"><input name="rue" type="text" id="rue"
	  value='<?php echo "$rue"; ?>'>
              N&deg; <input name="numero" type="text" id="numero" value="<?php echo "$numero"; ?>" size="4">
              Bte 
              <input name="boite" type="text" id="boite" value="<?php echo "$boite"; ?>" size="4"></td>
          </tr>
          <tr> 
            <td class="texte0"> <?php echo $lang_code_postal; ?></td>
            <td class="texte0"><input name="code_post" type="text" id="code_post" value="<?php echo "$cp"; ?>"> 
            </td>
          <tr> 
            <td class="texte1"> <?php echo $lang_ville; ?> </td>
            <td class="texte1"><input name="ville" type="text" id="ville" value="<?php echo "$ville"; ?>"></td>
          <tr> 
            <td class="texte0"> <?php echo $lang_numero_tva; ?> </td>
            <td class="texte0"><input name="num_tva" type="text" id="num_tva" value="<?php echo "$tva"; ?>"> 
            </td>
          </tr>
          <tr> 
            <td class="texte1"><?php echo telephone; ?></td>
            <td class="texte1"> <input name="tel" type="text" id="tel" value='<?php echo "$tel"; ?>'></td>
          </tr>
		  <tr> 
            <td class="texte0">GSM</td>
            <td class="texte0"> <input name="gsm" type="text" id="gsm" value='<?php echo "$gsm"; ?>'></td>
          </tr>
          <tr> 
            <td class="texte1"><?php echo fax; ?></td>
            <td class="texte1"> <input name="fax" type="text" id="fax" value='<?php echo "$fax"; ?>'></td>
          </tr>
          <tr>
            <td class="texte0">Email</td>
            <td class="texte0"><input name="mail" type="text" id="mail" value='<?php echo "$mail"; ?>'></td>
          </tr>
          <tr> 
            <td class="submit" colspan="2"><input type="submit" name="Submit" value="<?php echo $lang_envoyer; ?>"> 
              &nbsp; <input type="reset" name="Submit2" value="<?php echo $lang_retablir; ?>"> 
              <input name="num" type="hidden" value="<?php echo $num; ?>"> 
            </td>
          </tr>
        </table>
      </form>

</td></tr>
<tr><td>
<?php
include("help.php");
include_once("include/bas.php");
?>
</td></tr></table></body>
</html>
