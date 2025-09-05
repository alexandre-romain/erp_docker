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
<?php
if($message!=''){
echo"<tr><TD>$message</TD></tr>";
}
?>
<tr>
<td  class="page" align="center">
<?php 
if ($user_cli == n) { 
echo"<h1>$lang_client_droit";
exit;  
}
 ?> 
  <center><form action="new-client_new.php" method="post" name="client" id="client" >
        <table >
          <caption>
          <?php echo $lang_client_ajouter; ?>
          </caption>
          <tr> 
            <td class="texte0">Civilité</td>
            <td class="texte0"><input name="civ" type="text" id="civ"></td>
          </tr>
          <tr> 
            <td class="texte1"><?php echo $lang_nom; ?></td>
            <td class="texte1"><input name="nom" type="text" id="nom"></td>
          </tr>
          <tr> 
            <td class="texte0"><?php echo $lang_complement; ?></td>
            <td class="texte0"><input name="nom_sup" type="text" id="nom_sup"></td>
          </tr>
          <tr> 
            <td class="texte1"><?php echo $lang_rue; ?></td>
            <td class="texte1"><input name="rue" type="text" id="rue">
              N&deg; <input name="numero" type="text" id="numero" size="4">
              Bte 
              <input name="boite" type="text" id="boite" size="4"></td>
          </tr>
          <tr> 
            <td class="texte0"><?php echo $lang_code_postal; ?></td>
            <td class="texte0"><input name="code_post" type="text" id="code_post"></td>
          </tr>
          <tr> 
            <td  class="texte1"><?php echo $lang_ville; ?></td>
            <td class="texte1"><input name="ville" type="text" id="ville"></td>
          </tr>
          <tr> 
            <td class="texte0"><?php echo $lang_numero_tva; ?></td>
            <td class="texte0"><input name="num_tva" type="text" id="num_tva"></td>
          </tr>
          <tr> 
            <td class="texte1"><?php echo telephone; ?></td>
            <td class="texte1"><input name="tel" type="text" id="tel"></td>
          </tr>
		  <tr> 
            <td class="texte0">GSM</td>
            <td class="texte0"><input name="gsm" type="text" id="gsm"></td>
          </tr>
          <tr> 
            <td class="texte1"><?php echo fax; ?></td>
            <td class="texte1"><input name="fax" type="text" id="fax"></td>
          </tr>
          <tr>
            <td class="texte0">Email</td>
            <td class="texte0"><input name="mail" type="text" id="mail"></td>
          </tr>
          <tr> 
            <td class="submit" colspan="2" align="left">&nbsp;</td>
          </tr>
          <tr> 
            <td class="submit" colspan="2"> <input type="submit" name="Submit" value="<?php echo $lang_envoyer; ?>"> 
              &nbsp;&nbsp; <input type="reset" name="Submit2" value="<?php echo $lang_retablir; ?>"></td>
          </tr>
        </table>
      </form></center>

<?php 
include("new-lister_clients.php");
?>

