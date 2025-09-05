<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script>
$(document).ready(function() {
	$("#show_create").hide();
	$("#hide_create").click(function(){
		$("#create").hide(500);	
		$("#hide_create").hide();
		$("#show_create").show();
	});
	$("#show_create").click(function(){
		$("#create").show(500);	
		$("#hide_create").show();
		$("#show_create").hide();
	});
	$("#show_list").hide();
	$("#hide_list").click(function(){
		$("#list").hide(500);	
		$("#hide_list").hide();
		$("#show_list").show();
	});
	$("#show_list").click(function(){
		$("#list").show(500);	
		$("#hide_list").show();
		$("#show_list").hide();
	});
});
<!-- DT LISTE DEPENSES -->
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
		"pageLength" : 30,
		"order": [[0, 'desc']],
  	});
} );
function redirection(){
	window.location="form_depenses.php";
}
</script>
<?php 
//Ferme le <head>, ouvre le <body> & inclus le menu + ouverture content
include_once("include/finhead.php");
///FINHEAD
$page=isset($_POST['page'])?$_POST['page']:"";
if($page == "suite2")
{
	$serial=isset($_POST['serial'])?$_POST['serial']:"";
}
$article=isset($_POST['article'])?$_POST['article']:"";
$ID_depense=isset($_POST['ID_depense'])?$_POST['ID_depense']:"";


if (!isset($serial))
{
	$lib=isset($_POST['lib'])?$_POST['lib']:"";
	$prix=isset($_POST['prix'])?$_POST['prix']:"";
	$fourn=isset($_POST['fourn'])?$_POST['fourn']:"";
	$fournisseur=isset($_POST['fournisseur'])?$_POST['fournisseur']:"";
	$date=isset($_POST['date'])?$_POST['date']:"";
	$type="AM";
	list($jour, $mois,$annee) = preg_split('/\//', $date, 3);
	//$mois=isset($_POST['mois'])?$_POST['mois']:"";
	//$jour=isset($_POST['jour'])?$_POST['jour']:"";
	$fournisseur = stripslashes($fournisseur);

	if($lib==''|| $prix=='')
	{
		$message = $lang_oublie_champ;
		include('form_achatsmarchandises.php');
		exit;
	}
	if ($fourn=='' and $fournisseur=='default') { 
		$message = "$lang_dep_choi";
		include('form_achatsmarchandises.php');
		exit;  
	}
	if ($fournisseur =='default') 
	{
		$fourn= addslashes($fourn);
		mysql_select_db($db) or die ("Could not select $db database");
		$sql1 = "INSERT INTO " . $tblpref ."depense(fournisseur, lib, prix, date, type) VALUES ('$fourn', '$lib', '$prix', '$annee-$mois-$jour', '$type')";
		mysql_query($sql1) or die('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());
		$message = "$lang_dep_enr";
	}
	else
	{
		$fournisseur=addslashes($fournisseur);
		mysql_select_db($db) or die ("Could not select $db database");
		$sql1 = "INSERT INTO " . $tblpref ."depense(fournisseur, lib, prix, date, type) VALUES ('$fournisseur', '$lib', '$prix', '$annee-$mois-$jour', '$type')";
		mysql_query($sql1) or die('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());
		$message="$lang_dep_enr";  
	}

	$sql00 = "SELECT MAX(num) AS id_max FROM " . $tblpref ."depense";
	$query00 = mysql_query($sql00);
	$result00 = mysql_fetch_array($query00);
	$ID_depense = $result00['id_max'];
}
if (isset($serial)) {
	foreach ($serial as $num_serie) {
			$sql1 = "INSERT INTO " . $tblpref ."stock(article, serial, facture_achat, status) VALUES ('$article', '$num_serie', '$ID_depense', 'in')";
			mysql_query($sql1) or die('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());
	}
}
//Gestion des messages informatifs
include_once("include/message_info.php");
?>
<!--AJOUT STOCK-->
<div class="portion">
    <!-- TITRE - AJOUT STOCK -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-dropbox fa-stack-1x"></i>
        </span>
        Mise à jour du stock
        <span class="fa-stack fa-lg add" style="float:right" id="show_create">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_create">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - AJOUT STOCK -->
    <div class="content_traitement" id="create">
        <form name="formu2" method="post" action="form_achatsmarchandises_suite2.php" >
        <table class="base" width="100%">
            <tr> 
                <td class="right" width="30%">Article :</td>
                <td class="left" width="70%">
                    <?php
                    include("include/categorie_choix.php"); 
                    ?>
                    <input name="ID_depense" type="hidden" value="<? echo $ID_depense; ?>">
                </td>
            </tr>
            <tr> 
                <td class="right">Qty :</td>
                <td class="left"><input name="quanti" type="text" value="" size="8" class="styled"></td>
            </tr>   
        </table>
        <div class="center">
            <button class="button_act button--shikoba button--border-thin medium" type="submit" name="Submit" value="Ajouter"><i class="button__icon fa fa-plus"></i><span>Ajouter</span></button>
            <input type="hidden" name="prix" value="<?php echo $prix; ?>">
            <input type="hidden" name="lib" value="<?php echo $lib; ?>">
            <input type="hidden" name="fourn" value="<?php echo $fourn; ?>">
            <input type="hidden" name="fournisseur" value="<?php echo $fournisseur; ?>">
            <input type="hidden" name="date" value="<?php echo $date; ?>">
      	</div>
        </form>
        <div class="center">
			<? if (isset($serial)) { ?>
            <button class="button_act button--shikoba button--border-thin medium" name="terminer" onclick="redirection()"><i class="button__icon fa fa-check"></i><span>Terminer</span></button>
            <? } ?>
        </div>
	</div>
</div>
<!--DEJA ENCODES-->
<div class="portion">
    <!-- TITRE - DEJA ENCODES -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-list fa-stack-1x"></i>
        </span>
        Articles déjà encodés
        <span class="fa-stack fa-lg add" style="float:right" id="show_list">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_list">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - DEJA ENCODES -->
    <div class="content_traitement" id="list">
        <table width="100%" class="base" id="listing">
			<thead>
            <tr>
                <th class="">N°</th>
                <th class="">Article</th>
                <th class="">PA</th>
                <th class="">Stock</th>
                <th class="">Serial</th>  
            </tr>
            </thead>
            <tbody>
            <?php
            $sql = "SELECT * FROM ". $tblpref ."stock WHERE facture_achat = '$ID_depense'";
            $req = mysql_query($sql);
            $nombre = 1;
            while($data = mysql_fetch_array($req))
            {
                $num = $data['ID'];
                $article = $data['article'];
                $serial = $data['serial'];
                $sql2 = "SELECT article, prix_htva, stock FROM " . $tblpref ."article WHERE num = '$article'";
                $req2 = mysql_query($sql2);
                $data2 = mysql_fetch_array($req2);
                $nom_article = $data2['article'];
                $PA = $data2['prix_htva'];
                $stock = $data2['stock'];
                $nombre = $nombre +1;
                if($nombre & 1){
                    $line="0";
                }else{
                    $line="1"; 
                } 
                ?>
                <tr class="">
                    <td class=""><?php echo $num; ?></td>
                    <td class=""><?php echo $nom_article; ?></td>
                    <td class=""><?php echo $PA; ?> &euro; HTVA </td>
                    <td class=""><?php echo $stock; ?></td>		
                    <td class=""><?php echo $serial; ?></td>
                </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
	</div>
</div>
<?php 
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>

