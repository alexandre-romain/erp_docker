<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script>
$(document).ready(function() {
	$( "#hide_filtre" ).hide();
	$( "#show_liste" ).hide();
	$( "#show_filtre" ).click(function() {
		$( "#filtre" ).show(500);
		$( "#show_filtre" ).hide();
		$( "#hide_filtre" ).show();
	});
	$( "#hide_filtre" ).click(function() {
		$( "#filtre" ).hide(500);
		$( "#show_filtre" ).show();
		$( "#hide_filtre" ).hide();
	});
	
	$( "#show_liste" ).click(function() {
		$( "#liste" ).show(500);
		$( "#show_liste" ).hide();
		$( "#hide_liste" ).show();
	});
	$( "#hide_liste" ).click(function() {
		$( "#liste" ).hide(500);
		$( "#show_liste" ).show();
		$( "#hide_liste" ).hide();
	});
} );
<!-- DT LISTE COMMANDES -->
$(document).ready(function() {
    $('#list').DataTable( {
		"language": {
			"lengthMenu": 'Afficher <div class="styled-select-dt"><select class="styled-dt">'+
						'<option value="10">10</option>'+
						'<option value="20">20</option>'+
						'<option value="30">30</option>'+
						'<option value="40">40</option>'+
						'<option value="50">50</option>'+
						'<option value="-1">All</option>'+
						'</select></div> lignes'
		},
		"pageLength" : 100,
		"order": [[0, 'desc']],
  	});
} );
</script>
<?php 
//Ferme le <head>, ouvre le <body> & inclus le menu + ouverture content
include_once("include/finhead.php");
//On défini les mois années par défaut
$mois = date("m");
$annee = date("Y");
//Si l'on applique les filtre (mois/années)
$mois_1=isset($_POST['mois_1'])?$_POST['mois_1']:"";
$annee_1=isset($_POST['annee_1'])?$_POST['annee_1']:"";
//Si pas de filtre, on utilise les mois/années par défaut
if ($mois_1=='') {
 	$mois_1= $mois ;
} 
if ($annee_1=='') { 
 	$annee_1= $annee ; 
}
//On défini l'array calendrier à partir de la focntion appelée via, header > utils > date
$calendrier = calendrier_local_mois ();
//On construit la request
$sql = "SELECT mail, login, num_client, num_bon, tot_htva, tot_tva, nom, 
DATE_FORMAT(date,'%d/%m/%Y') AS date,(tot_htva + tot_tva) as ttc 
FROM " . $tblpref ."bon_comm 
RIGHT JOIN " . $tblpref ."client on " . $tblpref ."bon_comm.client_num = num_client 
WHERE MONTH(date) = $mois_1 AND Year(date)=$annee_1 
";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
//Gestion des messages informatifs
include_once("include/message_info.php");
?>
<!--FILTRES-->
<div class="portion">
    <!-- TITRE - LISTE -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-filter fa-stack-1x"></i>
        </span>
        Filtres
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
    <div class="content_traitement disp_none" id="filtre">
    	<form action="lister_commandes.php" method="post">
			<!-- Mois -->
            <label class="inline">Choix du mois : </label>
            <div class="styled-select-inline" style="width:20%;">
            <select name="mois_1" class="styled-inline">
            <?php for ($i=1;$i<=12;$i++)
            {
            ?>
                <option value="<?php echo $i; ?>"><?php echo ucfirst($calendrier [$i]); ?></option>
            <?php
            }
            ?>
            </select>
            </div>
            <br/><br/>
    		<!-- Année -->
            <label class="inline">Choix de l'ann&eacute;e : </label>
            <div class="styled-select-inline" style="width:20%;">
            <select name="annee_1" class="styled-inline">
                <option value="<?php $date=(date("Y")-2);echo"$date"; ?>"><?php $date=(date("Y")-2);echo"$date"; ?></option>
                <option value="<?php $date=(date("Y")-1);echo"$date"; ?>"><?php $date=(date("Y")-1);echo"$date"; ?></option>
                <option value="<?php $date=date("Y");echo"$date"; ?>"><?php $date=date("Y");echo"$date"; ?></option>
                <option value="<?php $date=(date("Y")+1);echo"$date"; ?>"><?php $date=(date("Y")+1);echo"$date"; ?></option>
                <option value="<?php $date=(date("Y")+2);echo"$date"; ?>"><?php $date=(date("Y")+2);echo"$date"; ?></option>
            </select> 
            </div>
            <!-- GO ! -->
            <div class="center">
                <button class="button_act button--shikoba button--border-thin medium"><i class="button__icon fa fa-filter"></i><span>Filtrer</span></button>
            </div>
        </form>
    </div>
