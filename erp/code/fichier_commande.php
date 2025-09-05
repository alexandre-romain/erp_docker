<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<style type="text/css" media="screen">
	@import "include/css/fichier_commande.css";
</style>
<script type="text/javascript" src="include/js/serial.js"></script>	
<script>
$(document).ready(function() {
	$("#overlay").hide();						//On cache l'overlay pour l'introduction des sérials lors du chargement de la page
	$("#modal").hide();							//On cache la modale pour l'introduction des sérials lors du chargement de la page
	$("#close").click(function hide_note() { 	
		location.reload();						//Lors du click sur la croix de la modale, on recharge la page, de manière à afficher correctement l'état de la ligne de commande
	});	
	$( "#show_liste" ).hide();
	$( "#show_liste" ).click(function() {
		$( "#liste" ).show(500);
		$( "#show_liste" ).hide();
		$( "#hide_liste" ).show();
	});
	$( "#hide_liste" ).click(function() {
		$( "#liste" ).hide(500);
		$( "#show_liste" ).show();
		$( "#hide_liste" ).hide();
	});
	$( "#show_com" ).hide();
	$( "#show_com" ).click(function() {
		$( "#com" ).show(500);
		$( "#show_com" ).hide();
		$( "#hide_com" ).show();
	});
	$( "#hide_com" ).click(function() {
		$( "#com" ).hide(500);
		$( "#show_com" ).show();
		$( "#hide_com" ).hide();
	});
});
<!-- DT FICHIER COMMANDES -->
$(document).ready(function() {
    $('#list').DataTable( {
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
		"order": [[ 2, "desc" ]]
  	});
} );
<!-- FORM VIA AJAX -->
$(document).ready(function() { 
	$('.autosubmit').ajaxForm(function() {  

	}); 
});

