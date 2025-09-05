<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script>
$(document).ready(function() {
	$("#show_traitement").hide();
	$("#hide_traitement").click(function(){
		$("#traitement").hide(500);	
		$("#hide_traitement").hide();
		$("#show_traitement").show();
	});
	$("#show_traitement").click(function(){
		$("#traitement").show(500);	
		$("#hide_traitement").show();
		$("#show_traitement").hide();
	});
});
</script>
<?php 
//Ferme le <head>, ouvre le <body> & inclus le menu + ouverture content
include_once("include/finhead.php");
///FINHEAD
//Gestion des messages informatifs
include_once("include/message_info.php");
?>
<!--RESULTATS-->
<div class="portion">
    <!-- TITRE - RESULTATS -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-search fa-stack-1x"></i>
        </span>
        D&eacute;tails des diff&eacute;rentes factures devant &ecirc;tre pass&eacute;e en note de cr&eacute;dit
        <span class="fa-stack fa-lg add" style="float:right" id="show_traitement">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_traitement">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - RESULTATS -->
    <div class="content_traitement" id="traitement">
        <form action="edit_nc.php" method="post">
            <?php
            $num_client=$_POST['num_client'];
            foreach ($_POST['list_fact'] as $num) {
                $sql = "SELECT cb.num AS ligne, a.article aarticle, cb.article_num as cbarticle_num, cb.serial as cbserial, bl.num_bl as blnum_bl, cb.p_u_jour as cbp_u_jour, cb.quanti as cbquanti"; 
                $sql.= " FROM ".$tblpref."bl as bl"; 
                $sql.= " LEFT JOIN ".$tblpref."cont_bl as cb ON bl.num_bl=cb.bl_num";
                $sql.= " LEFT JOIN ".$tblpref."article as a ON cb.article_num=a.num"; 
                $sql.= " WHERE fact_num = ".$num." ORDER BY num_bl";
                $result = mysql_query($sql) or die ("requete foreach1 impossible");
                ?>
                <div class="portion_subtitle"><i class="fa fa-file"></i> Détail facture n°<?php echo $num; ?></div>
                <table class="base" width="100%">
                	<thead>
                        <tr>
                            <th class="">N° BL</th>
                            <th class="">Article</th>
                            <th class="">N° de série</th>
                            <th class="">Prix unitaire</th>
                            <th class="">Quantit&eacute;</th>
                            <th class="">N° de ligne</th>
                            <th class="">Etat</th>
                            <th class="">Passer en NC</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    while ($data = mysql_fetch_array($result)) { //--------------------------------------------------------------
                        $quanti= $data['cbquanti'];
                        $numBL= $data['blnum_bl'];
                        $test= $data['cbarticle_num'];
                        $article= $data['aarticle'];
                        $sery= $data['cbserial'];
                        $new_serial = explode(" | ", $sery);
                        $prix= $data['cbp_u_jour'];
                        $ligne= $data['ligne'];
                        $sql2 = "SELECT status";
                        $sql2.= " FROM ".$tblpref."stock"; 
                        $sql2.= " WHERE article = $test AND serial= '".$new_serial."'";
                        mysql_query($sql2) OR die("<p>Erreur Mysql<br/>$sql2<br/>".mysql_error()."</p>");
                        $result2 = mysql_query($sql2) or die ("requete foreach1 impossible");
                        $data2 = mysql_fetch_array($result2);
                        $status = $data2['status'];
                        ?>
                        
                        <?php foreach ($new_serial as $serial){ ?>
                            <tr class="">
                                <td><?php echo $numBL; ?></td>
                                <td><?php echo $article; ?></td>
                                <td><?php echo $serial; ?></td>
                                <td><?php echo $prix; ?> &euro;</td>
                                <td><?php echo $quanti; ?></td>
                                <td><?php echo $ligne; ?></td>
                                <td><input type="checkbox" <?php if ($status!="out"){echo "checked='checked'";} ?>/></td>
                                <td><input type="checkbox" name="line[]" value="<? echo $ligne; ?>" /><input type="hidden" name="client" value="<? echo $num_client; ?>"/></td>
                            </tr>
                        <?php
                        } // fin du 2e foreach
                    } //fin du while
                	?>
                    </tbody>
                </table>
            <?php	
            } //fin du 1er foreach
            ?>
            <div class="center">
            <button class="button_act button--shikoba button--border-thin medium" type="submit"><i class="button__icon fa fa-check"></i><span>Valider</span></button>
        	</div> 
        </form>
	</div>
</div>
<?php
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>
