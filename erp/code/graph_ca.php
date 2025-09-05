<!--CA/EVO-->
<div class="portion">
    <!-- TITRE - CA/EVO -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-line-chart fa-stack-1x"></i>
        </span>
        <?php echo "$lang_evo_ca $annee" ?>
        <span class="fa-stack fa-lg add" style="float:right" id="show_cae">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_cae">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - CA/EVO -->
    <div class="content_traitement" id="cae">
        <table class="base" width="100%">
        	<thead>
            <tr>
                <th class="" width="20%"><?php echo "$lang_periode" ?></th>
                <th class="" width="30%">Chiffre d'affaire (%)</th>
                <th width="50%">Chiffre d'affaire (montant)</th>
           </tr>
           </thead>
           <tbody>
            <?
            $sql = "SELECT SUM( tot_htva ) FROM " . $tblpref ."bon_comm WHERE YEAR( date ) = $annee ";
            $req = mysql_query($sql);
            $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
            $total= mysql_result($req,0);
            $total = montant_financier($total);
            reset ($liste_mois);
            while (list ($numero_mois, $nom_mois) = each ($liste_mois))
            {
                $tot = montant_financier ($recettes [$numero_mois]["htva"]);
                $pourcentage = number_format( round( ($tot*100)/$total), 0, ",", " "); 
                ?>
                <tr>
                    <td class=''><?php echo ucfirst ($nom_mois); ?></td>
                    <td class=''><?php echo stat_baton_horizontal("$pourcentage %"); ?></td>
                    <td class=''><?php echo montant_financier ($recettes [$numero_mois]["htva"]); ?></td>
                </tr>
            <?php
            }
            ?>
            </tbody>
            <tfoot>
                <tr>
                    <th class='right' colspan="2"><?php echo $lang_total;?> :</th>
                    <th class='left'><?php echo montant_financier($total)?></th>
                </tr>
            </tfoot>
        </table>
	</div>
</div>