$(document).ready(function() {
	/* EDIT DU NOM AFFICHÉ (SERA SUBSTITUE AU NOM IMPORTE SI EXISTANT) */
	$('.edit_fourn').editable('./include/ajax/edit_fourn.ajax.php', {
		 loadurl : './include/json/fournisseurs.json.php',
		 type   : 'select',
		 submit : 'OK'
	 });
});	
</script>
<?php 
//Ferme le <head>, ouvre le <body> & inclus le menu + ouverture content
include_once("include/finhead.php");
//SI EDITION
if (isset($_REQUEST['step']) && $_REQUEST['step'] == 'edit') {
	$id=$_REQUEST['id'];
	$article=$_REQUEST['article'];
	$quanti=$_REQUEST['quanti'];
	$pv=$_REQUEST['pv'];
	$note=$_REQUEST['note'];
	//On va récupérer les totaux actuels de l'article.
	$sql="SELECT * FROM ".$tblpref."cont_bon WHERE num='".$id."'";
	$req=mysql_query($sql);
	$obj=mysql_fetch_object($req);
	$old_prix_ht	=$obj->tot_art_htva;
	$old_tva		=$obj->to_tva_art;
	$old_recupel	=$obj->tot_art_recupel;
	$old_reprobel	=$obj->tot_art_reprobel;
	$old_bebat		=$obj->tot_art_bebat;
	$id_bon			=$obj->bon_num;
	//On va récupérer les totaux du bon
	$sql="SELECT * FROM ".$tblpref."bon_comm WHERE num_bon = '".$id_bon."'";
	$req=mysql_query($sql);
	$obj=mysql_fetch_object($req);
	$old_tot_htva		=$obj->tot_htva;
	$old_tot_tva		=$obj->tot_tva;
	$old_tot_recupel	=$obj->tot_recupel;
	$old_tot_reprobel	=$obj->tot_reprobel;
	$old_tot_bebat		=$obj->tot_bebat;
	//On va récupérer les prix du nouvel article
	$sql="SELECT * FROM ".$tblpref."article WHERE num='".$article."'";
	$req=mysql_query($sql);
	$obj=mysql_fetch_object($req);
	if ($pv == '') {
		$marge			=$obj->marge;
		$marge_calc='1.'.$marge;
		$prix_art_htva	=$obj->prix_htva*$marge_calc;
	}
	else {
		$prix_art_htva =$pv;
	}
	$taux_tva		=$obj->taux_tva;
	$recupel		=$obj->recupel;
	$reprobel		=$obj->reprobel;
	$bebat			=$obj->bebat;
	$tva=($prix_art_htva/100)*$taux_tva;
	//On calcule les nouveaux totaux.
	$new_tot_htva	=($old_tot_htva-$old_prix_ht)+($prix_art_htva*$quanti);
	$new_tot_tva	=($old_tot_tva-$old_tva)+($tva*$quanti);
	$new_bebat		=($old_tot_bebat-$old_bebat)+($bebat*$quanti);
	$new_reprobel	=($old_tot_reprobel-$old_reprobel)+($reprobel*$quanti);
	$new_recupel	=($old_tot_recupel-$old_recupel)+($recupel*$quanti);
	//On update le bon
	$sql="UPDATE ".$tblpref."bon_comm SET tot_htva='".$new_tot_htva."', tot_tva='".$new_tot_tva."', tot_recupel='".$new_recupel."', tot_reprobel='".$new_reprobel."', tot_bebat='".$new_bebat."' WHERE num_bon = '".$id_bon."'";
	$req=mysql_query($sql);
	//On update le cont_bon
	$sql="UPDATE ".$tblpref."cont_bon SET article_num='".$article."', quanti='".$quanti."', tot_art_htva='".$prix_art_htva*$quanti."', to_tva_art='".$tva*$quanti."', tot_art_recupel='".$recupel*$quanti."', tot_art_reprobel='".$reprobel*$quanti."', tot_art_bebat='".$bebat*$quanti."', p_u_jour='".$prix_art_htva."', note='".$note."' WHERE num='".$id."'";
	$req=mysql_query($sql);
}
?>
<!--COMMANDER-->
<div class="portion">
    <!-- TITRE - COMMANDER -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-keyboard-o fa-stack-1x"></i>
        </span>
        Cr&eacute;ation commande fournisseur
        <span class="fa-stack fa-lg add" style="float:right" id="show_com">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_com">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <div class="content_traitement" id="com">
    	<form action="./fichier_commande_suite.php" method="post">
    	<table class="base" width="100%">
            <tr>
                <td class="right" width="50%">Choix du fournisseur :</td>
                <td class="left" width="50%">
                	<div class="styled-select-inline" style="width:40%">
                    <select class="styled-inline" name="fourn" required>
                    	<option value='tout'>Tous</option>
                        <?php
                        $sql="SELECT * FROM ".$tblpref."fournisseurs WHERE actif='1'";
                        $req=mysql_query($sql);
                        while ($obj = mysql_fetch_object($req)) {
                            ?>
                            <option value="<?php echo $obj->id;?>" <?php if($obj->nom == 'TechData') {echo 'selected="selected"';}?>><?php echo $obj->nom;?></option>
                            <?php
                        }
                        ?>
                    </select>
                    </div>
                </td>
            </tr>
        </table>
        <div class="center">
        <button class="button_act button--shikoba button--border-thin medium" type="submit"><i class="button__icon fa fa-check"></i><span>Continuer</span></button>
        </div>
        </form>
    </div>
</div>

