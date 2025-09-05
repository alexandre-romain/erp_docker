<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script>

</script>
<?php 
//Ferme le <head>, ouvre le <body> & inclus le menu + ouverture content
include_once("include/finhead.php");
///FINHEAD
$num_cont=isset($_POST['num_cont'])?$_POST['num_cont']:"";
$sql = "SELECT * FROM " . $tblpref ."cont_dev  RIGHT JOIN " . $tblpref ."article on " . $tblpref ."cont_dev.article_num = " . $tblpref ."article.num WHERE  " . $tblpref ."cont_dev.num = $num_cont";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data = mysql_fetch_array($req))
{
  $quanti = $data['quanti'];
  $article = $data['article'];
  $tot = $data['tot_art_htva'];
  $num_art = $data['num'];
  $article_num = $data['article_num'];
  $dev_num = $data['dev_num'];
  $prix_ht = $data['prix_htva'];
  //echo " $bon_num <br>";
}
?>
<div class="portion">
    <!-- TITRE - EDITION 1 ARTICLE -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-pencil fa-stack-1x"></i>
        </span>
        <?php  echo "$lang_edi_cont_devis"; ?>
        <span class="fa-stack fa-lg add" style="float:right" id="show_edit">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_edit">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - EDITION 1 ARTICLE -->
    <div class="content_traitement" id="edit">
        <form name="formu2" method="post" action="suite_edit_cont_dev.php">
        <table class="base" width="100%">
            <tr> 
                <td class="right" width="30%"><?php echo $lang_article ;?> :</td>
                <td class="left" width="70%">
                	<?php
                    include("include/categorie_choix.php"); 
					?>
                </td>
            </tr>
            <tr> 
                <td class="right" ><?php echo $lang_quanti ?> :</td>
                <td class="left"><input name="quanti" type="text" size="5" id="quanti" value='<?php echo $quanti; ?>' class="styled"></td> 
            </tr>
            <tr>
                <td class="right" >PV (HTVA) :</td>
                <td class="left"><input name="PV" type="text" size="5" id="PV" class="styled"></td>
            </tr>  
        </table>
        <div class="center">
            <button class="button_act button--shikoba button--border-thin medium" type="submit"><i class="button__icon fa fa-pencil"></i><span><?php echo $lang_modifier ?></span></button>
        </div>
        <input name="num_cont" type="hidden" id="nom" value=<?php echo $num_cont ?>>
        <input name="dev_num" type="hidden" id="nom" value=<?php echo $dev_num ?>>
        </form>
	</div>
</div> 
<?php 
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>
