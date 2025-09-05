<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script>
$(document).ready(function() {
	$("#show_liste").hide();
	$("#hide_liste").click(function(){
		$("#liste").hide(500);	
		$("#hide_liste").hide();
		$("#show_liste").show();
	});
	$("#show_liste").click(function(){
		$("#liste").show(500);	
		$("#hide_liste").show();
		$("#show_liste").hide();
	});
});
<!-- DT LISTE CONTRATS -->
$(document).ready(function() {
    $('#listing').DataTable( {
		"language": {
			"lengthMenu": 'Afficher <div class="styled-select-dt"><select class="styled-dt">'+
						'<option value="10">10</option>'+
						'<option value="20">20</option>'+
						'<option value="30">30</option>'+
						'<option value="40">40</option>'+
						'<option value="50">50</option>'+
						'<option value="100">100</option>'+
						'<option value="-1">All</option>'+
						'</select></div> lignes'
		},
		"pageLength" : 100,
		"order": [[0, 'desc']],
  	});
} );
</script>
<?php 
//Ferme le <head>, ouvre le <body> & inclus le menu + ouverture content
include_once("include/finhead.php");
$num=isset($_GET['num'])?$_GET['num']:"";
$sql = " SELECT * FROM " . $tblpref ."client WHERE num_client='".$num."'";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
while($data = mysql_fetch_array($req)) {
	$nom = $data['nom'];
	$nom2 = $data['nom2'];
	$rue = $data['rue'];
	$boite = $data['boite'];
	$numero = $data['numero'];
	$ville = $data['ville'];
	$cp = $data['cp'];
	$tva = $data['num_tva'];
	$mail = $data['mail'];
	$login = $data['login'];
	$civ = $data['civ'];
	$tel = $data['tel'];
	$gsm = $data['gsm'];
	$fax = $data['fax'];
}
//Gestion des messages informatifs
include_once("include/message_info.php");
?>
<!--LISTE EXISTANT-->
<div class="portion">
    <!-- TITRE - LISTE -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-pencil fa-stack-1x"></i>
        </span>
        Editer le client : "<?php echo $nom; ?>"
        <span class="fa-stack fa-lg add" style="float:right" id="show_edit">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_edit">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <div class="content_traitement" id="edit">
	<form name="edit_client" method="post" action="client_update.php" onsubmit="return confirmUpdate()">
        <table class="base" width="100%">
              <tr> 
                <td class="right" width="50%">Civilité :</td>
                <td class="left" width="50%"> <input name="civ" type="text" id="civ" value='<?php echo "$civ"; ?>' class="styled"></td>
              </tr>
              <tr> 
                <td class="right"><?php echo $lang_nom; ?> :</td>
                <td class="left"> <input name="nom" type="text" id="nom" value="<?php echo "$nom"; ?>" class="styled"></td>
              </tr>
              <tr> 
                <td class="right"> <?php echo $lang_complement; ?> :</td>
                <td class="left"><input name="nom_sup" type="text" id="nom_sup" value='<?php echo "$nom2"; ?>' class="styled"></td>
              </tr>
              <tr> 
                <td class="right"> <?php echo $lang_rue; ?> :</td>
                <td class="left">
                    <input name="rue" type="text" id="rue" value='<?php echo "$rue"; ?>' class="styled" style="width:23.5%"> 
                    N&deg; <input name="numero" type="text" id="numero" value="<?php echo "$numero"; ?>" size="4" class="styled" style="width:10%"> 
                    Bte <input name="boite" type="text" id="boite" value="<?php echo "$boite"; ?>" size="4" class="styled" style="width:10%">
                </td>
              </tr>
              <tr> 
                <td class="right"> <?php echo $lang_code_postal; ?> :</td>
                <td class="left"><input name="code_post" type="text" id="code_post" value="<?php echo "$cp"; ?>" class="styled"> </td>
              <tr> 
                <td class="right"> <?php echo $lang_ville; ?> :</td>
                <td class="left"><input name="ville" type="text" id="ville" value="<?php echo "$ville"; ?>" class="styled"></td>
              <tr> 
                <td class="right"> <?php echo $lang_numero_tva; ?> :</td>
                <td class="left"><input name="num_tva" type="text" id="num_tva" value="<?php echo "$tva"; ?>" class="styled"></td>
              </tr>
              <tr> 
                <td class="right">T&eacute;l&eacute;phone :</td>
                <td class="left"> <input name="tel" type="text" id="tel" value='<?php echo "$tel"; ?>' class="styled"></td>
              </tr>
              <tr> 
                <td class="right">GSM :</td>
                <td class="left"> <input name="gsm" type="text" id="gsm" value='<?php echo "$gsm"; ?>' class="styled"></td>
              </tr>
              <tr> 
                <td class="right">Fax :</td>
                <td class="left"> <input name="fax" type="text" id="fax" value='<?php echo "$fax"; ?>' class="styled"></td>
              </tr>
              <tr>
                <td class="right">Email :</td>
                <td class="texte0"><input name="mail" type="text" id="mail" value='<?php echo "$mail"; ?>' class="styled"></td>
              </tr>
        </table>
        <div class="center">
            <button class="button_act button--shikoba button--border-thin medium" type="submit"><i class="button__icon fa fa-check"></i><span>Valider</span></button>
            <button class="button_act button--shikoba button--border-thin medium" type="reset"><i class="button__icon fa fa-eraser"></i><span>Effacer</span></button>
        </div>
        <input type="hidden" name="num" id="num" value="<?php echo $num;?>" />
      </form>
<?php 
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>