<!--LISTE-->
<div class="portion">
    <!-- TITRE - LISTE -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-truck fa-stack-1x"></i>
        </span>
        Liste des articles &agrave; commander/r&eacute;ceptionner
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
    	<table class="base" width="100%" id="list">
            <thead>
                <tr>
                    <th width="5%">Client</th>
                    <th>Cdes. num.</th>        
                    <th>Date cde.</th>
                    <th style="width:5%">Fournisseur</th>
                    <th style="width:10%">Article</th>
                    <th style="width:6.5%">PartNumber</th>
                    <th>Qty.</th>
                    <th style="width:6.5%">P.A. Uni.</th>
                    <th style="width:6.5%">P.A. Tot.</th>
                    <th style="width:6.5%">P.V. Uni.</th>
                    <th style="width:6.5%">P.V. Tot.</th>
                    <th style="width:6.5%;">Actions</th>
                    <th style="width:7%">Command&eacute;</th>
                    <th style="width:7%">Re&ccedil;u</th>
                    <th style="width:7%">Livr&eacute;</th>
                </tr>
            </thead>
            <tbody>
			<?php
            //Ici on fait la requête permettant de lister les éléments en attente de commande/réception.
            // On récupère les lignes de la table cont_bon qui ne sont soit pas passée en bl, ou passée en bl mais non facturées.
            $sql = "SELECT DISTINCT c.nom as cnom, a.article as aarticle, a.reference as partnumber, cb.quanti as cbquanti, a.prix_htva as aprix_htva, cb.p_u_jour as cbp_u_jour, cb.tot_art_htva as cbtot_art_htva, cb.commande as cbcommande, cb.recu as cbrecu, f.nom as cbfourn, cb.note as cbnote, bc.date as bcdate, cb.num as cbnum, bc.num_bon as num_bon, a.num as anum, cb.livre as cblivre, cb.num as cbid, a.num as aid";
            $sql .= " FROM ".$tblpref."cont_bon as cb";
            $sql .= " LEFT JOIN ".$tblpref."article as a ON a.num=cb.article_num ";
            $sql .= " LEFT JOIN ".$tblpref."bon_comm as bc ON bc.num_bon=cb.bon_num";
            $sql .= " LEFT JOIN ".$tblpref."client as c ON c.num_client=bc.client_num ";
            $sql .= " LEFT JOIN ".$tblpref."bl as bl ON bc.num_bon=bl.bon_num ";
			$sql .= " LEFT JOIN ".$tblpref."fournisseurs as f ON f.id = cb.fourn";
            $sql .= " WHERE ( (bl.fact_num = '0') OR (bc.bl = '0') ) AND a.marge != '0' AND bc.mask_list != 1";
            $req=mysql_query($sql);
            $i=0;
            while ($obj = mysql_fetch_object($req)) {
				$pv_uni=$obj->cbtot_art_htva/$obj->cbquanti;
            	?>
            	<div id="note<?php echo $obj->cbid;?>" class="dialog-overlay">
                    <div class="dialog-card" style="width:90%;left:5%;margin-left:0;">
                        <div class="dialog-question-sign"><i class="fa fa-pencil"></i></div>
                        <div class="dialog-info" style="max-width:90%">
                            <h6 style="color:#2c3e50">Editer la ligne | BC : <?php echo $obj->num_bon;?></h6>
                            <form action="./fichier_commande.php" method="post">
                            	<?php
								if ($obj->cbcommande == '0000-00-00' || $obj->cbcommande == NULL) {
									?>
                                    <label class="inline" style="width:150px;">Rech. Article :</label>
                                    <input type="text" id="rech<?php echo $obj->cbid;?>" onChange="showarticleid(<?php echo $obj->cbid;?>)" onKeyUp="showarticleid(<?php echo $obj->cbid;?>)" autocomplete="off" class="styled_border"/>
                                    <br/><br/>
                                    <label class="inline" style="width:150px;">Article :</label>
                                    <select id="article<?php echo $obj->cbid;?>" name="article" size="10" class="styled-multi" onchange="price_art(<?php echo $obj->cbid;?>)" required>
                                        <option value="<?php echo $obj->aid; ?>" selected><?php echo $obj->aarticle; ?></option>
                                    </select>
                                    <br/><br/>
                                    <label class="inline" style="width:150px;">Quantit&eacute; :</label><input type="text" class="styled_border" name="quanti" value="<?php echo $obj->cbquanti; ?>"/><br/><br/>
                                    <label class="inline" style="width:150px;">P.V. Uni (HTVA) :</label><input type="text" class="styled_border" id="pv<?php echo $obj->cbid;?>" name="pv" value="<?php echo $pv_uni; ?>"/>
                                	<?php
								}
								else {
									?>
                                    <label class="inline" style="width:150px;">Article :</label>
                                    <select id="article<?php echo $obj->cbid;?>" name="article" class="styled-multi" onchange="price_art(<?php echo $obj->cbid;?>)" required readonly>
                                        <option value="<?php echo $obj->aid; ?>" selected><?php echo $obj->aarticle; ?></option>
                                    </select>
                                    <br/><br/>
                                    <label class="inline" style="width:150px;">Quantit&eacute; :</label><input type="text" class="styled_border" name="quanti" value="<?php echo $obj->cbquanti; ?>" readonly/><br/><br/>
                                    <label class="inline" style="width:150px;">P.V. Uni (HTVA) :</label><input type="text" class="styled_border" id="pv<?php echo $obj->cbid;?>" name="pv" value="<?php echo $pv_uni; ?>" readonly/><br/>
                                    <label class="inline" style="width:150px;">&nbsp;</label><p style="display:inline-block">L'article ayant d&eacute;j&agrave; &eacute;t&eacute; command&eacute; et/ou re&ccedil;u il est impossible de le modifier.<br/>Vous pouvez n&eacute;anmoins toujours &eacute;diter la note ou placer l'article en B.O.</p>
                                    <?php
								}
								?>
                                <br/><br/>
                                <label class="inline" style="width:150px;">Note :</label>
                            	<textarea name="note" style="margin-bottom:2%" cols="100" rows="6" class="styled_border"><?php echo $obj->cbnote; ?></textarea><br/><br/>
                            	<button class="dialog-confirm-button" type="submit"><i class="fa fa-pencil fa-fw"></i> Modifier</button>
                				<button class="dialog-reject-button" type="button"><i class="fa fa-times fa-fw"></i> Annuler</button>
                            	<input type="hidden" name="step" value="edit">
                                <input type="hidden" name="id" value="<?php echo stripslashes($obj->cbid);?>">
                            </form>
                        </div>
                    </div>
                </div>
                
                <div id="bo<?php echo $obj->cbid;?>" class="dialog-overlay">
                    <div class="dialog-card">
                        <div class="dialog-question-sign"><i class="fa fa-calendar-o"></i></div>
                        <div class="dialog-info" style="max-width:90%">
                            <h6 style="color:#2c3e50">Placer la ligne en B.O. | BC : <?php echo $obj->num_bon;?></h6>
                            <label class="inline" style="width:150px;">Date dispo. :</label>
                            <input type="text" class="styled_border datepicker" id="pv<?php echo $obj->cbid;?>" name="date" value="<?php echo date('d-m-Y'); ?>"/>
                        </div>
                    </div>
                </div>
                <tr>
                    <td><?php echo $obj->cnom; ?></td>
                    <td><a class="no_effect" href="./edit_bon.php?num_bon=<?php echo $obj->num_bon;?>&nom=<?php echo $obj->cnom;?>"><?php echo $obj->num_bon;?></a></td>
                    <td><?php echo $obj->bcdate; ?></td>
                    <td class="edit_fourn" id="<?php echo $obj->cbid; ?>"><?php echo $obj->cbfourn; ?></td>
                    <td><?php echo $obj->aarticle; ?></td>
                    <td><?php echo $obj->partnumber; ?></td>
                    <td><?php echo $obj->cbquanti; ?></td>
                    <td><?php echo $obj->aprix_htva; ?> &euro;</td>
                    <td><?php echo $obj->aprix_htva*$obj->cbquanti; ?> &euro;</td>
                    <td><?php echo $obj->cbp_u_jour; ?> &euro;</td>
                    <td><?php echo $obj->cbtot_art_htva; ?> &euro;</td>
                    <td>
						<i class="fa fa-pencil fa-fw fa-2x add dialog-show-button" data-show-dialog="note<?php echo $obj->cbid;?>" aria-hidden="true"></i>	
                    </td>
                    <td id="empl_com_<?php echo $obj->cbnum; ?>">
                        <?php 
						if ($obj->cbcommande == '0000-00-00' || $obj->cbcommande == NULL || $obj->cbcommande == 'non') {
                        	//Si l'article n'est pas commandé, on affiche le formulaire
							echo '<span style="font-size:13px;color:#c0392b;font-weight:bold">NON</span>';
                        }
                        else {
							//Sinon on affiche le marqueur commandé, en vert.
                        	echo '<span style="font-size:13px;color:#3ac836;font-weight:bold">'.$obj->cbcommande.'</span>';
                        }
                        ?>
                    </td>
                    <td id="empl_rec_<?php echo $obj->cbnum; ?>">   
                        <?php if ($obj->cbrecu == '0000-00-00' || $obj->cbrecu == NULL || $obj->cbrecu == 'non') {
                            echo '<span style="font-size:13px;color:#c0392b;font-weight:bold">NON</span>';
                        }
                        else {
                        	echo '<span style="font-size:13px;color:#3ac836;font-weight:bold">'.$obj->cbrecu.'</span>';
                        }
                        ?>
                    </td>
                    <td>
                    	<?php 
						if ($obj->cbquanti > $obj->cblivre) {
							?>
                    		<a href="./convert_bl.php?commande=<?php echo $obj->num_bon;?>&date=<?php echo date('d/m/Y');?>" class="no_effect" onclick='return confirm("Voulez-vous vraiment cr&eacute;er le bon de livraison pour la commande n&#xb0; <?php echo $obj->num_bon;?>?")'><i class="fa fa-check-circle fa-fw fa-2x add" title="G&eacute;n&eacute;rer le bon de livraison"></i></a>
                            <?php
						}
						else {
							?>
                            <i class="fa fa-truck fa-fw fa-2x" style="color:#27ae60" title="Le bon de livraison pour cet article &agrave; d&eacute;j&agrave; &eacute;t&eacute; g&eacute;n&eacute;r&eacute;"></i>
                            <?php
						}
						?>
                    </td>
                </tr>
                <?php
            }
			//COMMANDES STOCK
			$sql="SELECT a.num, a.article, a.reference, a.prix_htva, a.stomin, a.stock, a.stomax, f.nom";
			$sql.=" FROM ".$tblpref."article as a";
			$sql.=" LEFT JOIN ".$tblpref."fournisseurs as f ON f.id = a.fourn";
			$sql.=" WHERE a.stock < a.stomin AND a.stomin > 0 AND ( (a.stock + a.in_comm) < a.stomin )";
			$req=mysql_query($sql);
			while ($obj = mysql_fetch_object($req)) {
				//Calcul de la quantité nécessaire.
				$max=$obj->stomax;
				$min=$obj->stomin;
				$actu=$obj->stock;
				$toco=$min-$actu;
				$pa_tot=$obj->prix_htva*$toco;
				?>
                <tr>
                    <td widtd="5%"><span style="color:#d35400;font-weight:bold;">STOCK</span></td>
                    <td><i class="fa fa-ban fa-fw fa-2x" aria-hidden="true" style="color:#c0392b" title="Commande Stock - Pas de B.C."></i></td>        
                    <td><i class="fa fa-ban fa-fw fa-2x" aria-hidden="true" style="color:#c0392b" title="Commande Stock - Pas de B.C. - Pas de date"></i></td>
                    <td style="widtd:5%"><?php echo $obj->nom;?></td>
                    <td style="widtd:10%"><?php echo $obj->article;?></td>
                    <td style="widtd:6.5%"><?php echo $obj->reference;?></td>
                    <td><?php echo $toco;?></td>
                    <td style="widtd:6.5%"><?php echo $obj->prix_htva;?> &euro;</td>
                    <td style="widtd:6.5%"><?php echo $pa_tot;?> &euro;</td>
                    <td style="widtd:6.5%"><i class="fa fa-ban fa-fw fa-2x" aria-hidden="true" style="color:#c0392b" title="Commande Stock - Pas de P.V."></i></td>
                    <td style="widtd:6.5%"><i class="fa fa-ban fa-fw fa-2x" aria-hidden="true" style="color:#c0392b" title="Commande Stock - Pas de P.V."></i></td>
                    <td style="widtd:6.5%;"><i class="fa fa-ban fa-fw fa-2x" aria-hidden="true" style="color:#c0392b" title="Commande Stock - Si vous souhaitez modifier la ligne, &eacute;diter l'article directement"></i></td>
                    <td style="widtd:7%"><span style="font-size:13px;color:#c0392b;font-weight:bold">NON</span></td>
                    <td style="widtd:7%"><span style="font-size:13px;color:#c0392b;font-weight:bold">NON</span></td>
                    <td style="widtd:7%"><i class="fa fa-ban fa-fw fa-2x" aria-hidden="true" style="color:#c0392b" title="Commande Stock - Pas de livraison"></i></td>
                </tr>
                <?php
			}
            ?>
            </tbody>
        </table>
    </div>
</div>

<!--La modale-->
<div id="overlay3">
    <div class="popup_block">
        <a class="close" href="#noWhere">
        	<span class="fa-stack fa-lg fa-2x btn_close del">
              <i class="fa fa-circle fa-stack-2x"></i>
              <i class="fa fa-times fa-stack-1x fa-inverse"></i>
            </span>
      	</a>
        <div id="content_modale">
        	<div class="center"><i class="fa fa-spinner fa-3x fa-pulse"></i></div>
        </div>
    </div>
</div>

<?php 
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>