<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script>
<!-- SHOW - HIDE -->
$(document).ready(function() {
	$("#show_alreadyadd").hide();
	$("#hide_alreadyadd").click(function(){
		$("#alreadyadd").hide(500);	
		$("#hide_alreadyadd").hide();
		$("#show_alreadyadd").show();
	});
	$("#show_alreadyadd").click(function(){
		$("#alreadyadd").show(500);	
		$("#hide_alreadyadd").show();
		$("#show_alreadyadd").hide();
	});
	$("#show_add").hide();
	$("#hide_add").click(function(){
		$("#add").hide(500);	
		$("#hide_add").hide();
		$("#show_add").show();
	});
	$("#show_add").click(function(){
		$("#add").show(500);	
		$("#hide_add").show();
		$("#show_add").hide();
	});
	$("#show_terminate").hide();
	$("#hide_terminate").click(function(){
		$("#terminate").hide(500);	
		$("#hide_terminate").hide();
		$("#show_terminate").show();
	});
	$("#show_terminate").click(function(){
		$("#terminate").show(500);	
		$("#hide_terminate").show();
		$("#show_terminate").hide();
	});
});
<!-- DT LISTE DEJA AJOUTES -->
$(document).ready(function() {
    $('#already_add').DataTable( {
		"language": {
			"lengthMenu": 'Afficher <div class="styled-select-dt"><select class="styled-dt">'+
						'<option value="5">5</option>'+
						'<option value="10">10</option>'+
						'<option value="20">20</option>'+
						'<option value="30">30</option>'+
						'<option value="40">40</option>'+
						'<option value="50">50</option>'+
						'<option value="-1">All</option>'+
						'</select></div> lignes'
		}
  	});
} );
</script>
<?php 
//Ferme le <head>, ouvre le <body> & inclus le menu + ouverture content
include_once("include/finhead.php");
?>
<?php 
$sql = "SELECT  coment, explic, epingle, client_num FROM " . $tblpref ."devis WHERE num_dev = $num_dev";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$data = mysql_fetch_array($req);
$num = $data['client_num'];
$coment = $data['coment'];
$explic = $data['explic'];
$epingle = $data['epingle'];
$sql = "SELECT " . $tblpref ."cont_dev.num, quanti, uni, article, tot_art_htva, to_tva_art tva, reference
        FROM " . $tblpref ."cont_dev RIGHT JOIN " . $tblpref ."article on " . $tblpref ."cont_dev.article_num = " . $tblpref ."article.num
		WHERE  dev_num = $num_dev";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
