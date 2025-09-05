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
	$("#show_compo").hide();
	$("#hide_compo").click(function(){
		$("#compo").hide(500);	
		$("#hide_compo").hide();
		$("#show_compo").show();
	});
	$("#show_compo").click(function(){
		$("#compo").show(500);	
		$("#hide_compo").show();
		$("#show_compo").hide();
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
		"pageLength" : -1,
		"order": [[0, 'desc']],
  	});
} );
</script>
<?php 
//Ferme le <head>, ouvre le <body> & inclus le menu + ouverture content
include_once("include/finhead.php");
///FINHEAD
//Gestion des messages informatifs
include_once("include/message_info.php");
$id  = $_REQUEST['id'];
$sql = "SELECT num, lib, fournisseur, prix, type, DATE_FORMAT(date,'%d/%m/%Y') AS date"; 
$sql.= " FROM ".$tblpref."depense";
$sql.= " WHERE num='".$id."'";
$sql.= " ORDER BY `num` DESC";
$req = mysql_query($sql);
$obj = mysql_fetch_object($req);
?>
<!--GENERAL-->
<div class="portion">
    <!-- TITRE - GENERAL -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-flag fa-stack-1x"></i>
        </span>
        G&eacute;n&eacute;ral
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
    <!-- CONTENT - GENERAL -->
    <div class="content_traitement" id="list">
        <form name="form1" method="post" action="edit_dep_suite.php">
            <table class="base" width="100%">
                <tr>
                    <td class="right" width="50%">R&eacute;f&eacute;rence / Libell&eacute; :</td>
                    <td class="left" width="50%"><input name="lib" type="text" value="<?php echo $obj->lib;?>" class="styled"></td>
                </tr>
                <tr>
                    <td class="right">Montant Htva :</td>
                    <td class="left"><input name="prix" type="text" value="<?php echo $obj->prix;?>" class="styled"></td>
                </tr>
                <tr>
                    <td class="right">Fournisseur :</td>
                    <td class="left"><input name="four" type="text" value="<?php echo $obj->fournisseur;?>" class="styled"></td>
                </tr>
            </table>
            <div class="center">
            <button class="button_act button--shikoba button--border-thin medium" type="submit"><i class="button__icon fa fa-check"></i><span>Valider</span></button>
            <button class="button_act button--shikoba button--border-thin medium" type="reset"><i class="button__icon fa fa-eraser"></i><span><?php echo $lang_effacer; ?></span></button>
        	</div>
        	<input name="num" type="hidden" value="<?php echo $id;?>">
        </form>
	</div>
</div>
<!--LISTE COMPOS-->
<div class="portion">
    <!-- TITRE - LISTE COMPOS -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-shopping-cart fa-stack-1x"></i>
        </span>
        Liste des articles
        <span class="fa-stack fa-lg add" style="float:right" id="show_compo">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_compo">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - LISTE COMPOS -->
    <div class="content_traitement" id="compo">
    	<?php
		$sql="SELECT dd.id, dd.quanti, dd.tot_htva, dd.p_u_jour, dd.received, dd.id_cont_bon, a.article, a.reference";
		$sql.=" FROM ".$tblpref."det_dep as dd";
		$sql.=" LEFT JOIN ".$tblpref."article as a ON a.num = dd.article_num";
		$sql.=" WHERE id_dep = '".$id."'";
		$req=mysql_query($sql);
		?>
        <form action="./include/ajax/command_received.php" method="post" class="autosubmit">
        <div class="center"><button class="button_act button--shikoba button--border-thin medium" type="submit"><i class="button__icon fa fa-check"></i><span>Re&ccedil;evoir</span></button></div>
        <table class="base" width="100%" id="listing">
            <thead>
                <tr>
                    <th>Article</th>
                    <th>PartNumber</th>
                    <th>Qty.</th>
                    <th>P.A. Uni.</th>
                    <th>P.A. Tot.</th>
                    <th>Re&ccedil;u</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
    			<?php
				while($obj = mysql_fetch_object($req)) {
					?>
                    <tr>
                    <td><?php echo $obj->article;?></td>
                    <td><?php echo $obj->reference;?></td>
                    <td><?php echo $obj->quanti;?></td>
                    <td><?php echo $obj->p_u_jour;?> &euro;</td>
                    <td><?php echo $obj->tot_htva;?> &euro;</td>
                    <td id="empl_rec_<?php echo $obj->id; ?>">
                    	<?php
						if ($obj->received == NULL || $obj->received == '0000-00-00') {
							?>
                               <input type="checkbox" name="received[]" value="<?php echo $obj->id; ?>" checked="checked"/>
                            <?php
						}
						else {
							echo '<span style="font-size:13px;color:#3ac836;font-weight:bold">'.$obj->received.'</span>';
						}
						?>
                    </td>
                    <td></td>
                    </tr>
                    <?php
				}
				?>
            </tbody>
        </table>
        <div class="center"><button class="button_act button--shikoba button--border-thin medium" type="submit"><i class="button__icon fa fa-check"></i><span>Re&ccedil;evoir</span></button></div>
        <input type="hidden" name="num" value="<?php echo $id;?>"/>
        </form>
	</div>
</div>
<?php 
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>
