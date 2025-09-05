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
		"order": [[1, 'desc']],
  	});
} );
</script>
<?php 
//Ferme le <head>, ouvre le <body> & inclus le menu + ouverture content
include_once("include/finhead.php");
///FINHEAD
//Gestion des messages informatifs
include_once("include/message_info.php");
$sql = "SELECT num, lib, fournisseur, prix, type, DATE_FORMAT(date,'%d/%m/%Y') AS date 
	FROM " . $tblpref ."depense  
	ORDER BY `num` DESC";
$req = mysql_query($sql);
?>
<!--LISTE DEPENSES-->
<div class="portion">
    <!-- TITRE - LISTE DEPENSES -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-list fa-stack-1x"></i>
        </span>
        <?php echo $lang_depenses_liste; ?>
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
    <!-- CONTENT - LISTE DEPENSES -->
    <div class="content_traitement" id="list">
        <table class="base" width="100%" id="listing">
        	<thead>
            <tr> 
            	<th>D&eacute;tails</th>
                <th class=""><?php echo $lang_numero; ?></th>
                <th class=""><?php echo $lang_fournisseur; ?></th>
                <th class=""><?php echo $lang_libelle; ?></th>
                <th class=""><?php echo $lang_montant; ?></th>
                <th class=""><?php echo $lang_date; ?></th>
                <th class="">Type</th>
                <th class=""><?php echo $lang_action; ?></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $nombre = 1;
            while($data = mysql_fetch_array($req))
            {
                $num = $data['num'];
                $date = $data['date'];
                $lib = $data['lib'];
                $fou = $data['fournisseur'];
                $type = $data['type'];
                $fou = stripslashes($fou);
                $montant = $data['prix'];
                $nombre = $nombre +1;
                if($nombre & 1){
                    $line="0";
                }
                else {
                    $line="1"; 
                }
                ?>
                <tr class="">
                	<td>
                    	<?php
						if ($type == 'AM') {
							?>
							<a href="fiche_depense.php?id=<?php echo $num;?>" class="no_effect">
								<i class="fa fa-plus-square-o fa-fw fa-2x add" aria-hidden="true" title="Consulter les d&eacute;tails"></i>
							</a>
							<?php
						}
						else {
							?>
                            <i class="fa fa-ban fa-fw fa-2x" aria-hidden="true" title="Frais g&eacute;n&eacute;raux - Pas de d&eacute;tails"></i>
                            <?php
						}
						?>
                    </td>
                    <td class=""><?php echo $num; ?></td>
                    <td class=""><?php echo $fou; ?></td>
                    <td class=""><?php echo $lib; ?></td>
                    <td class=""><?php echo montant_financier ($montant); ?></td>
                    <td class=""><?php echo $date; ?></td>
                    <td class=""><?php echo $type; ?></td>	
                    <td class="">
                        <a href='edit_dep.php?num_dep=<?php echo $num; ?>' class="no_effect">
                        	<i class="fa fa-pencil fa-fw fa-2x action" title="&Eacute;diter"></i>
                        </a>
                        <a href="delete_dep.php?num=<?php echo $num; ?>" onClick="return confirmDelete('<?php echo "Etes-vous sûr de vouloir effacer la ligne n° $num ?"; ?>')" class="no_effect"> 
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
