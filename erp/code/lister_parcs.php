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
//Gestion des messages informatifs
include_once("include/message_info.php");
?>
<!--LISTE EXISTANT-->
<div class="portion">
    <!-- TITRE - LISTE -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-list fa-stack-1x"></i>
        </span>
        Liste des parcs informatiques
        <span class="fa-stack fa-lg add" style="float:right" id="show_liste">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_liste">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <div class="content_traitement" id="liste">
        <table class="base" width="100%" id="listing">
            <thead>
            <tr>
                <th class="" width="26%">Client</th>
                <th class="" width="10%"><i class="fa fa-server fa-fw"></i> Serveur</th>
                <th class="" width="10%"><i class="fa fa-desktop fa-fw"></i> PC</th>
                <th class="" width="10%"><i class="fa fa-laptop fa-fw"></i> Notebook</th>
                <th class="" width="10%"><i class="fa fa-mobile fa-fw"></i> Mobile</th>
                <th class="" width="10%"><i class="fa fa-print fa-fw"></i> Imprimante</th>
                <th class="" width="8%">Contrat</th>
                <th class="" width="8%">Monitoring</th>
                <th class="" width="8%">Action</th>
            </tr>
            </thead>
            <tbody>
            <?
			//On récupère les contrats actifs.
			$sql ="SELECT *";
			$sql.=" FROM ".$tblpref."parcs as p";
			$sql.=" LEFT JOIN ".$tblpref."client as c ON c.num_client = p.cli";
			$sql.=" ORDER BY date_creation DESC";
			$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
            while($obj = mysql_fetch_object($req))
            {
				$sql_c="SELECT * FROM ".$tblpref."contrat_maintenance WHERE id_parc=".$obj->id." AND actif='1'";
				$req_c=mysql_query($sql_c);
				$num_c=mysql_num_rows($req_c);
				if ($num_c > 0) {
					$obj_c=mysql_fetch_object($req_c);
					$sign=$obj_c->sign;
					if ($sign == 1) {
						$contrat='<i class="fa fa-check yes"></i> Sign&eacute';
					}
					else {
						$contrat='<i class="fa fa-tag act"></i> Proposition';
					}
				}
				else {
					$contrat='<i class="fa fa-times no"></i> non';
				}
				$sql_m="SELECT * FROM ".$tblpref."monitoring WHERE id_parc=".$obj->id." AND actif='1'";
				$req_m=mysql_query($sql_m);
				$num_m=mysql_num_rows($req_m);
				if ($num_m > 0) {
					$obj_m=mysql_fetch_object($req_m);
					$sign=$obj_m->sign;
					if ($sign == 1) {
						$monitoring='<i class="fa fa-check yes"></i> Sign&eacute;';
					}
					else {
						$monitoring='<i class="fa fa-tag act"></i> Proposition';
					}
				}
				else {
					$monitoring='<i class="fa fa-times no"></i> non';
				}
                ?>
                <div id="del_parc_info_<?php echo $obj->id;?>" class="dialog-overlay">
                    <div class="dialog-card">
                        <div class="dialog-question-sign">
                        	<i class="fa fa-question fa-2x"></i>
                        </div>
                        <div class="dialog-info">
                            <h5>Supprimer le parc informatique de <?php echo $obj->nom;?> ?</h5>
                            <p>Supprimer le parc, supprimera aussi les éventuels monitoring et contrat de maintenance associés.</p>
                            <a href="./include/form/delete_parc.php?id=<?php echo $obj->id;?>"><button class="dialog-confirm-button">Oui</button></a>
                            <button class="dialog-reject-button">Non</button>
                        </div>
                    </div>
                </div>
                <tr class="">
                    <td class="" align="center"><?php echo $obj->nom; ?></td>
                    <td class="" align="center"><?php echo $obj->nbr_server; ?></td>
                    <td class="" align="center"><?php echo $obj->nbr_pc; ?></td>
                    <td class="" align="center"><?php echo $obj->nbr_laptop; ?></td>
                    <td class="" align="center"><?php echo $obj->nbr_mobile; ?></td>
                    <td class="" align="center"><?php echo $obj->nbr_printer; ?></td>
                    <td class="" align="center"><?php echo $contrat; ?></td>
                    <td class="" align="center"><?php echo $monitoring; ?></td>
                    <td class="">
                    	<a href="./fiche_parc.php?id=<?php echo $obj->id;?>" class="no_effect">
                        	<i class="fa fa-external-link-square fa-fw fa-2x action" title="Afficher les d&eacute;tails"></i>
                        </a>
                        <a class="dialog-show-button no_effect" data-show-dialog="del_parc_info_<?php echo $obj->id;?>" href="#">
                        	<i class="fa fa-trash fa-fw fa-2x del" title="Supprimer le parc et les contrats attenants"></i>
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

