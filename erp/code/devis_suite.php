<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script>
function confirmDelete()
{
var agree=confirm('<?php echo "$lang_conf_effa"; ?>');
if (agree)
 return true ;
else
 return false ;
}
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
$quanti=isset($_REQUEST['quanti'])?$_REQUEST['quanti']:"";
$article=isset($_REQUEST['article'])?$_REQUEST['article']:"";
$num=isset($_REQUEST['num'])?$_REQUEST['num']:"";
$nom=isset($_REQUEST['nom'])?$_REQUEST['nom']:"";
$PV=isset($_REQUEST['PV'])?$_REQUEST['PV']:"";
if($article=='0' || $quanti=='')
{
	$message = $lang_champ_oubli;
	include('form_devis.php'); 
	exit;
}
//touver le dernier enregistrement pour le numero de bon
$sql = "SELECT MAX(num_dev) As Maxi FROM ".$tblpref."devis";
$result = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
$obj=mysql_fetch_object($result);
$max=$obj->Maxi;
?>
<!--DEJA AJOUTE DANS LE DEVIS-->
<div class="portion">
    <!-- TITRE - DEJA AJOUTE DANS LE DEVIS -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-link fa-stack-1x"></i>
        </span>
        Articles d&eacute;j&agrave; li&eacute;s au devis N° <?php echo $max;?>
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
    <!-- CONTENT - DEJA AJOUTE DANS LE DEVIS -->
    <div class="content_traitement" id="alreadyadd">
        <table class='base' align="center" width="100%" id="already_add">
            <thead>
                <tr>
                    <th class="" width="10%"><? echo $lang_quantite ;?></th>
                    <th class="" width="20%"><? echo $lang_unite ;?></th>
                    <th class="" width="20%"><? echo $lang_article ;?></th>
                    <th class="" width="15%">Partnumber</th>
                    <th class="" width="15%"><? echo $lang_montant_htva ;?></th>
                    <th class="" width="10%"><? echo $lang_editer ;?></th>
                    <th class="" width="10%"><? echo $lang_supprimer ;?></th>
                </tr>
            </thead>
            <tbody>
                <?php 
                //trouver le client correspodant au dernier bon
                $sql = "SELECT client_num FROM ".$tblpref."devis WHERE num_dev=".$max."";
                $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
                while($data = mysql_fetch_array($req))
                {
                    $num = $data['client_num'];
                }
                //on recupere le prix htva		
                $sql2 = "SELECT prix_htva FROM " . $tblpref ."article WHERE num = $article";
                $result = mysql_query($sql2) or die('<div style="margin-bottom:2%;color:#FFF;font-size:18px;font-weight:bold;">ATTENTION : Vous n\'avez s&eacute;lectionn&eacute; aucun article, revenez en arri&egrave;rre et s&eacute;lectionnez un article.</div>');
                $obj=mysql_fetch_object($result);
                //$PA = mysql_result($result, 'prix_htva');
                $PA=$obj->prix_htva;
                //on recupere le taux de tva
                $sql3 = "SELECT taux_tva FROM " . $tblpref ."article WHERE num = ".$article."";
                $result = mysql_query($sql3) or die('Erreur SQL !<br>'.$sql3.'<br>'.mysql_error());
                $obj=mysql_fetch_object($result);
                //$taux_tva = mysql_result($result, 'taux_tva');
                $taux_tva=$obj->taux_tva;
                //on recupere la marge
                $sql4 = "SELECT marge FROM " . $tblpref ."article WHERE num = ".$article."";
                $result = mysql_query($sql4) or die('Erreur SQL !<br>'.$sql4.'<br>'.mysql_error());
                $obj=mysql_fetch_object($result);
                //$marge = mysql_result($result, 'marge');
                $marge=$obj->marge;
            
                if ( (!$PV) && ($marge == '0'))
                { 
                    $prix_article = $PA; 
                }
                elseif ((!$PV) && ($marge != '0'))
                { 
                    $prix_article = (($marge / 100) + 1) * $PA; 
                }
                else
                { 
                    $prix_article = $PV; 
                }
            
                $total_htva = $prix_article * $quanti ;
                $mont_tva = $total_htva / 100 * $taux_tva ;
            
                //inserer les données dans la table du conten des bons.
                mysql_select_db($db) or die ("Could not select $db database");
                $sql1 = "INSERT INTO " . $tblpref ."cont_dev(p_u_jour, quanti, article_num, dev_num, tot_art_htva, to_tva_art) VALUES ('$prix_article', '$quanti', '$article', '$max', '$total_htva', '$mont_tva')";
                mysql_query($sql1) or die('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());
                
                //on recherche tout les contenus du bon et on les detaille
                $sql2 = "SELECT cd.num, uni, quanti, article, tot_art_htva, reference"; 
                $sql2.=" FROM ".$tblpref."cont_dev as cd";
                $sql2.=" RIGHT JOIN ".$tblpref."article as a on cd.article_num=a.num"; 
                $sql2.=" WHERE dev_num='".$max."'";
                $req = mysql_query($sql2) or die('Erreur SQL2 !<br>'.$sql2.'<br>'.mysql_error());
                while($data = mysql_fetch_array($req))
                {
                    $quanti = $data['quanti'];
                    $uni = $data['uni'];
                    $article = $data['article'];
                    $tot = $data['tot_art_htva'];
                    $num_cont = $data['num'];//$lang_li_tot2
                    ?>
                    <tr>
                        <td class=''><?php echo $quanti; ?></td>
                        <td class=''><?php echo $uni;  ?></td>
                        <td class=''><?php echo $article; ?></td>
                        <td class=''><?php echo $data['reference']; ?></td>
                        <td class=''><?php echo $tot.$devise; ?></td>
                        <td class=''>
                            <form method="post" action="edit_cont_dev.php">
                                <button class="icons fa-pencil fa-2x action"></button>
                                <input type="hidden" name="num_cont" value="<?php echo $num_cont; ?>">
                            </form>
                        </td>
                        <td class=''>
                            <a href=delete_cont_dev.php?num_cont=<?php echo $num_cont;?>&num_dev=<?php echo $max; ?> onClick='return confirmDelete()' class="no_effect">
                            	<i class="fa fa-trash fa-2x del"></i>
                            </a>
                        </td>
                    </tr>
                <?php 
                }
                //on calcule la somme des contenus du bon
                $sql = " SELECT SUM(tot_art_htva) FROM " . $tblpref ."cont_dev WHERE dev_num = ".$max."";
                $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
                while($data = mysql_fetch_array($req))
                {
                    $total_bon = $data['SUM(tot_art_htva)'];
                }
                //on calcule la some de la tva des contenus du bon
                $sql = " SELECT SUM(to_tva_art) FROM " . $tblpref ."cont_dev WHERE dev_num = ".$max."";
                $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
                while($data = mysql_fetch_array($req))
                {
                    $total_tva = $data['SUM(to_tva_art)'];
                }    
                ?>
            </tbody>
        </table>
        <br/><br/>
        <table class="base" width="100%">
        	<thead>
            	<tr>
                    <th class='right' width="50%"><? echo $lang_total; ?> HTVA :</th>
                    <th class='left' width="50%"><? echo "$total_bon $devise"; ?></th>
                </tr>
                <tr>
                    <th class='right'>Total <? echo $lang_tva; ?> :</th>
                    <th class='left'><? echo "$total_tva $devise";?></th>
                </tr>
            </thead>
        </table>
	</div>
</div>

<!--AJOUT-->
<div class="portion">
    <!-- TITRE - AJOUT -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-pencil fa-stack-1x"></i>
        </span>
        Ajouter au devis N° <?php echo $max;?>
        <span class="fa-stack fa-lg add" style="float:right" id="show_add">
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
    <!-- CONTENT - AJOUT -->
    <div class="content_traitement" id="add">
        <form name='formu2' method='post' action='devis_suite.php'>
        <table class="base" width="100%">
        	<tbody>
                <tr> 
                    <td class="right" width="30%"><?php echo $lang_article;  ?> :</td>
                    <td class="left" width="70%"> 
                        <?php
                        include("include/categorie_choix.php"); 
                        ?>
                    </td>
                </tr>
                <tr> 
                    <td class="right"> <?php echo $lang_quanti; ?> :</td>
                    <td class="left"><input name='quanti' type='text' id='quanti' value="1" size='6' class="styled"></td>
                </tr>
                <tr>
                    <td class="right">PV (HTVA) :</td>
                    <td class="left"><input name='PV' type='text' id='PV' size='6' class="styled"> &euro;</td>
                </tr>
            </tbody>
        </table>
        <div class="center">
            <button class="button_act button--shikoba button--border-thin medium" type="submit"><i class="button__icon fa fa-plus"></i><span>Ajouter au devis</span></button>
        </div>
        <input name="nom" type="hidden" id="nom" value='<?php echo $nom; ?>'>
        </form>
	</div>
</div>

<!--TERMINER & ENREGISTRER-->
<div class="portion">
    <!-- TITRE - TERMINER & ENREGISTRER -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-floppy-o fa-stack-1x"></i>
        </span>
        Enregistrer le devis
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
    <!-- CONTENT - TERMINER & ENREGISTRER -->
    <div class="content_traitement" id="terminate">
        <form action="dev_fin.php" method="post" name="fin_dev">
        <table class="base" width="100%">
            <tr>
                <td class="">Dénomination (30 caract. max. | optionnel)</td>
            </tr>
            <tr>
                <td class=""><input name="explic" type="text" id="explic" value="<?php echo $explic; ?>" size="40" maxlength="30" class="styled"/></td>
            </tr>
            <tr>
                <td class="">Commentaire (optionnel)</td>
            </tr>
            <tr>
                <td colspan='4' class=''>
                    <textarea name="coment" cols="45" rows="3" class="styled"></textarea>   
                </td>
            </tr>   
        </table>
        <div class="center">
            <button class="button_act button--shikoba button--border-thin medium" type="submit"><i class="button__icon fa fa-floppy-o"></i><span>Enregistrer</span></button>
        </div>
        <input type="hidden" name="tot_ht" value=<?php echo $total_bon; ?>>
        <input type="hidden" name="tot_tva" value=<?php echo $total_tva; ?>>
        <input type="hidden" name="dev_num" value=<?php echo $max; ?>>
        </form>
	</div>
</div>
<?php 
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>