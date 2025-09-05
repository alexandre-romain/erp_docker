<!--BENEFICE-->
<div class="portion">
    <!-- TITRE - BENEFICE -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-line-chart fa-stack-1x"></i>
        </span>
        <?php echo "$lang_evo_ben $annee" ?>
        <span class="fa-stack fa-lg add" style="float:right" id="show_ben">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_ben">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - BENEFICE -->
    <div class="content_traitement" id="ben">
        <table class="base" width="100%">
        	<thead>
                <tr>
                    <th class="" width="20%"><?php echo "$lang_periode" ?></th>
                    <th class="" width="30%">B&eacute;n&eacute;fice (%)</th>
                	<th width="50%">B&eacute;n&eacute;fice (montant)</th>
                </tr>
            </thead>
            <tbody>
            <?
            $sql = "SELECT SUM( prix ) htva FROM " . $tblpref ."depense WHERE YEAR( date ) = $annee ";
            $req = mysql_query($sql);
            $req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
            $total_dep= mysql_result($req,0);
            $total_gen = $total - $total_dep ;
            reset ($liste_mois);
            while (list ($numero_mois, $nom_mois) = each ($liste_mois))
            {
                $tot = montant_financier ($recettes [$numero_mois]["htva"] - $depenses [$numero_mois]["htva"]);
                $pourcentage = number_format( round( ($tot*100)/$total), 0, ",", " "); 
                ?>
                <tr>
                    <td class=''><?php echo ucfirst ($nom_mois); ?></td>
                    <td class=''><?php echo stat_baton_horizontal("$pourcentage %"); ?></td>
                    <td class=''><?php echo montant_financier ($recettes [$numero_mois]["htva"]- $depenses [$numero_mois]["htva"]); ?></td>
                </tr>
            <?php
            }
            ?>
            </tbody>
            <tfoot>
                <tr>
                    <th class='right' colspan="2"><?php echo $lang_total; ?> :</th>
                    <th class='left'><?php echo montant_financier($total_gen)?></th>
                </tr>
            </tfoot>
        </table>
	</div>
</div>


