<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script>
/* SHOW / HIDE */
$(document).ready(function() {
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
<!-- DT LISTE CLIENTS -->
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
///FINHEAD
//Messages informatifs
if (isset($_REQUEST['add'])) {
	if ($_REQUEST['add'] == 'ok') {
    $message = "Panier correctement ajout&eacute;.";
	}
	else if ($_REQUEST['add'] == 'del') {
    $message = "Panier supprim&eacute;.";
	}
}
//Gestion des messages informatifs
include_once("include/message_info.php");
$sql = " SELECT * FROM " . $tblpref ."client WHERE actif != 'non' ";
if ( isset ( $_GET['ordre'] ) && $_GET['ordre'] != '')
{
	$sql .= " ORDER BY " . $_GET[ordre] . " ASC";
}
else {
	$sql .= "ORDER BY nom ASC ";
}
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
?>
<!-- LISTE DE CLI -->
<div class="portion">
    <!-- TITRE - LISTE DE CLI -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-list fa-stack-1x"></i>
        </span>
        <?php echo $lang_clients_existants; ?>
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
    <!-- CONTENT - LISTE DE CLI -->
    <div class="content_traitement" id="list">
        <table class="base" width="100%" id="listing">
        	<thead>
            <tr>
                <th class=""><?php echo $lang_civ; ?></th>
                <th class=""><?php echo $lang_nom; ?></th>
                <th class=""><?php echo $lang_complement; ?></th>
                <th class=""><?php echo $lang_rue; ?></th>
                <th class=""><?php echo $lang_code_postal; ?></th>
                <th class=""><?php echo $lang_ville; ?></th>
                <th class=""><?php echo $lang_numero_tva; ?></th>
                <th class=""><?php  echo $lang_tele;?></th>
                <th class="">GSM</th>
                <th class=""><?php echo $lang_fax;?></th>
                <th class=""><?php echo $lang_email; ?></th>
                <th class=""><?php echo $lang_action; ?></th>
            </tr>
            </thead>
            <tbody>
            <?php
            while($data = mysql_fetch_array($req))
            {
                $nom = $data['nom'];
                $nom_html= addslashes($nom);
                $nom2 = $data['nom2'];
                $rue = $data['rue'];
                $rue = stripslashes($rue);
                $numero = $data['numero'];
                $boite = $data['boite'];
                $ville = $data['ville'];
                $cp = $data['cp'];
                $tva = $data['num_tva'];
                $mail =$data['mail'];
                $num = $data['num_client'];
                $civ = $data['civ'];
                $tel = $data['tel'];
                $gsm = $data['gsm'];
                $fax = $data['fax'];
                ?>
                <tr class="">
                    <td class=""><?php echo $civ; ?></td>
                    <td class=""><?php echo $nom; ?></td>
                    <td class=""><?php echo $nom2; ?></td>
                    <td class=""><?php echo $rue." ".$numero; if ($boite !=''){ echo "/".$boite;} ?></td>
                    <td class=""><?php echo $cp; ?></td>
                    <td class=""><?php echo $ville; ?></td>
                    <td class=""><?php echo $tva; ?></td>
                    <td class=""><?php echo $tel; ?></td>
                    <td class=""><?php echo $gsm; ?></td>
                    <td class=""><?php echo $fax; ?></td>
                    <td class=""><a href="mailto:<?php echo $mail; ?>" ><?php echo "$mail"; ?></a></td>
                    <td class="" width="8%">
                    	<a href='edit_client.php?num=<?php echo "$num" ?>' class="no_effect">
                        	<i class="fa fa-pencil fa-fw fa-2x action"></i>
                        </a>
                        <a href='del_client.php?num=<?php echo "$num"; ?>' onClick="return confirmDelete('<?php echo"$lang_cli_effa $nom_html ?"; ?>')" class="no_effect">
                        	<i class="fa fa-trash fa-fw fa-2x del"></i>
                        </a>
                    </td>
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