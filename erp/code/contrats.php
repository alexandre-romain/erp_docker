<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script>
$(function() {
	$( ".datepicker" ).datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: "dd-mm-yy" 
	})
});
/* DATATABLES PANIERS EXISTANTS */
/* Formatting function for row details - modify as you need */
function format ( d ) {
    // `d` is the original data object for the row
    return '<div id="cont_details'+d.id+'" class="container_details"></div>';
} 
 
$(document).ready(function() {			   
    var table = $('#list_contrat').DataTable( {
		"pageLength": 50, //nbre de lignes affichées par défaut
        "columns": [
            {
                "className":      'details-control',
                "orderable":      true,
                "data":           null,
                "defaultContent": '&nbsp;',
				"width":		  "5%"	
            },		
			{ "data": "id","width": "5%", "visible" : false },
            { "data": "client", "width": "10%" },
			{ "data": "debut", "width": "7.5%" },
			{ "data": "periodicite", "width": "7.5%" },
            { "data": "echeance", "width": "7.5%" },
            { "data": "com_fact", "width": "20%" },
            { "data": "com_int", "width": "20%" },						
			{ "data": "action", "width": "10%" }
        ],
        "order": [[2, 'asc'],[5, 'asc']], //ordonne par client, puis par echeance
		"language": {
          "lengthMenu": 'Afficher <div class="styled-select-dt"><select class="styled-dt">'+
            '<option value="10">10</option>'+
            '<option value="20">20</option>'+
            '<option value="30">30</option>'+
            '<option value="40">40</option>'+
            '<option value="50">50</option>'+
            '<option value="-1">All</option>'+
            '</select></div> lignes'
        }
    } );
     
    // Add event listener for opening and closing details
    $('#list_contrat tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
 
        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
			//On récupère l'id de la ligne.
			var idline = row.data().id;
			det_contrat(idline);
        }
    } );
} );
/* SHOW / HIDE */
$(document).ready(function() 
	{
	$("#hide_add").hide();
	$("#hide_add").click(function()
		{
		$("#add").hide(500);	
		$("#hide_add").hide();
		$("#show_add").show();
		});
	$("#show_add").click(function(){
		$("#add").show(500);	
		$("#hide_add").show();
		$("#show_add").hide();
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
</script>
<?php 
//Ferme le <head>, ouvre le <body> & inclus le menu + ouverture content
include_once("include/finhead.php");
///FINHEAD
//Messages informatifs
if (isset($_REQUEST['add'])) {
	if ($_REQUEST['add'] == 'ok') {
    $message = "contrat correctement ajout&eacute;.";
	}
	else if ($_REQUEST['add'] == 'del') {
    $message = "contrat supprim&eacute;.";
	}
}
//Gestion des messages informatifs
include_once("include/message_info.php");
?>

<!--MODALE-->
<div id="modale">
    <div class="popup_block">
        <a class="close" href="#noWhere">
        	<span class="fa-stack fa-lg fa-2x btn_close del">
              <i class="fa fa-circle fa-stack-2x"></i>
              <i class="fa fa-times fa-stack-1x fa-inverse"></i>
            </span>
      	</a>
        <div id="cont_modale">
        	<div class="center"><i class="fa fa-spinner fa-3x fa-pulse"></i></div>
        </div>
    </div>
</div>
<!-- AJOUT DE PANIER -->
<div class="portion">
    <!-- TITRE - AJOUT DE PANIER -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-plus fa-stack-1x"></i>
        </span>
        Cr&eacute;er un contrat <span class="fa-stack fa-lg add" style="float:right" id="show_add">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_add">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - AJOUT DE PANIER -->
    <div class="content_traitement disp_none" id="add">
        <form action="./include/form/add_contrat.php" method="post">
        <div class="portion_subtitle"><i class="fa fa-shopping-cart fa-fw"></i> Caract&eacute;ristiques du contrat</div>
        <table class="base" width="100%" id="">
            <tbody>
                <tr> 
                    <td class="right" width="50%"><?php echo "$lang_client"; ?> :</td>
                    <td class="left" width="50%">
                        <?php 
                        include_once("include/choix_cli.php");
                        ?> 
                    </td>
                </tr>
                <tr>
                    <td class="right">Prochaine &eacute;ch&eacute;ance :</td>
                    <td class="left"><input type="text" class="datepicker styled" name="echeance" id="echeance" value="<?php echo date('d-m-Y');?>"></td>
                </tr>
                <tr>
                    <td class="right">P&eacute;riodicit&eacute; facturation  :</td>
                    <td class="left">
                    	<div class="styled-select-inline" style="width:41%">
                    	<select class="styled-inline" name="periodicite" id="periodicite">
                        	<option value="1">1 mois</option>
							<option value="3" selected>3 mois</option>
                            <option value="6">6 mois</option>
                            <option value="12">1 an</option>
                        </select>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="right">Commentaire facture :</td>
                    <td class="left"><input type="text" class="styled" name="com_fact" id="com_fact" value=""></td>
                </tr>				
                <tr>
                    <td class="right">Commentaire INTERNE :</td>
                    <td class="left"><input type="text" class="styled" name="com_int" id="com_int" value=""></td>
                </tr>			
         	</tbody>
    	</table>
        <div class="portion_subtitle"><i class="fa fa-cog fa-fw"></i> Article du contrat | Attention : Prix de l'article = prix mensuel (PA = prix, marge = 0)</div>
        <table class="base" width="100%" id="add_panier">
            <tbody id="added_articles">
                <tr>
                    <td class="" width="20%"><i class="fa fa-search fa-fw"></i> <input type="text" id="search_art_1" onKeyUp="rech_art(1)" class="styled"></td>
                    <td class="" width="50%">
                    	<div class="styled-select-inline" style="width:100%">
                    	<select name="articles[1][name]" id="articles1" class="styled-inline">
                        	<option value="">Veuillez d'abord effectuer une recherche...</option>
                        </select>
                    	</div>
                    </td>
                    <td width="20%"><input type="hidden" name="articles[1][qty]" id="qty_1" class="styled" value="1"></td>
                    <td width="10%"></td>
                </tr>
            </tbody>
        </table>
        <div class="center">
            <button class="button_act button--shikoba button--border-thin medium" type="submit">
            	<i class="button__icon fa fa-floppy-o"></i><span>Enregistrer</span>
            </button>
        </div>
        </form>
        <!--Variable récupérée via JS pour injecter les lignes avec un id cohérent et unique-->
        <input type="hidden" id="nbr_lines" value="1">
	</div>
</div>
<!-- LISTE DES PANIERS -->
<div class="portion">
    <!-- TITRE - LISTE DES PANIERS -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-list fa-stack-1x"></i>
        </span>
        Liste des contrats <span class="fa-stack fa-lg add" style="float:right" id="show_list">
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
    <!-- CONTENT - LISTE DES PANIERS -->
    <div class="content_traitement" id="list">
        <table class="base" width="100%" id="list_contrat">
            <thead>
                <tr>
                	<th></th>
                    <th>ID</th>
                    <th>Client</th>
                    <th>D&eacute;but</th>
                    <th>P&eacute;riodicit&eacute;</th>
                    <th>&Eacute;ch&eacute;ance</th>
					<th>Commentaire facture</th>
					<th>Commentaire INTERNE</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql="SELECT p.echeance as echeance, p.id as id, p.debut as debut, p.periodicite as periodicite, p.article as article, c.nom as nom, p.com_facture as com_fact, p.com_interne as com_int";
                $sql.=" FROM ".$tblpref."contrat as p";
                $sql.=" LEFT JOIN ".$tblpref."client as c ON c.num_client = p.id_cli";
                $sql.=" ORDER by p.id_cli, p.echeance ASC";
                $req=mysql_query($sql);
                while($obj=mysql_fetch_object($req)) {
                    
                   ?>
                    <tr>
                    	<td></td>
                        <td><?php echo $obj->id;?></td>
                        <td><?php echo $obj->nom;?></td>
                        <td><?php echo dateUSA_to_dateEU($obj->debut);?></td>
                        <td><?php echo $obj->periodicite;?> mois</td>
                        <td><?php echo dateUSA_to_dateEU($obj->echeance);?></td>
						<td><?php echo $obj->com_fact;?></td>
						<td><?php echo $obj->com_int;?></td>
                        <td>
                            <a href="./include/form/del_contrat.php?id=<?php echo $obj->id;?>" class="no_effect" onClick="return confirmDelete('Voulez-vous vraiment supprimer le contrat de <?php echo $obj->nom;?>')">
                            	<i class="fa fa-trash fa-fw fa-2x del" title="Supprimer"></i>
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
