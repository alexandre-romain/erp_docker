<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script>
$(document).ready(function() {
	$("#show_client").hide();
	$("#hide_client").click(function(){
		$("#client").hide(500);	
		$("#hide_client").hide();
		$("#show_client").show();
	});
	$("#show_client").click(function(){
		$("#client").show(500);	
		$("#hide_client").show();
		$("#show_client").hide();
	});
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
<!-- DT LISTE COMMANDES -->
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
///FINHEAD
$sql = "SELECT  coment, client_num, nom FROM " . $tblpref ."bon_comm 
	RIGHT join " . $tblpref ."client on " . $tblpref ."bon_comm.client_num = " . $tblpref ."client.num_client
	WHERE num_bon = $num_bon";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$data = mysql_fetch_array($req);

$num = htmlentities($data['client_num'], ENT_QUOTES);
$coment = htmlentities($data['coment'], ENT_QUOTES);
$nom = htmlentities($data['nom'], ENT_QUOTES);

$sql = "SELECT " . $tblpref ."cont_bon.num, num_lot, quanti, uni, article, tot_art_htva, to_tva_art tva, " . $tblpref ."cont_bon.article_name
        FROM " . $tblpref ."cont_bon 
		RIGHT JOIN " . $tblpref ."article on " . $tblpref ."cont_bon.article_num = " . $tblpref ."article.num
		WHERE  bon_num = $num_bon";
$req5 = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());

$rqSql1 = "SELECT num, article, prix_htva, uni FROM " . $tblpref ."article WHERE actif != 'non' ORDER BY article,prix_htva";
$result = mysql_query( $rqSql1 ) or die( "Exécution requête impossible.");

$rqSql = "SELECT num_client, nom FROM " . $tblpref ."client WHERE actif != 'non'";
if ($user_com == r) { 
	$rqSql = "SELECT num_client, nom FROM " . $tblpref ."client WHERE actif != 'non'
		 and (" . $tblpref ."client.permi LIKE '$user_num,' 
		 or  " . $tblpref ."client.permi LIKE '%,$user_num,' 
		 or  " . $tblpref ."client.permi LIKE '%,$user_num,%' 
		 or  " . $tblpref ."client.permi LIKE '$user_num,%')  
		";  
}
$result2 = mysql_query( $rqSql ) or die('Erreur SQL !<br>'.$rqSql2.'<br>'.mysql_error());	     
?>
<div class="portion">
    <!-- TITRE - SEARCH -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-user-secret fa-stack-1x"></i>
        </span>
        Modifier le client ( Actuel = <?php echo $nom;?>)
        <span class="fa-stack fa-lg add" style="float:right" id="show_client">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_client">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - SEARCH -->
    <div class="content_traitement" id="client">
        <form action="chang_cli.php" method="POST" name="formu">
        <table class="base" width="100%">
            <tr>
                <td class="right" width="50%">Changer le client :</td>
                <td class="left" width="50%">
                    <?php 
                    require_once("include/configav.php");
                    if ($liste_cli!='y') { 
                        $rqSql="$rqSql order by nom";
                        $result = mysql_query( $rqSql ) or die( "Exécution requête impossible.");
                        ?> 
                        <SELECT NAME='listeville'>
                            <OPTION VALUE=<?php echo"$num_client"; ?> ><?php echo $nom; ?></OPTION>
                            <?php
                            while ( $row = mysql_fetch_array( $result2)) {
                                $numcli = $row["num_client"];
                                $nomcli = $row["nom"];
                                ?>
                                <OPTION VALUE='<?php echo "$numcli"; ?>'><?php echo "$nomcli "; ?></OPTION>
                            <?php 
                            }
                            ?>
                        </select>
                    <?php 
                    }
                    else {
                        include_once("include/choix_cli.php");
                    } ?> 
                </td>
            </tr>
        </table>
        <div class="center">
            <button type="submit" class="button_act button--shikoba button--border-thin medium"><i class="button__icon fa fa-pencil"></i><span>Modifier</span></button>
        </div>
        <input type="hidden" name="num_bon" value="<?php echo "$num_bon"; ?>" />
        </form>
	</div>
</div>
<div class="portion">
    <!-- TITRE - SEARCH -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-link fa-stack-1x"></i>
        </span>
        Articles d&eacute;j&agrave; li&eacute;s au bon <?php echo "$lang_numero $num_bon"; ?>
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
    <!-- CONTENT - SEARCH -->
    <div class="content_traitement" id="alreadyadd">
        <table class="base" align="center" id="already_add" width="100%">
        	<thead>
                <tr> 
                    <th class=""><? echo $lang_quantite ;?></th>
                    <th class=""><? echo $lang_unite ;?></th>
                    <th class=""><? echo $lang_article ;?></th>
                    <th class=""><? echo $lang_montant_htva ;?></th>
                    <?php 
                    if ($lot =='y') { 
                    ?>
                        <th class=""><? echo "N° lot"; ?></th>  
                    <?php
                    }
                    ?> 
                    <th class=""><? echo $lang_editer ;?></th>
                    <th class=""><? echo $lang_supprimer ;?></th>
                </tr>
            </thead>
            <tbody>
            <?php
            //trouver le client correspodant devis à editer
            //trouver le contenu du bon
            $total = 0.0;
            $total_bon = 0.0;
            $total_tva = 0.0;
            while($data = mysql_fetch_array($req5))
            
            { 	
                $quanti = $data['quanti'];
                $uni = $data['uni'];
                $article = $data['article'];
                $article_name = $data['article_name'];
                $tot = $data['tot_art_htva'];
                $tva = $data['tva'];
                $num_cont = $data['num'];
                $num_lot = $data['num_lot'];
                $total_bon += $tot;
                $total_tva += $tva;	
                ?>
                <tr>
                    <td class=''><?php echo $quanti; ?></td>
                    <td class=''><?php echo  $uni; ?> </td>
                    <td class=''><?php if ($article_name == NULL) { echo  $article;} else {echo $article_name;}?></td>
                    <td class=''><?php echo montant_financier ($tot); ?></td>
                    <?php 
                    if ($lot =='y') { 
                    ?>
                        <td class=''><?php echo $num_lot; ?></td>
                    <?php
                    }
                    ?>  
                    <td class=''>
                        <a href="edit_cont_bon.php?num_cont=<?php echo $num_cont;?>" class="no_effect"><i class="fa fa-pencil fa-2x action"></i></a>
                    </td>
                    <td class=''>
                        <a href="delete_cont_bon.php?num_cont=<?php echo $num_cont;?>&num_bon=<?php echo $num_bon;?>" onClick='return confirmDelete()' class="no_effect">
                        	<i class="fa fa-trash fa-2x del"></i>
                        </a>
                    </td> 
                </tr>
                <?php	 
                $total += $tot;
            }
            ?>
            </tbody>
     	</table>
        <br/><br/>
        <table width="100%" class="base">
        	<thead>
                <tr>
                    <th class='right' width="50%"><?php echo $lang_total; ?> H.T. :</th>
                    <th class='left' width="50%"><?php echo montant_financier ($total); ?></th>
                </tr>
            </thead>
            <?php
            //on calcule la somme des contenus du bon
            $sql = " SELECT SUM(tot_art_htva) FROM " . $tblpref ."cont_bon WHERE bon_num = $num_bon";
            $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
            ?>
        </table>
	</div>
</div>

<div class="portion">
    <!-- TITRE - SEARCH -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-plus fa-stack-1x"></i>
        </span>
        <?php echo "$lang_bon_ajouter $lang_numero $num_bon"; ?>
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
    <!-- CONTENT - SEARCH -->
    <div class="content_traitement" id="add">
        <form name="formu2" method="post" action="edit_bon_suite.php">
        <table class="base" align="center" width="100%">
            <tr>
                <td class="right" width="30%"><?php echo $lang_article; ?> :</td>
                <td class="left" width="70%"><?php include("include/categorie_choix.php"); ?></td>
            </tr>
            <tr> 
                <td class="right"><?php echo $lang_quantite; ?> :</td>
                <td class="left"><input name="quanti" type="text" id="quanti" value="1" size="6" class="styled"></td>
            </tr>
            <tr>
                <td class="right">PV (HTVA) :</td>
                <td class="left"><input name="PV" type="text" id="PV" size="6" class="styled"></td>
            </tr>
        </table>
        <div class="center">
            <button type="submit" class="button_act button--shikoba button--border-thin medium"><i class="button__icon fa fa-plus"></i><span><?php echo $lang_bon_ajouter; ?></span></button>
        </div>
        <input name="nom" type="hidden"  value='<?php echo $nom; ?>'> 
       	<input name="num_bon" type="hidden" id="nom" value='<?php echo $num_bon; ?>'>
        </form>
	</div>
</div>

<div class="portion">
    <!-- TITRE - SEARCH -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-floppy-o fa-stack-1x"></i>
        </span>
        Enregistrer le bon
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
    <!-- CONTENT - SEARCH -->
    <div class="content_traitement" id="terminate">
        <form action="bon_fin.php" method="post" name="fin_bon">
        <table class="base" align="center" width="100%">
            <tr>
                <td class=""><?php echo $lang_ajo_com_bo ?></td>
            </tr>
            <tr>
                <td class=""><center><textarea name="coment" cols="80" rows="3" class="styled"><?php echo $coment; ?></textarea></td>
            </tr>
        </table>
        <div class="center">
            <button type="submit" class="button_act button--shikoba button--border-thin medium"><i class="button__icon fa fa-floppy-o"></i><span>Enregistrer</span></button>
        </div>
        <input type="hidden" name="tot_ht" value='<?php echo $total_bon; ?>'>
        <input type="hidden" name="tot_tva" value='<?php echo $total_tva; ?>'>
        <input type="hidden" name="bon_num" value='<?php echo $num_bon; ?>'>
        </form>
	</div>
</div>