</div>

<!--LISTE EXISTANT-->
<div class="portion">
    <!-- TITRE - LISTE -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-list fa-stack-1x"></i>
        </span>
        Liste des commandes
        <span class="fa-stack fa-lg add" style="float:right" id="show_liste">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_liste">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id=""></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <div class="content_traitement" id="liste">
        <table class="base" width="100%" id="list">
        	<thead>
                <tr> 
                    <th><?php echo $lang_numero; ?></th>
                    <th><?php echo $lang_client; ?></th>
                    <th><?php echo $lang_date; ?></th>
                    <th><?php echo $lang_total_h_tva; ?></th>
                    <th><?php echo $lang_total_ttc; ?></th>
                    <th width="7%">Modifier</th>
                    <th width="7%">Supprimer</th>
                    <th width="7%">Imprimer</th>
                    <th width="7%">Envoyer</th>
                </tr>
            </thead>
            <tbody>
            <?php
            while($data = mysql_fetch_array($req))
            {
                $num_bon = $data['num_bon'];
                $total = $data['tot_htva'];
                $tva = $data["tot_tva"];
                $date = $data["date"];
                $nom = $data['nom'];
                $nom = $nom;
                $nom_html = htmlentities (urlencode ($nom)); 
                $num_client = $data['num_client'];
                $mail = $data['mail'];
                $login = $data['login'];
                $ttc = $data['ttc'];
                ?>
                <tr>
                    <td><?php echo "$num_bon"; ?></td>
                    <td><?php echo "$nom"; ?></td>
                    <td><?php echo "$date"; ?></td>
                    <td><?php echo montant_financier($total); ?></td>
                    <td><?php echo montant_financier($ttc); ?></td>
                    <td>
                        <a href='edit_bon.php?num_bon=<?php echo "$num_bon"; ?>&amp;nom=<?php echo "$nom_html"; ?>' class="no_effect"> 
                        	<i class="fa fa-pencil fa-2x action"></i>
                        </a>
                    </td>
                    <td>
                        <a href='delete_bon_suite.php?num_bon=<?php echo $num_bon; ?>&amp;nom=<?php echo "$nom_html"; ?>' onClick="return confirmDelete('<?php echo"D&eacute;sirez-vous vraiment effacer le bon de commande n° $num_bon"; ?>')" class="no_effect">
                        	<i class="fa fa-trash fa-2x del"></i>
						</a>
                    </td>
                    <td>
                        <a href="fpdf/bon_pdf.php?num_bon=<?php echo $num_bon; ?>&amp;nom=<?php echo $nom_html; ?>&amp;pdf_user=adm" target="_blank" class="no_effect">
                        	<i class="fa fa-print fa-2x action"></i>
						</a>
                    </td>
                    <?php
					//Si le mail existe, on affiche l'icone d'envoi mail au client.
                    if ($mail != '' ) {
                    ?>
                        <td>
                            <form action="fpdf/bon_pdf.php" method="post" onClick="return confirmDelete('<?php echo"$lang_con_env_pdf $num_bon";?>')">
                                <input type="hidden" name="num_bon" value="<?php echo $num_bon; ?>" />
                                <input type="hidden" name="nom" value="<?php echo $nom; ?>" />
                                <input type="hidden" name="user" VALUE="adm">
                                <input type="hidden" name="ext" VALUE=".pdf">
                                <input type="hidden" name="mail" VALUE="y">
                                <button class="icons fa-envelope fa-2x action"></button>
                            </form>	
                        </td>
                    <?php 
                    }
                    else {
					//Sinon on affiche une cellule vide.
                    ?>  
                        <td></td>
                    <?php 
                    }
                    ?>  
                </tr>
            <?php 
            } 
            ?> 
            </tbody>
        </table>
  	</div>

<?php 
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>
