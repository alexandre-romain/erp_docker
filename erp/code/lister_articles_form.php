<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script type="text/javascript" src="./include/js/autocomplete.js"></script>
<script type="text/javascript" src="./include/js/jquery.jeditable.js"></script>
<script>
$(document).ready(function() {
	/* EDIT DU NOM AFFICHÉ (SERA SUBSTITUE AU NOM IMPORTE SI EXISTANT) */
	$('.edit_name').editable('./include/ajax/edit_name_aff.php', {
         indicator : 'Saving...',
         tooltip   : 'Click...'
     });
	/* GESTION DES SHOW/HIDE DE LA PAGE */
	<?php
	//Si une recherche à été lancée, on cache les filtres
	if (isset($_GET['top_cat']) || isset($_GET['mid_cat']) || isset($_GET['bot_cat'])) {
		?>
		$("#hide_search").hide();
		$("#search").hide();
		<?php
	}
	//Sinon on les affiche
	else {
		?>
		$("#show_search").hide();
		<?php
	}
	?>
	$("#hide_search").click(function(){
		$("#search").hide(500);	
		$("#hide_search").hide();
		$("#show_search").show();
	});
	$("#show_search").click(function(){
		$("#search").show(500);	
		$("#hide_search").show();
		$("#show_search").hide();
	});
	<?php
	//Si aucune recherche n'a été lancée, on cache les articles
	if (!isset($_GET['top_cat']) && !isset($_GET['mid_cat']) && !isset($_GET['bot_cat'])) {
		?>
		$("#hide_article").hide();
		$("#article").hide();
		<?php
	}
	//Sinon on les affiche
	else {
		?>
		$("#show_article").hide();
		<?php
	}
	?>
	$("#hide_article").click(function(){
		$("#article").hide(500);	
		$("#hide_article").hide();
		$("#show_article").show();
	});
	$("#show_article").click(function(){
		$("#article").show(500);	
		$("#hide_article").show();
		$("#show_article").hide();
	});
});
/* DATATABLES LISTE ARTICLES */
/* Formatting function for row details - modify as you need */
function format ( d ) {
    // `d` is the original data object for the row
    return '<div id="details['+d.id+']" class="container_details"></div>';
} 
 
