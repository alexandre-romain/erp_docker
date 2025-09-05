<?php 
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/language/$lang.php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("javascripts/verif_form.js");
include_once("include/finhead.php");
?>
<table width="760" border="0" class="page" align="center">
<tr>
<td class="page" align="center">
<?php
include_once("include/head.php");
?>
</td>
</tr>
<tr>
<td  class="page" align="center">
<?php 
if ($user_art == n) { 
echo "<h1>$lang_article_droit";
exit;  
}
 if ($message !='') { 
 echo"<table><tr><td>$message</td></tr></table>"; 
}?>
  
      <form action="article_new.php" method="post" name="artice" id="artice" onSubmit="return verif_formulaire()" >
        <center>
        <table>
          <caption>
          <?php echo $lang_article_creer; ?> 
          </caption>
		 <?php
		 include_once("include/configav.php");
		 if ($use_categorie =='y') { ?>
          <tr> 
            <td  class='<?php echo couleur_alternee (); ?>'><?php echo"$lang_categorie" ?> 
            <td class='<?php echo couleur_alternee (FALSE); ?>'> 
              <?php
																	$rqSql = "SELECT id_cat, categorie FROM " . $tblprefluc ."categorie WHERE 1 ORDER BY categorie ASC";
																	$result = mysql_query( $rqSql ) or die( "Exécution requête impossible."); ?>
              <SELECT NAME='categorie'>
                <OPTION VALUE='0'><?php echo $lang_choisissez; ?></OPTION>
                <?php
																	while ( $row = mysql_fetch_array( $result)) {
   													 			$num_cat = $row["id_cat"];
    												 			$categorie = $row["categorie"];
    												 			?>
                <OPTION VALUE='<?php echo "$num_cat" ; ?>'><?php echo "$categorie"; ?></OPTION>
                <?
														 			}
														 			?>
              </SELECT> 
              <?php } ?>
          
          <tr> 
            <td class='<?php echo couleur_alternee (); ?>'>Marque :</td>
            <td class='<?php echo couleur_alternee (FALSE); ?>'><input name="marque" type="text" id="marque" size="40"></td>
          </tr>
          <tr> 
            <td class='<?php echo couleur_alternee (); ?>'> <?php echo "$lang_art_no"; ?> </td>
            <td class='<?php echo couleur_alternee (FALSE); ?>'> <input name="article" type="text" id="article" size="40" maxlength="40"> 
            </td>
          </tr>
			<tr> 
            <td class='<?php echo couleur_alternee (); ?>'>R&eacute;f&eacute;rence :</td>
            <td class='<?php echo couleur_alternee (FALSE); ?>'><input name="reference" type="text" id="reference" size="40"></td>
          </tr>
		  <tr> 
            <td class='<?php echo couleur_alternee (); ?>'> <?php echo "$lang_uni_art" ?> 
            </td>
            <td class='<?php echo couleur_alternee (FALSE); ?>'><input name="uni" type="text" id="uni" size="8" maxlength="8" value=""> 
            </td>
          </tr>
          <tr> 
            <td class='<?php echo couleur_alternee (); ?>'> Prix Achat </td>
            <td class='<?php echo couleur_alternee (FALSE); ?>'> <input name="prix" type="text" id="prix" size="8"> 
              &euro; (PV Si marge = 0 -&gt; service) </td>
          </tr>
          <tr> 
            <td class='<?php echo couleur_alternee (); ?>'> <?php echo "$lang_ttva" ?></td>
            <td class='<?php echo couleur_alternee (FALSE); ?>'> <input name="taux_tva" type="text" id="taux_tva" value="21" size="5" maxlength="5">
              %</td>
          </tr>
          <tr> 
            <td class='<?php echo couleur_alternee (); ?>'> <?php echo "$langCommentaire" ?> 
              : </td>
            <td class='<?php echo couleur_alternee (FALSE); ?>'><input name="commentaire" type="text" id="commentaire" size="40"> 
            </td>
          </tr>
          <tr> 
            <td class='<?php echo couleur_alternee (); ?>'><?php echo "$lang_stock"; ?></TD>
            <td class='<?php echo couleur_alternee (FALSE); ?>'><input name='stock' type='text' size="8"> 
            </td>
          </tr>
          <tr> 
            <td class='<?php echo couleur_alternee (); ?>'><?php echo"$lang_stomin"; ?></td>
            <td class='<?php echo couleur_alternee (FALSE); ?>'><input name='stomin' type='text' size="8"></td>
          </tr>
          <tr> 
            <td class='<?php echo couleur_alternee (); ?>'><?php echo"$lang_stomax"; ?></td>
            <td class='<?php echo couleur_alternee (FALSE); ?>'><input name='stomax' type='text' size="8"></td>
          <tr> 
            <td class='<?php echo couleur_alternee (); ?>'>Marge :</td>
            <td class='<?php echo couleur_alternee (FALSE); ?>'><input name="marge" type="text" id="marge" size="8">
              % (0 pour le service) </td>
          </tr>
          <tr> 
            <td class='<?php echo couleur_alternee (); ?>'>Garantie :</td>
            <td class='<?php echo couleur_alternee (FALSE); ?>'><input name="garantie" type="text" id="garantie" value="1 an" size="8"></td>
          </tr>
          <tr> 
            <td class='<?php echo couleur_alternee (); ?>'>Recupel (HTVA) :</td>
            <td class='<?php echo couleur_alternee (FALSE); ?>'><input name="recupel" type="text" id="recupel" size="8">
              &euro; </td>
          </tr>
          <tr> 
            <td class='<?php echo couleur_alternee (); ?>'>Reprobel (HTVA) :</td>
            <td class='<?php echo couleur_alternee (FALSE); ?>'><input name="reprobel" type="text" id="reprobel" size="8">
              &euro; </td>
          </tr>
          <tr> 
            <td class='<?php echo couleur_alternee (); ?>'>Bebat (HTVA) :</td>
            <td class='<?php echo couleur_alternee (FALSE); ?>'><input name="bebat" type="text" id="bebat" size="8">
              &euro; </td>
          </tr>
          <tr> 
            <td class="submit" colspan="2"> <input type="submit" name="Submit" value="<?php echo $lang_envoyer; ?>"> 
              <input name="reset" type="reset" id="reset" value="<?php echo $lang_effacer; ?>"> 
            </td>
          </tr>
        </table>
      </center>
      </form>
      <?php
			if ($use_categorie =='y') { 
			echo"<tr><td>";
			include_once("ajouter_cat.php");
			}
			$aide = article;
			require_once("lister_articles.php");

?>




