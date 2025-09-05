<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script>
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
function confirmDelete(num)
{
	var agree=confirm('<?php echo "$lang_conf_effa"; ?>'+num);
	if (agree)
		return true ;
	else
		return false ;
}
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
///FINHEAD
$quanti=isset($_POST['quanti'])?$_POST['quanti']:"";
$article=isset($_POST['article'])?$_POST['article']:"";
$num=isset($_POST['num'])?$_POST['num']:"";
$lot1=isset($_POST['lot'])?$_POST['lot']:"";
$nom=isset($_POST['nom'])?$_POST['nom']:"";
$PV=isset($_POST['PV'])?$_POST['PV']:"";
$bon_num=isset($_POST['bon_num'])?$_POST['bon_num']:"";
//Si pas d'article ou pas de quantité, on affiche un message d'erreur
if($article=='' || $quanti=='' )
{
	$message= "$lang_champ_oubli";
	include('form_commande.php'); // On inclus le formulaire d'identification
	exit;
}

//trouver le client correspodant au dernier bon
$sql = "SELECT client_num FROM " . $tblpref ."bon_comm WHERE num_bon = $bon_num";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data = mysql_fetch_array($req))
{
	$num = $data['client_num'];
	$client = $data['client_num'];
}
//on recupere le prix htva		
$sql2 = "SELECT prix_htva, fourn FROM " . $tblpref ."article WHERE num = $article";
$result = mysql_query($sql2) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
//$PA = mysql_result($result, 'prix_htva');
$obj=mysql_fetch_object($result);
$PA=$obj->prix_htva;
$fourn=$obj->fourn;
//on recupere le taux de tva
$sql3 = "SELECT taux_tva FROM " . $tblpref ."article WHERE num = $article";
$result = mysql_query($sql3) or die('Erreur SQL !<br>'.$sql3.'<br>'.mysql_error());
//$taux_tva = mysql_result($result, 'taux_tva');
$obj=mysql_fetch_object($result);
$taux_tva=$obj->taux_tva;
//on recupere la marge
$sql4 = "SELECT marge FROM " . $tblpref ."article WHERE num = $article";
$result = mysql_query($sql4) or die('Erreur SQL !<br>'.$sql4.'<br>'.mysql_error());
//$marge = mysql_result($result, 'marge');
$obj=mysql_fetch_object($result);
$marge=$obj->marge;
//on récupère le nom d'article
$sql5 = "SELECT article_name FROM " . $tblpref ."article WHERE num = $article";
$result = mysql_query($sql5) or die('Erreur SQL !<br>'.$sql4.'<br>'.mysql_error());
$obj=mysql_fetch_object($result);
$article_name=$obj->article_name;
//Calcul du prix article
if ( (!$PV) && ($marge == '0')){ 
	$prix_article = $PA; 
}
elseif ((!$PV) && ($marge != '0')) { 
	$prix_article = (($marge / 100) + 1) * $PA; 
}
else { 
	$prix_article = $PV; 
}
$total_htva = $prix_article * $quanti ;
$mont_tva = $total_htva / 100 * $taux_tva ;
//on arrondit ici afin de plaire a Popsy
$mont_tva = sprintf("%.2f",$mont_tva);
if ($article_name == NULL) {
	//inserer les données dans la table du conten des bons.
	$sql1 = "INSERT INTO " . $tblpref ."cont_bon(p_u_jour, quanti, article_num, bon_num, tot_art_htva, to_tva_art, num_lot, fourn) 
	VALUES ('$prix_article', '$quanti', '$article', '$bon_num', '$total_htva', '$mont_tva', '$lot1', '$fourn')";
}
else {
	$sql1 = "INSERT INTO " . $tblpref ."cont_bon(p_u_jour, quanti, article_num, bon_num, tot_art_htva, to_tva_art, num_lot, article_name, fourn) 
	VALUES ('$prix_article', '$quanti', '$article', '$bon_num', '$total_htva', '$mont_tva', '$lot1', '$article_name', '$fourn')";
}
mysql_query($sql1) or die('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());
?>
<div class="portion">
    <!-- TITRE - LISTE ARTICLE DEJA AJOUTES -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-link fa-stack-1x"></i>
        </span>
        Articles d&eacute;j&agrave; li&eacute;s au bon <?php echo "$lang_numero $bon_num"; ?>
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
    <!-- CONTENT - LISTE ARTICLE DEJA AJOUTES -->
    <div class="content_traitement" id="alreadyadd">
    	<!-- TABLE CONTENANT LE DETAILS DES ARTICLES -->
        <table class='base' align="center" width="100%" id="already_add">
        	<thead>
            <tr>
                <th class=""><?php echo $lang_quantite ;?></th>
                <th class=""><?php echo $lang_unite ;?></th>
                <th class=""><?php echo $lang_article ;?></th>
                <th class=""><?php echo $lang_montant_htva ;?></th>
                <?php 
                if ($lot =='y') {
                    ?> 
                    <th class=""><?php echo "$lang_lot"; ?></th>
                    <?php 
                    } 
                    ?>
                <th class=""><? echo $lang_editer ;?></th>
                <th class=""><? echo $lang_supprimer ;?></th>
            </tr>
            </thead>
            <tbody>
            <?php 
            //on recherche tout les contenus du bon et on les detaille
            $sql ="SELECT ".$tblpref."cont_bon.num ,num_lot, uni, quanti, article, tot_art_htva, ".$tblpref."cont_bon.article_name as article_name";
            $sql.=" FROM ".$tblpref."cont_bon";
            $sql.=" RIGHT JOIN ".$tblpref."article on ".$tblpref."cont_bon.article_num = ".$tblpref."article.num";
            $sql.=" WHERE  bon_num = $bon_num";
            $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
            while($data = mysql_fetch_array($req))
            {
                $quanti = $data['quanti'];
                $uni = $data['uni'];
                $article = $data['article'];
                $article_name = $data['article_name'];
                $tot = $data['tot_art_htva'];
                $num_cont = $data['num'];//$lang_li_tot2
                $num_lot = $data['num_lot'];
                ?>		
                <tr>
                    <td class=''><?php echo"$quanti";?></td>
                    <td class=''><?php echo"$uni";?></td>
                    <td class=''><?php if($article_name == NULL) { echo $article;} else { echo $article_name;}?></td>
                    <td class=''><?php echo"$tot $devise"; ?></td>
                    <?php
                    if ($lot =='y') { ?>
                        <td class=''><a href=voir_lot.php?num=<?php echo"$num_lot";?> target='_blank'><?php echo"$num_lot";?></a></td>
                    <?php 
                    } 
                    ?>
                    <td class=''><a href="edit_cont_bon.php?num_cont=<?php echo"$num_cont";?>" class="no_effect"><i class="fa fa-pencil fa-2x action"></i></a></td>
                    <td class=''>
                        <a href="delete_cont_bon.php?num_cont=<?php echo"$num_cont";?>&amp;num_bon=<?php echo"$bon_num"; ?>" onClick='return confirmDelete(<?php echo"$num_cont"; ?>)' class="no_effect">
                        <i class="fa fa-trash fa-2x del"></i>
                        </a>
                    </td>
                </tr>
            <?php 
            }
        	?>
        	</tbody>
        </table>
        <br/><br/>
        <!-- TABLE CONTENANT LES TOTAUX -->
        <table class="base" width="100%">
        	<thead>
				<?php
                //on calcule la somme des contenus du bon
                $sql = " SELECT SUM(tot_art_htva) FROM " . $tblpref ."cont_bon WHERE bon_num = $bon_num";
                $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
                while($data = mysql_fetch_array($req))
                {
                    $total_bon = $data['SUM(tot_art_htva)'];
                }
                //on calcule la some de la tva des contenus du bon
                $sql = " SELECT SUM(to_tva_art) FROM " . $tblpref ."cont_bon WHERE bon_num = $bon_num";
                $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
                while($data = mysql_fetch_array($req))
                {
                    $total_tva = $data['SUM(to_tva_art)'];
                }
                ?>
                <tr>
                    <th class='right' width="50%"><?php echo $lang_total_h_tva; ?> :</th>
                    <th class='left' width="50%"><?php echo $total_bon." ".$devise;?>  </th>
                </tr>
                <tr>
                    <th class='right'>Total <?php echo $lang_tva;?> :</th>
                    <th class='left'><?php echo $total_tva." ".$devise;?></th>
                </tr>
            </thead>
        </table>
	</div>
</div>

<div class="portion">
    <!-- TITRE - AJOUT ARTICLES -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-plus fa-stack-1x"></i>
        </span>
        <?php echo "$lang_bon_ajouter $lang_numero $bon_num"; ?>
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
    <!-- CONTENT - AJOUT ARTICLES -->
    <div class="content_traitement" id="add">
        <form name='formu2' method='post' action='bon_suite.php'>
            <table class="base" align="center" width="100%">
                <tr>
                    <td class='right' width="30%"><?php echo"$lang_article"; ?> :</td>
                    <td class='left' width="70%"><? include("include/categorie_choix.php"); ?></td>
                </tr>
                <tr>
                    <td class='right'><?php echo "$lang_quanti"; ?> :</td>
                    <td class='left'><input name='quanti' type='text' id='quanti' value="1" size='6' class="styled"></td>
                </tr>
                <tr>
                    <td class='right'>PV (HTVA) :</td>
                    <td class='left'><input name='PV' type='text' id='PV' size='6' class="styled"></td>
                </tr>
            </table>
            <div class="center">
                <button type="submit" class="button_act button--shikoba button--border-thin medium"><i class="button__icon fa fa-plus"></i><span>Ajouter au bon</span></button>
            </div>
            <input type="hidden" name="bon_num" value="<?php echo $bon_num;?>" />
            <input name="nom" type="hidden" id="nom" value="<?php echo $nom ?>">
        </form>
	</div>
</div>

<div class="portion">
    <!-- TITRE - TERMINER & ENREGISTRER -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-floppy-o fa-stack-1x"></i>
        </span>
        <?php echo "$lang_bon_enregistrer "; ?>
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
    <!-- CONTENT - TERMINER & ENREGISTRER -->
    <div class="content_traitement" id="terminate">
        <form action="bon_fin.php" method="post" name="fin_bon">
            <table class="base" align="center" width="100%">
                <tr>
                    <td class="" ><?php echo $lang_ajo_com_bo ?></td>
                </tr>
                <tr>
                    <td class="">
                        <textarea name="coment" cols="80" rows="3" class="styled"></textarea>
                    </td>
                </tr>
            </table>
            <div class="center">
                <button type="submit" class="button_act button--shikoba button--border-thin medium"><i class="button__icon fa fa-floppy-o"></i><span>Enregistrer</span></button>
            </div>
            <input type="hidden" name="tot_ht" value=<?php echo $total_bon ?>>
            <input type="hidden" name="tot_tva" value=<?php echo $total_tva ?>>
            <input type="hidden" name="bon_num" value=<?php echo $bon_num ?>>
            <input type="hidden" name="client_num" value=<?php echo $client ?>>
        </form>
	</div>
</div>
<?php 
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>