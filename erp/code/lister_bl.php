<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script>
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
	$("#hide_filter").hide();
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
});
<!-- DT LISTE BL -->
$(document).ready(function() {
    $('#listed').DataTable( {
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
//Gestion des messages informatifs
include_once("include/message_info.php");
$mois = date("m");
$annee = date("Y");
//pour le formulaire
$mois_1=isset($_POST['mois_1'])?$_POST['mois_1']:"";
$annee_1=isset($_POST['annee_1'])?$_POST['annee_1']:"";
//Si aucun filtre n'est appliqué on utilise les mois/annees courants
if ($mois_1=='') {
 	$mois_1= $mois ;
} 
if ($annee_1=='') { 
 	$annee_1= $annee ; 
}
$calendrier = calendrier_local_mois ();
$sql = "SELECT num_client, num_bl, tot_htva, tot_tva, nom, DATE_FORMAT(date,'%d/%m/%Y') AS date,(tot_htva + tot_tva) as ttc
		 FROM " . $tblpref ."bl 
		 RIGHT JOIN " . $tblpref ."client on " . $tblpref ."bl.client_num = num_client 
		 WHERE MONTH(date) = $mois_1 AND Year(date)=$annee_1 
		 ";
if ( isset ( $_GET['ordre'] ) && $_GET['ordre'] != '')
{
	$sql .= " ORDER BY " . $_GET[ordre] . " DESC";
}
else {
	$sql .= "ORDER BY num_bl DESC ";
}
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
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
    <!-- CONTENT - FILTRE -->
    <div class="content_traitement disp_none" id="filter">
        <form action="lister_bl.php" method="post">
        <table class="base" align="center" width="100%">
            <tr>
            	<td class="right">Choix du mois :</td>
                <td class="left"> 
                	<div class="styled-select-inline" style="width:20%;">
                    <select name="mois_1" class="styled-inline">
                    <?php 
                    for ($i=1;$i<=12;$i++) {
                    ?>
                        <option value="<?php echo $i; ?>"><?php echo ucfirst($calendrier [$i]); ?></option>
                    <?php
                    }
                    ?>
                    </select> 
                    </div>
                </td>
          	</tr>
            <tr>
            	<td class="right">Choix de l'ann&eacute;e :</td>
                <td class="left">
                	<div class="styled-select-inline" style="width:20%;">
                    <select name="annee_1" class="styled-inline">
                        <option value="<?php $date=(date("Y")-2);echo"$date"; ?>"><?php $date=(date("Y")-2);echo"$date"; ?></option>
                        <option value="<?php $date=(date("Y")-1);echo"$date"; ?>"><?php $date=(date("Y")-1);echo"$date"; ?></option>
                        <option value="<?php $date=date("Y");echo"$date"; ?>"><?php $date=date("Y");echo"$date"; ?></option>
                        <option value="<?php $date=(date("Y")+1);echo"$date"; ?>"><?php $date=(date("Y")+1);echo"$date"; ?></option>
                        <option value="<?php $date=(date("Y")+2);echo"$date"; ?>"><?php $date=(date("Y")+2);echo"$date"; ?></option>
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
<!--FILTRES-->
<div class="portion">
    <!-- TITRE - LISTE -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-list fa-stack-1x"></i>
        </span>
        Liste des bons de livraison
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
    <div class="content_traitement" id="list">
        <table class="base"  width="100%" id="listed">
        	<thead>
            <tr> 
                <th class=""><?php echo $lang_numero;?></th>
                <th class=""><?php echo $lang_client;?></th>
                <th class=""><?php echo $lang_date;?></th>
                <th class=""><?php echo $lang_total_h_tva;?></th>
                <th class=""><?php echo $lang_total_ttc;?></th>
                <th class=""><?php echo $lang_action;?></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $nombre = 1;
            while($data = mysql_fetch_array($req))
            {
                $num_bl = $data['num_bl'];
                $total = $data['tot_htva'];
                $tva = $data["tot_tva"];
                $date = $data["date"];
                $nom = $data['nom'];
                $nom = $nom;
                $nom_html = htmlentities (urlencode ($nom)); 
                $num_client = $data['num_client'];
                $ttc = $data['ttc'];
                $nombre = $nombre +1;
                if($nombre & 1){
                    $line="0";
                }
                else{
                    $line="1"; 
                }
                ?>
                <tr class="">
                    <td class=""><?php echo "$num_bl"; ?></td>
                    <td class=""><?php echo "$nom"; ?></td>
                    <td class=""><?php echo "$date"; ?></td>
                    <td class=""><?php echo montant_financier($total); ?></td>
                    <td class=""><?php echo montant_financier($ttc); ?></td>
                    <td class="">
                        
                        <a href="fpdf/bl_pdf.php?num_bl=<?php echo $num_bl; ?>&nom=<?php echo $nom_html; ?>&pdf_user=adm" target="_blank" class="no_effect">
                        	<i class="fa fa-print fa-fw fa-2x action" title="Imprimer"></i>
                        </a>
						<?
                        if ($mail != '' ) {
                        ?>
                            <form action="fpdf/bl_pdf.php" method="post" onClick="return confirmDelete('<?php echo"$lang_con_env_pdf $num_bl"; ?>')" style="display:inline-block;vertical-align:top;margin-left:5px;">
                                <input type="hidden" name="num_bl" value="<?php echo $num_bl; ?>" />
                                <input type="hidden" name="nom" value="<?php echo $nom; ?>" />
                                <input type="hidden" name="user" VALUE="adm">
                                <input type="hidden" name="ext" VALUE=".pdf">
                                <input type="hidden" name="mail" VALUE="y">
                                <button class="icons fa-envelope fa-fw fa-2x action" title="Envoyer au client"></button>
                            </form>	
                        <?php 
                        }
                        ?>  
                        <a href="edit_bl.php?num_bl=<?php echo $num_bl;?>" class="no_effect">
                        	<i class="fa fa-pencil fa-fw fa-2x action"></i>
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