?>
<div class="portion">
    <!-- TITRE - ARTICLE DEJA AJOUTES -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-link fa-stack-1x"></i>
        </span>
        Articles d&eacute;j&agrave; li&eacute;s au devis N° <?php echo $num_dev;?>
        <span class="fa-stack fa-lg add" style="float:right" id="show_alreadyadd">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_alreadyadd">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - ARTICLE DEJA AJOUTES -->
    <div class="content_traitement" id="alreadyadd">
        <table class="base" align="center" width="100%" id="already_add">
			<thead>
            <tr>
                <th class=""><? echo $lang_quantite ;?></th>
                <th class=""><? echo $lang_unite ;?></th>
                <th class=""><? echo $lang_article ;?></th>
                <th class="">Partnumber</th>
                <th class=""><? echo $lang_montant_htva ;?></th>
                <th class=""><? echo $lang_editer ;?></th>
                <th class=""><? echo $lang_supprimer ;?></th>
            </tr>  
            </thead>
            <tbody>
            <?php
            $total = 0.0;
            $total_dev = 0.0;
            $total_tva = 0.0;
            while($data = mysql_fetch_array($req))
            {
                $quanti = $data['quanti'];
                $uni = $data['uni'];
                $article = $data['article'];
                $tot = $data['tot_art_htva'];
                $tva = $data['tva'];
                $num_cont = $data['num'];
                $total_dev += $tot;
                $total_tva += $tva;		
                ?>
                <tr>
                    <td class=''><?php echo $quanti; ?></td>
                    <td class=''><?php echo  $uni; ?></td>
                    <td class=''><?php echo  $article; ?></td>
                    <td class=''><?php echo  $data['reference']; ?></td>
                    <td  class=''><?php echo montant_financier ($tot); ?></td>
                    <td class=''>
                        <form method="post" action="edit_cont_dev.php">
                            <button class="icons fa-pencil fa-2x action"></button>
                            <input type="hidden" name="num_cont" value="<?php echo $num_cont; ?>">
                        </form>
                    </td>
                    <td class=''>
                        <a href="delete_cont_dev.php?num_cont=<?php echo $num_cont;?>&num_dev=<?php echo $num_dev;?>&nom=<?php echo $nom;?>" onClick='return confirmDelete()' class="no_effect"><i class="fa fa-trash fa-2x del"></i></a>
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
                    <th class='right' width="50%"><?php echo $lang_total; ?> HTVA :</th>
                    <th class='left' width="50%"><?php echo montant_financier ($total); ?></th>
                </tr>
            </thead>
        </table>
   	</div>
</div>
<?php
//on calcule la somme des contenus du bon
$sql = " SELECT SUM(tot_art_htva) FROM " . $tblpref ."cont_dev WHERE dev_num = $num_dev";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
?>

<div class="portion">
    <!-- TITRE - ADD ARTICLE -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-plus fa-stack-1x"></i>
        </span>
        Ajouter au devis N° <?php echo $num_dev;?>
        <span class="fa-stack fa-lg add" style="float:right" id="show_add">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_add">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - ADD ARTICLE -->
    <div class="content_traitement" id="add">
        <form name="formu2" method="post" action="edit_dev_suite.php">
        <table class="base" align="center" width="100%">
            <tr> 
                <td class="right" width="30%"><?php echo $lang_article; ?> :</td> 
                <td class="left" width="70%"> 
					<?php
                    include("include/categorie_choix.php"); 
                    ?> 
                </td>
            </tr>
            <tr> 
                <td class="right"><?php echo $lang_quantite; ?> :</td>
                <td class="left" colspan="6"><input name="quanti" type="text" id="quanti" value="1" size="6" class="styled"></td>
            </tr>
            <tr>
                  <td class="right">PV (HTVA) :</td>
                  <td class="left"><input name='PV' type='text' id='PV' size='6' class="styled"> &euro;</td>
            </tr>
        </table>
        <div class="center">
            <button class="button_act button--shikoba button--border-thin medium" type="submit"><i class="button__icon fa fa-plus"></i><span>Ajouter au devis</span></button>
        </div>
        <input name="nom" type="hidden" id="nom" value='<?php echo $nom; ?>'> 
        <input name="num_dev" type="hidden" id="nom" value='<?php echo $num_dev; ?>'> 
        </form>
	</div>
</div>
<div class="portion">
    <!-- TITRE - TERMINATE -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-floppy-o fa-stack-1x"></i>
        </span>
        Enregistrer le devis
        <span class="fa-stack fa-lg add" style="float:right" id="show_terminate">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_terminate">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - TERMINATE -->
    <div class="content_traitement" id="terminate">
        <form action="dev_fin.php" method="post" name="fin_dev">
        <table class="base" align="center" width="760px">
            <tr>
                <td class="">Dénomination (30 caract. max. | optionnel)</td>
            </tr>
            <tr>
                <td class=""><input name="explic" type="text" id="explic" value="<?php echo $explic; ?>" size="40" maxlength="30" class="styled"/></td>
            </tr>
            <tr>
                <td class=""><?php echo $lang_ajo_com_dev ?></td>
            </tr>
                <td class="" ><textarea name="coment" cols="45" rows="3" class="styled"><?php echo $coment; ?></textarea></td>
            </tr>
        </table>
        <div class="center">
            <button class="button_act button--shikoba button--border-thin medium" type="submit"><i class="button__icon fa fa-floppy-o"></i><span>Enregistrer</span></button>
        </div>
        <input type="hidden" name="tot_ht" value='<?php echo $total_dev; ?>'>
        <input type="hidden" name="tot_tva" value='<?php echo $total_tva; ?>'>
        <input type="hidden" name="dev_num" value='<?php echo $num_dev; ?>'>
        </form>
	</div>
</div>
<?php 
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>