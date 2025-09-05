<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script>
function confirmDelete()
{
	var agree=confirm('<?php echo "$lang_con_effa"; ?>');
	if (agree)
	 return true ;
	else
	 return false ;
}
</script>
<?php 
//Ferme le <head>, ouvre le <body> & inclus le menu + ouverture content
include_once("include/finhead.php");
///FINHEAD
$mois = date("m");
//Sélection des bon commande qui ne sont pas entièrement livrés.
$sql = "SELECT client_num, nom, nom2, num_bon, tot_htva, tot_tva, DATE_FORMAT(date,'%d/%m/%Y') AS date 
FROM ".$tblpref."bon_comm 
RIGHT JOIN ".$tblpref."client ON ".$tblpref."bon_comm.client_num = num_client 
WHERE bl !='end' AND EXISTS (SELECT * FROM ".$tblpref."cont_bon WHERE ".$tblpref."cont_bon.bon_num = ".$tblpref."bon_comm.num_bon) 
ORDER BY num_bon DESC";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
?>
<!--FILTRES-->
<div class="portion">
    <!-- TITRE - LISTE -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-clock-o fa-stack-1x"></i>
        </span>
        Back Orders
        <span class="fa-stack fa-lg add" style="float:right" id="show_filtre">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_filtre">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <div class="content_traitement" id="filtre">
        <table class="base" width="100%" border="0">
            <?php
            $nombre=1;
            while($data = mysql_fetch_array($req))
            {
                $num_bon = $data['num_bon'];
                $total = $data['tot_htva'];
                $tva = $data['tot_tva'];
                $date = $data['date'];
                $nom = $data['nom'];
                $num_client= $data['client_num'];
                ?>
                <thead>
                <tr>
                    <th colspan="4" class="left" style="background:#d35400;">Commande n°<? echo $num_bon." du ".$date; ?></th>
                </tr>
                <tr>
                    <td colspan="4" class="left">Client : <? echo $nom; ?></td>
                </tr>
                <tr>
                    <th class="subtitle">Article</th>
                    <th class="subtitle">Unité</th>
                    <th class="subtitle">Commandé</th>
                    <th class="subtitle">BO</th>
                </tr>	
                </thead>
                <tbody>
					<?
                    //On récupère les articles contenue dans le bon
                    $sql2 = "SELECT article_num, quanti, p_u_jour, livre 
                    FROM " . $tblpref ."cont_bon
                    WHERE bon_num = $num_bon";
                    $req2 = mysql_query($sql2) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
                    while($data2 = mysql_fetch_array($req2))
                    {
                        $article_num = $data2['article_num'];
                        $quanti = $data2['quanti'];
                        $p_u_jour = $data2['p_u_jour'];
                        $livre = $data2['livre'];
                        $bo = $quanti - $livre;
                        $sql3 = "SELECT article, uni, marque
                        FROM " . $tblpref ."article
                        WHERE num = $article_num";
                        $req3 = mysql_query($sql3) or die('Erreur SQL !<br>'.$sql3.'<br>'.mysql_error());
                        while($data3 = mysql_fetch_array($req3))
                        {
                            $nombre = $nombre +1;
                            if($nombre & 1){$line="0";}else{$line="1";}
                            $article = $data3['article'];
                            $uni = $data3['uni'];
                            $marque = $data3['marque'];
                        }
                        ?>
                    <tr class="texte<?php echo"$line" ?>" onmouseover="this.className='highlight'" onmouseout="this.className='texte<?php echo"$line" ?>'">
                        <td class="highlight"><?php echo $marque." ".$article; ?></td>
                        <td class="highlight"><?php echo $uni; ?></td>			
                        <td class="highlight"><?php echo $quanti; ?></td>
                        <td class="highlight"><?php if ($bo > '0') {echo "<span class=\"bo_valid\">".$bo."</span>";} else {echo $bo;} ?></td>
                    </tr>
                </tbody>
                <?
                }
				?>
                <tr>
					<td style="background:#34495e" colspan="4">&nbsp;</td>
                </tr>
                <tr>
					<td style="" colspan="4">&nbsp;</td>
                </tr>
                <?php
            }
            ?>
        </table>
	</div>
</div>
<?php 
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>
