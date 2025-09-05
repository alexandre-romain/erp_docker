<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script>
function confirmDelete()
{
	var agree=confirm("<?php echo $lang_sup_li; ?>");
	if (agree)
	 	return true ;
	else
	 	return false ;
}
$(document).ready(function() {
	$( "#show_alreadyadd" ).hide();
	$( "#show_alreadyadd" ).click(function() {
		$( "#alreadyadd" ).show(500);
		$( "#show_alreadyadd" ).hide();
		$( "#hide_alreadyadd" ).show();
	});
	$( "#hide_alreadyadd" ).click(function() {
		$( "#alreadyadd" ).hide(500);
		$( "#show_alreadyadd" ).show();
		$( "#hide_alreadyadd" ).hide();
	});
});
$(document).ready(function() {
	$( "#show_terminate" ).hide();
	$( "#show_terminate" ).click(function() {
		$( "#terminate" ).show(500);
		$( "#show_terminate" ).hide();
		$( "#hide_terminate" ).show();
	});
	$( "#hide_terminate" ).click(function() {
		$( "#terminate" ).hide(500);
		$( "#show_terminate" ).show();
		$( "#hide_terminate" ).hide();
	});
});
<!-- DT LISTE COMMANDES -->
$(document).ready(function() {
    $('#already_add').DataTable( {
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
		"pageLength" : 20,
		"order": [[0, 'desc']],
  	});
} );
</script>
<?php 
//Ferme le <head>, ouvre le <body> & inclus le menu + ouverture content
include_once("include/finhead.php");
///FINHEAD
$sql = "SELECT  coment, client_num, bon_num, nom FROM " . $tblpref ."bl 
	RIGHT join " . $tblpref ."client on " . $tblpref ."bl.client_num = " . $tblpref ."client.num_client
	WHERE num_bl = $num_bl";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$data = mysql_fetch_array($req);
$num = htmlentities($data['client_num'], ENT_QUOTES);
$coment = htmlentities($data['coment'], ENT_QUOTES);
$nom = htmlentities($data['nom'], ENT_QUOTES);
$num_bon = $data['bon_num'];

$sql = "SELECT " . $tblpref ."cont_bl.num, ".$tblpref ."cont_bl.article_name, quanti, uni, article, tot_art_htva, to_tva_art tva
        FROM " . $tblpref ."cont_bl 
		RIGHT JOIN " . $tblpref ."article on " . $tblpref ."cont_bl.article_num = " . $tblpref ."article.num
		WHERE  bl_num = $num_bl";
$req5 = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
?>
<!--MODIFIER-->
<div class="portion">
    <!-- TITRE - MODIFIER -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-link fa-stack-1x"></i>
        </span>
        <?php echo "Articles d&eacute;j&agrave; li&eacute;s au BL ".$lang_numero." ".$num_bl; ?>
        <span class="fa-stack fa-lg add" style="float:right" id="show_alreadyadd">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_alreadyadd">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - MODIFIER -->
    <div class="content_traitement" id="alreadyadd">
        <table class="base" width="100%" id="already_add">
			<thead>
            <tr> 
                <th class="">Quantité</th>
                <th class=""><? echo $lang_unite ;?></th>
                <th class=""><? echo $lang_article ;?></th>
                <th class=""><? echo $lang_montant_htva ;?></th>
                <th class="">Numéro(s) de série</th>
                <th class=""><? echo $lang_editer ;?></th>
            </tr>
            </thead>
            <tbody>
            <?php
            //trouver le contenu du bon
            $total = 0.0;
            $total_bon = 0.0;
            $total_tva = 0.0;
            //echo "$sql";
            while($data = mysql_fetch_array($req5))
            {
                $quanti = $data['quanti'];
                $coment = $data['coment'];
                $uni = $data['uni'];
                $article = $data['article'];
                $article_name = $data['article_name'];
                $tot = $data['tot_art_htva'];
                $tva = $data['tva'];
                $num_cont = $data['num'];
                $total_bon += $tot;
                $total_tva += $tva;
                ?>
                <tr>
                      <td class=''><?php echo $quanti; ?></td>
                      <td class=''><?php echo  $uni; ?> </td>
                      <td class=''><?php if($article_name == NULL || $article_name == '') { echo  $article;} else {echo $article_name;}?></td>
                      <td  class=''><?php echo montant_financier ($tot); ?></td>
                      <td  class=''>Aucun</td>
                      <td class=''>
                            <form method="get" action="edit_cont_bl.php">
                                <button class="icons fa-pencil fa-fw fa-2x action"></button>
                                <input type="hidden" name="num_cont" value="<?php echo $num_cont; ?>">
                            </form>
                      </td>
                </tr>
                <?php 
                $total += $tot;
            }
            ?>
            </tbody>
       	</table>
        <br/><br/>
        <table class="base" width="100%">
            <thead>
                <tr>
                    <th class='right' width="50%"><?php echo $lang_total; ?> :</th>
                    <th class='left' width="50%"><?php echo montant_financier ($total); ?></th>
                </tr>
            </thead>
        </table>
	</div>
</div>
<!--ENREGISTRER-->
<div class="portion">
    <!-- TITRE - ENREGISTRER -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-floppy-o fa-stack-1x"></i>
        </span>
        Enregistrer le BL
        <span class="fa-stack fa-lg add" style="float:right" id="show_terminate">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_terminate">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - ENREGISTRER -->
    <div class="content_traitement" id="result">
        <form action="bl_fin.php" method="post" name="fin_bon">
            <table class="base" width="100%">
                <tr>
                    <td class="">Ajouter un commentaire sur le BL (facultatif)</td>
                </tr>
                <tr>
                    <td class=""><textarea name="coment" cols="80" rows="3" class="styled"><?php echo $coment; ?></textarea></td>
                </tr>
            </table>
            <div class="center">
                <button class="button_act button--shikoba button--border-thin medium" type="submit"><i class="button__icon fa fa-floppy-o"></i><span>Enregistrer</span></button>
            </div>
            <input type="hidden" name="tot_ht" value='<?php echo $total_bon; ?>'>
            <input type="hidden" name="tot_tva" value='<?php echo $total_tva; ?>'>
            <input type="hidden" name="bl_num" value='<?php echo $num_bl; ?>'>
        </form>
	</div>
</div>
