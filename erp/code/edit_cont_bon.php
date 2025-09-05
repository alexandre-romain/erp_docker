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
$num_cont=isset($_GET['num_cont'])?$_GET['num_cont']:"";
?>
<!--SEARCH FILTER-->
<div class="portion">
    <!-- TITRE - SEARCH -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-pencil fa-stack-1x"></i>
        </span>
        <?php  echo $lang_edi_cont_bon ?>
        <span class="fa-stack fa-lg add" style="float:right" id="show_create">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_create">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - SEARCH -->
    <div class="content_traitement" id="create">
        <form name="formu2" method="post" action="suite_edit_cont_bon.php">
            <table class="base" width="100%">
                <?php
                $sql = "SELECT * FROM " . $tblpref ."cont_bon  RIGHT JOIN " . $tblpref ."article on " . $tblpref ."cont_bon.article_num = " . $tblpref ."article.num WHERE  " . $tblpref ."cont_bon.num = $num_cont";
                $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
                while($data = mysql_fetch_array($req))
                {
                    $quanti = $data['quanti'];
                    $article = $data['article'];
                    $tot = $data['tot_art_htva'];
                    $num_art = $data['num'];
                    $article_num = $data['article_num'];
                    $bon_num = $data['bon_num'];
                    $prix_ht = $data['prix_htva'];
                    $num_lot = $data['num_lot'];
                }
                ?>
                <tr>
                    <td class='right' width="30%">S&eacute;lectionnez un nouvel article :</td>
                    <td class='left' width="70%">
                        <?
                        include("include/categorie_choix.php"); 
                        ?>
                    </td>
                </tr>
                <tr>
                    <td class="right"><?php echo $lang_quanti ?> :</td>
                    <td class="left"><input name="quanti" type="text" size="5" id="quanti" value='<?php echo"$quanti"?>' class="styled"></td>
                </tr>
                <tr>
                   <td class="right">PV (HTVA) :</td>              
                   <td class="left"><input name="PV" type="text" size="5" id="PV" class="styled"> &euro;</td>	                           
                </tr>
            </table>
            <div class="center">
                <button class="button_act button--shikoba button--border-thin medium" type="submit"><i class="button__icon fa fa-pencil"></i><span><?php echo $lang_modifier ?></span></button>
            </div>
            <input name="num_cont" type="hidden" value=<?php echo $num_cont ?>>
           	<input name="bon_num" type="hidden" value=<?php echo $bon_num ?>>
        </form>
	</div>
</div>
<?php 
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>