<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script>
function confirmDelete() {
	var agree=confirm('<?php echo "$lang_cli_effa"; ?>');
	if (agree)
	 return true ;
	else
	 return false ;
}
function confirmDelete2() {
	var agree=confirm('<?php echo "$lang_con_effa_utils"; ?>');
	if (agree)
	 return true ;
	else
	 return false ;
}
<!-- DT LISTE USER -->
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
</script>
<?php 
//Ferme le <head>, ouvre le <body> & inclus le menu + ouverture content
include_once("include/finhead.php");
///FINHEAD
//Gestion des messages informatifs
include_once("include/message_info.php");
$sql = " SELECT * FROM " . $tblpref ."user WHERE 1 ORDER BY `nom` ASC";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
?>
<!-- LISTE DES USERS -->
<div class="portion">
    <!-- TITRE - LISTE DES USERS -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-list fa-stack-1x"></i>
        </span>
        Liste des utilisateurs
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
    <!-- CONTENT - LISTE DES USERS -->
    <div class="content_traitement" id="list">
        <table class="base" width="100%" id="listing">
        	<thead>
            <tr>
                <th class=""><?php echo $lang_nom; ?></th>
                <th class=""><?php echo prenom; ?></th>
                <th class=""><?php echo login; ?></th>
                <th class=""><?php echo "Est admin ?"; ?></th>
                <th class=""><?php echo "Gerer devis?"; ?></th>
                <th class=""><?php echo "Gerer commandes"; ?></th>
                <th class="">G&eacute;rer BL</th>
                <th class=""><?php echo "Gerer factures"; ?></th>
                <th class=""><?php echo "Gerer depenses"; ?></th>
                <th class=""><?php echo "Voir stat"; ?></th>
                <th class=""><?php echo "Gerer art"; ?></th>
                <th class=""><?php echo "Gerer clients"; ?></th>
                <th class=""><?php echo "$lang_action"; ?></th>
            </tr>
            </thead>
            <tbody>
            <?php
            while($data = mysql_fetch_array($req))
            {
                $nom = $data['nom'];
                $prenom = $data['prenom'];
                $login = $data['login'];
                $dev = $data['dev'];
                if ($dev == y) { $dev = '<i class="fa fa-check"></i> '.$lang_oui ;}
                if ($dev == n) { $dev = '<i class="fa fa-minus-circle"></i> '.$lang_non ; }
                if ($dev == r) { $dev = '<i class="fa fa-unlock-alt"></i> '.$lang_restrint ; }
                $com = $data['com'];
                if ($com == y) { $com = '<i class="fa fa-check"></i> '.$lang_oui ; }
                if ($com == n) { $com = '<i class="fa fa-minus-circle"></i> '.$lang_non ; }
                if ($com == r) { $com = '<i class="fa fa-unlock-alt"></i> '.$lang_restrint ; }
				$bl = $data['bl'];
                if ($bl == y) { $bl = '<i class="fa fa-check"></i> '.$lang_oui ; }
                if ($bl == n) { $bl = '<i class="fa fa-minus-circle"></i> '.$lang_non ; }
                $fact = $data['fact'];
                if ($fact == y) { $fact = '<i class="fa fa-check"></i> '.$lang_oui ; }
                if ($fact == n) { $fact = '<i class="fa fa-minus-circle"></i> '.$lang_non ; }
                if ($fact == r) { $fact = '<i class="fa fa-unlock-alt"></i> '.$lang_restrint ; }
                $mail =$data['mail'];
                $dep = $data['dep'];
                if ($dep == y) { $dep = '<i class="fa fa-check"></i> '.$lang_oui ; }
                if ($dep == n) { $dep = '<i class="fa fa-minus-circle"></i> '.$lang_non ; }
                $stat = $data['stat'];
                if ($stat == y) { $stat = '<i class="fa fa-check"></i> '.$lang_oui ; }
                if ($stat == n) { $stat = '<i class="fa fa-minus-circle"></i> '.$lang_non ; }
                $art = $data['art'];
                if ($art == y) { $art = '<i class="fa fa-check"></i> '.$lang_oui ; }
                if ($art == n) { $art = '<i class="fa fa-minus-circle"></i> '.$lang_non ; }
                $cli = $data['cli'];
                if ($cli == y) { $cli = '<i class="fa fa-check"></i> '.$lang_oui ; }
                if ($cli == n) { $cli = '<i class="fa fa-minus-circle"></i> '.$lang_non ; }
                if ($dev == r) { $dev = '<i class="fa fa-unlock-alt"></i> '.$lang_restrint ; }
                $admin = $data['admin'];
                if ($admin == y) { $admin = '<i class="fa fa-check"></i> '.$lang_oui ; }
                if ($admin == n) { $admin = '<i class="fa fa-minus-circle"></i> '.$lang_non ; }
                $num_user = $data['num'];
                ?>
                <tr class="">
                    <td class=""><b><?php echo $nom; ?></b></td>
                    <td class=""><b><?php echo $prenom; ?></b></td>
                    <td class=""><b><?php echo $login; ?></b></td>
                    <td class=""><?php echo $admin; ?></td>
                    <td class=""><?php echo $dev; ?></td>
                    <td class=""><?php echo $com; ?></td>
                    <td class=""><?php echo $bl; ?></td>
                    <td class=""><?php echo $fact; ?></td>
                    <td class=""><?php echo $dep; ?></td>
                    <td class=""><?php echo $stat; ?></td>
                    <td class=""><?php echo $art; ?></td>
                    <td class=""><?php echo $cli; ?></td>
                    <td class="">
                    <a href="editer_utilisateur.php?num_utilisateur=<?php echo $num_user ?>" class="no_effect">
                    	<i class="fa fa-pencil fa-fw fa-2x action"></i>
                    </a>
                    <a href="del_utilisateur.php?num_user=<?php echo $num_user ?>" class="no_effect" onClick='return confirmDelete2()'>
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