$(document).ready(function() {						   
    var table = $('#list').DataTable( {
        "columns": [
            {
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": '&nbsp;',
				"width":		  "4%"	
            },
			{ "data": "id","width": "5%" },
            { "data": "topcat", "width": "5%" },
            { "data": "midcat", "width": "5%" },
            { "data": "botcat", "width": "5%" },
			{ "data": "marque", "width": "5%" },
			{ "data": "article", "width": "5%" },
			{ "data": "nomaff", "width": "5%" },
			{ "data": "pn", "width": "5%" },
			{ "data": "stock", "width": "4%" },
			{ "data": "pa", "width": "4%" },
			{ "data": "pvht", "width": "5%" },
			{ "data": "pvttc", "width": "5%" },
            { "data": "actions", "width": "8%" }
        ],
        "order": [[1, 'asc']],
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
    $('#list tbody').on('click', 'td.details-control', function () {
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
			show_det_article(idline);
        }
    } );
} );
</script>
<?php 
//Ferme le <head>, ouvre le <body> & inclus le menu + ouverture content
include_once("include/finhead.php");
//Gestion des messages informatifs
include_once("include/message_info.php");
?>
<!--SEARCH FILTER-->
<div class="portion">
    <!-- TITRE - SEARCH -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-search fa-stack-1x"></i>
        </span>
        Filtres de recherche
        <span class="fa-stack fa-lg add" style="float:right" id="show_search">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_search">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - SEARCH -->
    <div class="content_traitement" id="search">
        <div class="portion_subtitle"><i class="fa fa-cog fa-fw"></i> Afficher les articles d'une cat&eacute;gorie</div>
        <form action="./lister_articles_form.php" methode="get" class="center">
            <!--Top Category-->
            <select size="10" id="top_cat" name="top_cat" onchange="top_to_middle_cat()" onfocus="top_to_middle_cat()" onkeyup="top_to_middle_cat()">
            <?php
            $sql_top="SELECT categorie, id_cat FROM ".$tblpref."categorie WHERE cat_level=1 ORDER by categorie ASC";
            $req_top=mysql_query($sql_top);
            while ($obj_top=mysql_fetch_object($req_top)) {
                echo '<option value="'.$obj_top->id_cat.'">'.$obj_top->categorie.'</option>';
            }
            ?>
            </select>
            <!--Middle Category-->
            <select size="10" id="mid_cat" name="mid_cat" onchange="middle_to_bot_cat()" onfocus="middle_to_bot_cat()" onkeyup="middle_to_bot_cat()">
            </select>
            <!--Bottom Category-->
            <select size="10" id="bot_cat" name="bot_cat">
            </select>
            <!--SUBMIT-->
            <br/>
            <button class="button_act button--shikoba button--border-thin medium"><i class="button__icon fa fa-search"></i><span>Rechercher</span></button>
        </form>
        <div class="portion_subtitle"><i class="fa fa-cog fa-fw"></i> Rechercher des articles (Marque - Nom - Partnumber)</div>
        <div class="center"><input type="text" name="search_article" id="search_article" OnKeyUp="recherche_article()" class="styled"/></div>
    </div>
</div>

<?php
//ON va gérer le nom des filtres, pour affichage informatif dans le titre ARTICLES
if (isset($_GET['top_cat'])) {
	$sql="SELECT categorie FROM ".$tblpref."categorie WHERE id_cat='".$_GET['top_cat']."'";
	$req=mysql_query($sql);
	$obj=mysql_fetch_object($req);
	$filter_aff=$obj->categorie;
	if (isset($_GET['mid_cat'])) {
		$sql="SELECT categorie FROM ".$tblpref."categorie WHERE id_cat='".$_GET['mid_cat']."'";
		$req=mysql_query($sql);
		$obj=mysql_fetch_object($req);
		$filter_aff.=' > '.$obj->categorie;
		if (isset($_GET['bot_cat'])) {
			$sql="SELECT categorie FROM ".$tblpref."categorie WHERE id_cat='".$_GET['bot_cat']."'";
			$req=mysql_query($sql);
			$obj=mysql_fetch_object($req);
			$filter_aff.=' > '.$obj->categorie;
		}
	}
}
?>

<!--ARTICLES - RESULTS -->
<div class="portion">
    <!-- TITRE - RESULTS -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-laptop fa-stack-1x"></i>
        </span>
        Liste des articles <span id="aff_filtres"><?php if (isset($_GET['top_cat']) || isset($_GET['mid_cat']) || isset($_GET['bot_cat'])) {?>( Filtres : <?php echo $filter_aff;?> )<?php } ?></span>
        <span class="fa-stack fa-lg add" style="float:right" id="show_article">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_article">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - RESULTS -->
    <div class="content_traitement" id="article">
     	<div id="tableau_results">
			<?php
            if (isset($_GET['top_cat']) || isset($_GET['mid_cat']) || isset($_GET['bot_cat'])) {
                ?>
                <table class="base" align="center" width="100%" id="list">
                	<thead>
                    <tr>
                    	<th></th>
                        <th>Num.</th>
                        <th>Top Cat.</th>
                        <th>Middle Cat.</th>
                        <th>Bottom Cat.</th>
                        <th>Marque</th>
                        <th>Article</th>
                        <th>Nom affich&eacute;</th>
                        <th>PartNumber</th>
                        <th>Stock</th>
                        <th>P.A.</th>
                        <th>P.V. HT</th>
                        <th>P.V. TTC</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (isset($_GET['top_cat']) && isset($_GET['mid_cat']) && isset($_GET['bot_cat'])) { //Si 3cat-sous-cat son sélectionnée
                        //echo 'je rentre dans la cond 1';
                        $topcat=$_GET['top_cat'];
                        $midcat=$_GET['mid_cat'];
                        $botcat=$_GET['bot_cat'];	
                        $sql ="SELECT a.num as num, a.article_name as art_name, c1.categorie as c1cat, c2.categorie as c2cat, c3.categorie as c3cat, a.marque as marque, a.article as article, a.reference as partnumber, a.stock as stock, a.prix_htva as pa,a.taux_tva as taux_tva, a.marge as marge, a.stomin as stomin"; 
                        $sql.=" FROM ".$tblpref."article as a"; 
                        $sql.=" LEFT JOIN ".$tblpref."categorie as c1 ON c1.id_cat=a.cat1";
                        $sql.=" LEFT JOIN ".$tblpref."categorie as c2 ON c2.id_cat=a.cat2";
                        $sql.=" LEFT JOIN ".$tblpref."categorie as c3 ON c3.id_cat=a.cat3";
                        $sql.=" WHERE a.cat3=".$botcat." AND actif != 'non'";
                        $sql.=" ORDER BY marque ASC, article ASC ";
                    }
                    else if (isset($_GET['top_cat']) && isset($_GET['mid_cat']) && !isset($_GET['bot_cat'])) { //Si 2 first cat-sous-cat son sélectionnée
                        //echo 'je rentre dans la cond 2';
                        $topcat=$_GET['top_cat'];
                        $midcat=$_GET['mid_cat'];
                        $botcat=$_GET['bot_cat'];	
                        $sql ="SELECT a.num as num, a.article_name as art_name, c1.categorie as c1cat, c2.categorie as c2cat, c3.categorie as c3cat, a.marque as marque, a.article as article, a.reference as partnumber, a.stock as stock, a.prix_htva as pa,a.taux_tva as taux_tva, a.marge as marge, a.stomin as stomin"; 
                        $sql.=" FROM ".$tblpref."article as a"; 
                        $sql.=" LEFT JOIN ".$tblpref."categorie as c1 ON c1.id_cat=a.cat1";
                        $sql.=" LEFT JOIN ".$tblpref."categorie as c2 ON c2.id_cat=a.cat2";
                        $sql.=" LEFT JOIN ".$tblpref."categorie as c3 ON c3.id_cat=a.cat3";
                        $sql.=" WHERE a.cat2=".$midcat." AND actif != 'non'";
                        $sql.=" ORDER BY marque ASC, article ASC ";
                    }
                    else if (isset($_GET['top_cat']) && !isset($_GET['mid_cat']) && !isset($_GET['bot_cat'])) { //Si first cat est sélectionnée
                        //echo 'je rentre dans la cond 3';
                        $topcat=$_GET['top_cat'];
                        $midcat=$_GET['mid_cat'];
                        $botcat=$_GET['bot_cat'];	
                        $sql ="SELECT a.num as num, a.article_name as art_name, c1.categorie as c1cat, c2.categorie as c2cat, c3.categorie as c3cat, a.marque as marque, a.article as article, a.reference as partnumber, a.stock as stock, a.prix_htva as pa,a.taux_tva as taux_tva, a.marge as marge, a.stomin as stomin"; 
                        $sql.=" FROM ".$tblpref."article as a"; 
                        $sql.=" LEFT JOIN ".$tblpref."categorie as c1 ON c1.id_cat=a.cat1";
                        $sql.=" LEFT JOIN ".$tblpref."categorie as c2 ON c2.id_cat=a.cat2";
                        $sql.=" LEFT JOIN ".$tblpref."categorie as c3 ON c3.id_cat=a.cat3";
                        $sql.=" WHERE a.cat1=".$topcat." AND actif != 'non'";
                        $sql.=" ORDER BY marque ASC, article ASC ";
                    }
                    else if (!isset($_GET['top_cat']) && isset($_GET['mid_cat']) && isset($_GET['bot_cat'])) { //Si 2 last cat-sous-cat son sélectionnée
                        //echo 'je rentre dans la cond 4';
                        $topcat=$_GET['top_cat'];
                        $midcat=$_GET['mid_cat'];
                        $botcat=$_GET['bot_cat'];	
                        $sql ="SELECT a.num as num, a.article_name as art_name, c1.categorie as c1cat, c2.categorie as c2cat, c3.categorie as c3cat, a.marque as marque, a.article as article, a.reference as partnumber, a.stock as stock, a.prix_htva as pa,a.taux_tva as taux_tva, a.marge as marge, a.stomin as stomin"; 
                        $sql.=" FROM ".$tblpref."article as a"; 
                        $sql.=" LEFT JOIN ".$tblpref."categorie as c1 ON c1.id_cat=a.cat1";
                        $sql.=" LEFT JOIN ".$tblpref."categorie as c2 ON c2.id_cat=a.cat2";
                        $sql.=" LEFT JOIN ".$tblpref."categorie as c3 ON c3.id_cat=a.cat3";
                        $sql.=" WHERE a.cat3=".$botcat." AND actif != 'non'";
                        $sql.=" ORDER BY marque ASC, article ASC ";
                    }
                    else if (!isset($_GET['top_cat']) && !isset($_GET['mid_cat']) && isset($_GET['bot_cat'])) { //Si 2 last cat-sous-cat son sélectionnée
                        //echo 'je rentre dans la cond 5';
                        $topcat=$_GET['top_cat'];
                        $midcat=$_GET['mid_cat'];
                        $botcat=$_GET['bot_cat'];	
                        $sql ="SELECT a.num as num, a.article_name as art_name, c1.categorie as c1cat, c2.categorie as c2cat, c3.categorie as c3cat, a.marque as marque, a.article as article, a.reference as partnumber, a.stock as stock, a.prix_htva as pa,a.taux_tva as taux_tva, a.marge as marge, a.stomin as stomin"; 
                        $sql.=" FROM ".$tblpref."article as a"; 
                        $sql.=" LEFT JOIN ".$tblpref."categorie as c1 ON c1.id_cat=a.cat1";
                        $sql.=" LEFT JOIN ".$tblpref."categorie as c2 ON c2.id_cat=a.cat2";
                        $sql.=" LEFT JOIN ".$tblpref."categorie as c3 ON c3.id_cat=a.cat3";
                        $sql.=" WHERE a.cat3=".$botcat." AND actif != 'non'";
                        $sql.=" ORDER BY marque ASC, article ASC ";
                    }
                    else if (!isset($_GET['top_cat']) && isset($_GET['mid_cat']) && !isset($_GET['bot_cat'])) { //Si 2 last cat-sous-cat son sélectionnée
                        //echo 'je rentre dans la cond 6';
                        $topcat=$_GET['top_cat'];
                        $midcat=$_GET['mid_cat'];
                        $botcat=$_GET['bot_cat'];	
                        $sql ="SELECT a.num as num, a.article_name as art_name, c1.categorie as c1cat, c2.categorie as c2cat, c3.categorie as c3cat, a.marque as marque, a.article as article, a.reference as partnumber, a.stock as stock, a.prix_htva as pa,a.taux_tva as taux_tva, a.marge as marge, a.stomin as stomin"; 
                        $sql.=" FROM ".$tblpref."article as a"; 
                        $sql.=" LEFT JOIN ".$tblpref."categorie as c1 ON c1.id_cat=a.cat1";
                        $sql.=" LEFT JOIN ".$tblpref."categorie as c2 ON c2.id_cat=a.cat2";
                        $sql.=" LEFT JOIN ".$tblpref."categorie as c3 ON c3.id_cat=a.cat3";
                        $sql.=" WHERE a.cat2=".$midcat." AND actif != 'non'";
                        $sql.=" ORDER BY marque ASC, article ASC ";
                    }
                    $req=mysql_query($sql);
                    while ($obj=mysql_fetch_object($req)) {
                        echo '<tr>';
                            //Calcul du PV
                            $one_percent=$obj->pa/100;
                            $marge=$one_percent*$obj->marge;
                            $pv_inter=$obj->pa+$marge;
                            $tva_inter=$pv_inter/100;
                            $tva=$tva_inter*$obj->taux_tva;
                            $pv=$pv_inter+$tva;
                            $pv=number_format($pv, 2, ',', ' ');
							//Affichage des lignes
                            echo '<td></td>';
							echo '<td>'.$obj->num.'</td>';
                            echo '<td>'.$obj->c1cat.'</td>';
                            echo '<td>'.$obj->c2cat.'</td>';
                            echo '<td>'.$obj->c3cat.'</td>';
                            echo '<td>'.$obj->marque.'</td>';
                            echo '<td>'.$obj->article.'</td>';
                            echo '<td class="edit_name" id="'.$obj->num.'">'.$obj->art_name.'</td>';
                            echo '<td>'.$obj->partnumber.'</td>';
                            if ($obj->stock < 0.00) {
                                echo '<td><span style="color:#f44d40">'.$obj->stock.'</span></td>';
                            }
                            else if ($obj->stock > 0.00) {
                                echo '<td><span style="color:#419e21">'.$obj->stock.'</span></td>';
                            }
                            else {
                                echo '<td>'.$obj->stock.'</td>';
                            }
                            echo '<td>'.$obj->pa.'&euro;</td>';
                            echo '<td>'.$pv_inter.'&euro;</td>';
                            echo '<td>'.$pv.'&euro;</td>';
                            echo '<td>
								<a href="./include/ajax/delete_article.php?num='.$obj->num.'"><button class="icons fa-trash fa-3x fa-fw del" title="Supprimer l\'article"></button></a>
							</td>';
                        echo '</tr>';
                    }
                	?>
                	</tbody>
                </table>
                <?php
            }
            ?>
        </div>   
    </div>
</div>
<?php 
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>