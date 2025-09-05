<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script type="text/javascript" src="include/js/devis.js"></script>
<script>
/* HIDE SHOW ELEMENTS */
$(document).ready(function() {
	<?php 
	if ($_REQUEST['open'] == 'list') {
	?>
		$( "#show_liste" ).hide();
	<?php
	} 
	else { 
	?>
		$( "#hide_liste" ).hide();
	<?php
	}
	?>					   
	$( "#hide_creation" ).hide();
	$( "#hide_param" ).hide();
	$( "#show_liste" ).click(function() {
	  $( "#liste" ).show(500);
	  $( "#hide_liste" ).show();
	  $( "#show_liste" ).hide();
	});
	$( "#hide_liste" ).click(function() {
	  $( "#liste" ).hide(500);
	  $( "#show_liste" ).show();
	  $( "#hide_liste" ).hide();
	});
	$( "#show_creation" ).click(function() {
	  $( "#creation" ).show(500);
	  $( "#hide_creation" ).show();
	  $( "#show_creation" ).hide();
	});
	$( "#hide_creation" ).click(function() {
	  $( "#creation" ).hide(500);
	  $( "#show_creation" ).show();
	  $( "#hide_creation" ).hide();
	});
	$( "#show_param" ).click(function() {
	  $( "#param" ).show(500);
	  $( "#hide_param" ).show();
	  $( "#show_param" ).hide();
	});
	$( "#hide_param" ).click(function() {
	  $( "#param" ).hide(500);
	  $( "#show_param" ).show();
	  $( "#hide_param" ).hide();
	});
	$( "#close_info" ).click(function() {
	  $( "#mess_info" ).hide();
	});
});
/* AjaxForm ajout dans paramètres*/
$(document).ready(function() { 
	$('.autosubmit').ajaxForm(function() { 
		actualiser_parametres(); 
	}); 
});

$(document).ready(function() { 
	$('.edit_name').editable('./include/ajax/edit_devis.php', {
	 tooltip   : 'Cliquez pour modifier...',
	 cssclass : 'jedit'
	}); 
});
/* DATATABLES DEVIS PREDEFINIS */
/* Formatting function for row details - modify as you need */
function format ( d ) {
    // `d` is the original data object for the row
    return '<div id="cont_details'+d.id+'" class="container_details"></div>';
} 
 
$(document).ready(function() {			   
    var table = $('#devis_predef_list').DataTable( {
        "columns": [
            {
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": '&nbsp;',
				"width":		  "10%"	
            },
			{ "data": "id","width": "5%" },
            { "data": "nom", "width": "20%" },
            { "data": "date_creation", "width": "15%" },
            { "data": "total_htva", "width": "10%" },
			{ "data": "total_tva", "width": "10%" },
			{ "data": "total_taxes", "width": "10%" },
			{ "data": "grand_total", "width": "10%" },
            { "data": "actions", "width": "10%" }
        ],
        "order": [[1, 'asc']],
		"language": {
          "lengthMenu": 'Afficher <div class="styled-select-dt"><select class="styled-dt">'+
            '<option value="10">10</option>'+
            '<option value="20">20</option>'+
            '<option value="30">30</option>'+
            '<option value="40">40</option>'+
            '<option value="50">50</option>'+
            '<option value="-1">All</option>'+
            '</select></div> lignes'
        }
    } );
     
    // Add event listener for opening and closing details
    $('#devis_predef_list tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
 
        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
			//On récupère l'id de la ligne.
			var idline = row.data().id;
			det_devis_predef(idline);
			
        }
    } );
} );
</script>
<?php 
//Ferme le <head>, ouvre le <body> & inclus le menu + ouverture content
include_once("include/finhead.php");
?>
<!--MODALE-->
<div id="overlay3">
    <div class="popup_block">
        <a class="close" href="#noWhere">
        	<span class="fa-stack fa-lg fa-2x btn_close del">
              <i class="fa fa-circle fa-stack-2x"></i>
              <i class="fa fa-times fa-stack-1x fa-inverse"></i>
            </span>
      	</a>
        <div id="content_modale">
        	<div class="center"><i class="fa fa-spinner fa-3x fa-pulse"></i></div>
        </div>
    </div>
</div>
<?php
//Gestion des messages informatifs
if (isset($_REQUEST['message'])) {
	?>
	<div class="message_info" id="mess_info">
    <div id="close_info" class="del"><i class="fa fa-times"></i></div>
    <span><i class="fa fa-info-circle fa-fw"></i></span>
	<?php
	if ($_REQUEST['message'] == 'add') {
		$name = $_REQUEST['name'];
		?>
		<span>Le devis <?php echo $name;?> a &eacute;t&eacute; correctement ajout&eacute;.<br/>
        Vous le trouverez dans la liste des devis, ci-dessous.</span>
		<?php
	}
	else if ($_REQUEST['message'] == 'del') {
		$name = $_REQUEST['name'];
		?>
		<span>Le devis <?php echo $name;?> a &eacute;t&eacute; correctement supprim&eacute;.</span>
		<?php
	}
	else if ($_REQUEST['message'] == 'error_transform') {
		$name = $_REQUEST['name'];
		?>
		<span>La transformation du devis &agrave; &eacute;chou&eacute;. Veuillez r&eacute;essayer.<br/>Si le probl&egrave;me persiste, merci de prendre contact avec votre <strong>SUPER</strong> d&eacute;veloppeur.</span>
		<?php
	}
	?>
	</div>
	<?php
}
?>

<!--LISTE EXISTANT-->
<div class="portion">
    <!-- TITRE - LISTE -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-list fa-stack-1x"></i>
        </span>
        Liste des devis pr&eacute;d&eacute;finis existants
        <span class="fa-stack fa-lg add" style="float:right" id="show_liste">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_liste">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - LISTE -->
    <div class="content_traitement <?php if ($_REQUEST['open'] == 'list') {} else { echo 'disp_none';}?>" id="liste">
        <table class="base" width="100%" id="devis_predef_list">
        	<thead>
            	<tr>
                	<th></th>
                	<th>ID</th>
                    <th>Nom</th>
                    <th>Date de cr&eacute;ation</th>
                    <th>Total HTVA</th>
                    <th>Total TVA</th>
                    <th>Total Taxes</th>
                    <th>Grand Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
			<?php
            $sql="SELECT * FROM ".$tblpref."dev_predef";
            $req=mysql_query($sql);
            //On boucle sur les devis prédéfinis existants.
            while ($obj=mysql_fetch_object($req)) {
                //Calcul du total taxe
				$tot_taxes=$obj->tot_recupel+$obj->tot_reprobel+$obj->tot_auvibel+$obj->tot_bebat;
				//Calcul du grand total
				$gd_tot=$obj->tot_htva+$obj->tot_tva+$tot_taxes;
				?>
                <tr id="<?php echo $obj->id;?>">
                	<td></td>
                	<td><?php echo $obj->id;?></td>
                    <td class="edit_name" id="<?php echo $obj->id;?>"><?php echo stripslashes($obj->name);?></td>
                    <td><?php echo dateUSA_to_dateEU($obj->date_creation);?></td>
                    <td><?php echo $obj->tot_htva;?> &euro;</td>
                    <td><?php echo $obj->tot_tva;?> &euro;</td>
                    <td><?php echo $tot_taxes;?> &euro;</td>
                    <td><?php echo $gd_tot;?> &euro;</td>
                    <td>
                    	<!-- UTILISER -->
                        <a href="#overlay3"><button class="icons fa-flask fa-3x fa-fw action" title="Utiliser" onclick="attrib_dev_predef(<?php echo $obj->id;?>)"></button></a>
						<!-- SUPPRIMER -->
                        <form style="display:inline-block;vertical-align:top;" action="./include/form/del_devis_predef.php" onsubmit='return confirm("Voulez-vous vraiment supprimer le devis <?php echo $obj->name;?> ?")'>
                        	<button class="icons fa-trash fa-3x fa-fw del"></button>
                            <input type="hidden" value="<?php echo $obj->id;?>" name="id_dev" id="id_dev<?php echo $obj->id;?>"/>
                        </form>
                    </td>
                </tr>
                <?php
            }
            ?>
        	</tbody>
        </table>
    </div>
</div>
<!--ADD NEW-->
<div class="portion">
    <!-- TITRE - NOUVEAU -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-pencil fa-stack-1x"></i>
        </span>
        Cr&eacute;er un nouveau devis pr&eacute;d&eacute;fini
        <span class="fa-stack fa-lg add" style="float:right" id="show_creation">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x"></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_creation">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - NOUVEAU -->
    <form action="./include/form/add_devis_predef.php" method="post">
    <div class="content_traitement disp_none" id="creation">
        <div class="portion_subtitle"><i class="fa fa-cog fa-fw"></i> Composants</div>
        <div class="half">
            <label class="label_devis"><i class="fa fa-plus fa-fw add" onclick="add_element('case[]', 'container_case', 'result_case')"></i>Boitier</label><i class="fa fa-search fa-fw"></i><input type="text" name="" id="rech_case" class="styled" onkeyup="filter_article('rech_case', 'result_case')"/>
            <div id="container_case">
                <div class="styled-select">
                    <select name="case[]" id="result_case" class="styled">
                        <option value="">Veuillez d'abord effectuer une recherche...</option>
                    </select>
                </div>
            </div>
            
            <label class="label_devis"><i class="fa fa-plus fa-fw add" onclick="add_element('alim[]', 'container_alim', 'result_alim')"></i>Alimentation</label><i class="fa fa-search fa-fw"></i><input type="text" name="" id="rech_alim" class="styled" onkeyup="filter_article('rech_alim', 'result_alim')"/>
            <div id="container_alim">
                <div class="styled-select">
                    <select name="alim[]" id="result_alim" class="styled">
                        <option value="">Veuillez d'abord effectuer une recherche...</option>
                    </select>
                </div>
            </div>
            
            <label class="label_devis"><i class="fa fa-plus fa-fw add" onclick="add_element('mb[]', 'container_mb', 'result_cm')"></i>Carte m&egrave;re</label><i class="fa fa-search fa-fw"></i><input type="text" name="" id="rech_cm" class="styled" onkeyup="filter_article('rech_cm', 'result_cm')"/><br/>
            <div id="container_mb">
                <div class="styled-select">
                    <select name="mb[]" id="result_cm" class="styled">
                        <option value="">Veuillez d'abord effectuer une recherche...</option>
                    </select>
                </div>
            </div>
            
            <label class="label_devis"><i class="fa fa-plus fa-fw add" onclick="add_element('proc[]', 'container_proc', 'result_proc')"></i>Processeur</label><i class="fa fa-search fa-fw"></i><input type="text" name="" id="rech_proc" class="styled" onkeyup="filter_article('rech_proc', 'result_proc')"/>
            <div id="container_proc">
                <div class="styled-select">
                    <select name="proc[]" id="result_proc" class="styled">
                        <option value="">Veuillez d'abord effectuer une recherche...</option>
                    </select>
                </div>
            </div>
            
            
            <label class="label_devis"><i class="fa fa-plus fa-fw add" onclick="add_element('ram[]', 'container_ram', 'result_ram')"></i>M&eacute;moire RAM</label><i class="fa fa-search fa-fw"></i><input type="text" name="" id="rech_ram" class="styled" onkeyup="filter_article('rech_ram', 'result_ram')"/>
           	<div id="container_ram">
                <div class="styled-select">
                    <select name="ram[]" id="result_ram" class="styled">
                        <option value="">Veuillez d'abord effectuer une recherche...</option>
                    </select>
                </div>
          	</div>
            
            <label class="label_devis"><i class="fa fa-plus fa-fw add" onclick="add_element('hdd[]', 'container_hdd', 'result_hdd')"></i>HDD/SSD</label><i class="fa fa-search fa-fw"></i><input type="text" name="" id="rech_hdd" class="styled" onkeyup="filter_article('rech_hdd', 'result_hdd')"/>
            <div id="container_hdd">
                <div class="styled-select">
                    <select name="hdd[]" id="result_hdd" class="styled">
                        <option value="">Veuillez d'abord effectuer une recherche...</option>
                    </select>
                </div>
            </div>
            
            <label class="label_devis"><i class="fa fa-plus fa-fw add" onclick="add_element('cd[]', 'container_cd', 'result_cd')"></i>Lecteur/Graveur</label><i class="fa fa-search fa-fw"></i><input type="text" name="" id="rech_cd" class="styled" onkeyup="filter_article('rech_cd', 'result_cd')"/>
            <div id="container_cd">
                <div class="styled-select">
                    <select name="cd[]" id="result_cd" class="styled">
                        <option value="">Veuillez d'abord effectuer une recherche...</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="half">
            <label class="label_devis"><i class="fa fa-plus fa-fw add" onclick="add_element('gpu[]', 'container_gpu', 'result_gpu')"></i>Carte graphique</label><i class="fa fa-search fa-fw"></i><input type="text" name="" id="rech_gpu" class="styled" onkeyup="filter_article('rech_gpu', 'result_gpu')"/>
            <div id="container_gpu">
                <div class="styled-select">
                    <select name="gpu[]" id="result_gpu" class="styled">
                        <option value="">Veuillez d'abord effectuer une recherche...</option>
                    </select>
                </div>
            </div>
            
            <label class="label_devis"><i class="fa fa-plus fa-fw add" onclick="add_element('fan[]', 'container_fan', 'result_fan')"></i>Refroidissement CPU</label><i class="fa fa-search fa-fw"></i><input type="text" name="" id="rech_fan" class="styled" onkeyup="filter_article('rech_fan', 'result_fan')"/>
            <div id="container_fan">
                <div class="styled-select">
                    <select name="fan[]" id="result_fan" class="styled">
                        <option value="">Veuillez d'abord effectuer une recherche...</option>
                    </select>
                </div>
            </div>
            
            <label class="label_devis"><i class="fa fa-plus fa-fw add" onclick="add_element('cfan[]', 'container_cfan', 'result_cfan')"></i>P&acirc;te thermique</label><i class="fa fa-search fa-fw"></i><input type="text" name="" id="rech_cfan" class="styled" onkeyup="filter_article('rech_cfan', 'result_cfan')"/>
            <div id="container_cfan">
                <div class="styled-select">
                    <select name="cfan[]" id="result_cfan" class="styled">
                        <option value="">Veuillez d'abord effectuer une recherche...</option>
                    </select>
                </div>
            </div>
            
            <label class="label_devis"><i class="fa fa-plus fa-fw add" onclick="add_element('card[]', 'container_card', 'result_card')"></i>Lecteur de cartes</label><i class="fa fa-search fa-fw"></i><input type="text" name="" id="rech_card" class="styled" onkeyup="filter_article('rech_card', 'result_card')"/>
            <div id="container_card">
                <div class="styled-select">
                    <select name="card[]" id="result_card" class="styled">
                        <option value="">Veuillez d'abord effectuer une recherche...</option>
                    </select>
                </div>
            </div>
            
            <label class="label_devis"><i class="fa fa-plus fa-fw add" onclick="add_element('wifi[]', 'container_wifi', 'result_wifi')"></i>Carte Wifi</label><i class="fa fa-search fa-fw"></i><input type="text" name="" id="rech_wifi" class="styled" onkeyup="filter_article('rech_wifi', 'result_wifi')"/>
            <div id="container_wifi">
                <div class="styled-select">
                    <select name="wifi[]" id="result_wifi" class="styled">
                        <option value="">Veuillez d'abord effectuer une recherche...</option>
                    </select>
                </div>
            </div>
            
            <label class="label_devis"><i class="fa fa-plus fa-fw add" onclick="add_element('son[]', 'container_son', 'result_son')"></i>Carte Son</label><i class="fa fa-search fa-fw"></i><input type="text" name="" id="rech_son" class="styled" onkeyup="filter_article('rech_son', 'result_son')"/>
            <div id="container_son">
                <div class="styled-select">
                    <select name="son[]" id="result_son" class="styled">
                        <option value="">Veuillez d'abord effectuer une recherche...</option>
                    </select>
                </div>
            </div>
            
        </div>
        <div class="portion_subtitle"><i class="fa fa-windows fa-fw"></i> Syst&egrave;me d'exploitation & Logiciels</div>
        <div class="half">
        	<label class="label_devis"><i class="fa fa-plus fa-fw add" onclick="add_element('os[]', 'container_os', 'result_os')"></i>OS</label><i class="fa fa-search fa-fw"></i><input type="text" name="" id="rech_os" class="styled" onkeyup="filter_article('rech_os', 'result_os')"/>
            <div id="container_os">
                <div class="styled-select">
                    <select name="os[]" id="result_os" class="styled">
                        <option value="">Veuillez d'abord effectuer une recherche...</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="half">
        	<label class="label_devis"><i class="fa fa-plus fa-fw add" onclick="add_element('soft[]', 'container_soft', 'result_soft')"></i>Logiciel</label><i class="fa fa-search fa-fw"></i><input type="text" name="" id="rech_soft" class="styled" onkeyup="filter_article('rech_soft', 'result_soft')"/>
            <div id="container_soft">
                <div class="styled-select">
                    <select name="soft[]" id="result_soft" class="styled">
                        <option value="">Veuillez d'abord effectuer une recherche...</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="portion_subtitle"><i class="fa fa-desktop fa-fw"></i> P&eacute;riph&eacute;riques</div>
        <div class="half">
        	<label class="label_devis"><i class="fa fa-plus fa-fw add" onclick="add_element('screen[]', 'container_screen', 'result_screen')"></i>Ecran</label><i class="fa fa-search fa-fw"></i><input type="text" name="" id="rech_screen" class="styled" onkeyup="filter_article('rech_screen', 'result_screen')"/>
            <div id="container_screen">
                <div class="styled-select">
                    <select name="screen[]" id="result_screen" class="styled">
                        <option value="">Veuillez d'abord effectuer une recherche...</option>
                    </select>
                </div>
            </div>
            
            <label class="label_devis"><i class="fa fa-plus fa-fw add" onclick="add_element('keyb[]', 'container_keyb', 'result_keyb')"></i>Clavier</label><i class="fa fa-search fa-fw"></i><input type="text" name="" id="rech_keyb" class="styled" onkeyup="filter_article('rech_keyb', 'result_keyb')"/>
            <div id="container_keyb">
                <div class="styled-select">
                    <select name="keyb[]" id="result_keyb" class="styled">
                        <option value="">Veuillez d'abord effectuer une recherche...</option>
                    </select>
                </div>
            </div>
            
            <label class="label_devis"><i class="fa fa-plus fa-fw add" onclick="add_element('mouse[]', 'container_mouse', 'result_mouse')"></i>Souris</label><i class="fa fa-search fa-fw"></i><input type="text" name="" id="rech_mouse" class="styled" onkeyup="filter_article('rech_mouse', 'result_mouse')"/>
            <div id="container_mouse">
                <div class="styled-select">
                    <select name="mouse[]" id="result_mouse" class="styled">
                        <option value="">Veuillez d'abord effectuer une recherche...</option>
                    </select>
                </div>
            </div>
            
            <label class="label_devis"><i class="fa fa-plus fa-fw add" onclick="add_element('hifi[]', 'container_hifi', 'result_hifi')"></i>Enceintes</label><i class="fa fa-search fa-fw"></i><input type="text" name="" id="rech_hifi" class="styled" onkeyup="filter_article('rech_hifi', 'result_hifi')"/>
            <div id="container_hifi">
                <div class="styled-select">
                    <select name="hifi[]" id="result_hifi" class="styled">
                        <option value="">Veuillez d'abord effectuer une recherche...</option>
                    </select>
                </div>
            </div>
            
            <label class="label_devis"><i class="fa fa-plus fa-fw add" onclick="add_element('heads[]', 'container_heads', 'result_heads')"></i>Casque/Micro</label><i class="fa fa-search fa-fw"></i><input type="text" name="" id="rech_heads" class="styled" onkeyup="filter_article('rech_heads', 'result_heads')"/>
            <div id="container_heads">
                <div class="styled-select">
                    <select name="heads[]" id="result_heads" class="styled">
                        <option value="">Veuillez d'abord effectuer une recherche...</option>
                    </select>
                </div>
            </div>
        </div>
        
        <div class="half">
        	<label class="label_devis"><i class="fa fa-plus fa-fw add" onclick="add_element('wifik[]', 'container_wifik', 'result_wifik')"></i>Cl&eacute; WiFi</label><i class="fa fa-search fa-fw"></i><input type="text" name="" id="rech_wifik" class="styled" onkeyup="filter_article('rech_wifik', 'result_wifik')"/>
            <div id="container_wifik">
                <div class="styled-select">
                    <select name="wifik[]" id="result_wifik" class="styled">
                        <option value="">Veuillez d'abord effectuer une recherche...</option>
                    </select>
                </div>
            </div>
            
            <label class="label_devis"><i class="fa fa-plus fa-fw add" onclick="add_element('print[]', 'container_print', 'result_print')"></i>Imprimante</label><i class="fa fa-search fa-fw"></i><input type="text" name="" id="rech_print" class="styled" onkeyup="filter_article('rech_print', 'result_print')"/>
            <div id="container_print">
                <div class="styled-select">
                    <select name="print[]" id="result_print" class="styled">
                        <option value="">Veuillez d'abord effectuer une recherche...</option>
                    </select>
                </div>
            </div>
            
            <label class="label_devis"><i class="fa fa-plus fa-fw add" onclick="add_element('webc[]', 'container_webc', 'result_webc')"></i>Webcam</label><i class="fa fa-search fa-fw"></i><input type="text" name="" id="rech_webc" class="styled" onkeyup="filter_article('rech_webc', 'result_webc')"/>
            <div id="container_webc">
                <div class="styled-select">
                    <select name="webc[]" id="result_webc" class="styled">
                        <option value="">Veuillez d'abord effectuer une recherche...</option>
                    </select>
                </div>
            </div>
            
            <label class="label_devis"><i class="fa fa-plus fa-fw add" onclick="add_element('o[]', 'container_o', 'result_o')"></i>Autre</label><i class="fa fa-search fa-fw"></i><input type="text" name="" id="rech_o" class="styled" onkeyup="filter_article('rech_o', 'result_o')"/>
            <div id="container_o">
                <div class="styled-select">
                    <select name="o[]" id="result_o" class="styled">
                        <option value="">Veuillez d'abord effectuer une recherche...</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="portion_subtitle"><i class="fa fa-code-fork fa-fw"></i> Connectique</div>
        <div class="half">
        	<label class="label_devis"><i class="fa fa-plus fa-fw add" onclick="add_element('wire[]', 'container_wire', 'result_wire')"></i>C&acirc;blage</label><i class="fa fa-search fa-fw"></i><input type="text" name="" id="rech_wire" class="styled" onkeyup="filter_article('rech_wire', 'result_wire')"/>
            <div id="container_wire">
                <div class="styled-select">
                    <select name="wire[]" id="result_wire" class="styled">
                        <option value="">Veuillez d'abord effectuer une recherche...</option>
                    </select>
                </div>
            </div>
        </div>
        
        <div class="portion_subtitle"><i class="fa fa-floppy-o fa-fw"></i> Finalisation du devis</div>
        <div class="half">
        	<label class="label_devis">Nom du devis </label><i class="fa fa-arrow-right fa-fw"></i><input type="text" name="devis_name" id="devis_name" class="styled" />
        </div>
        <div class="center">
        	<button class="button_act button--shikoba button--border-thin medium"><i class="button__icon fa fa-floppy-o"></i><span>Enregistrer</span></button>
      	</div>
    </div>
    </form>
</div>
<!-- PARAMETRES -->
<div class="portion">
    <!-- TITRE - PARAMETRES -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-cog fa-stack-1x"></i>
        </span>
        Param&egrave;tres
        <span class="fa-stack fa-lg add" style="float:right" id="show_param">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_param">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - PARAMETRES -->
    <div class="content_traitement disp_none" id="param">
        <div class="portion_subtitle">
        	<i class="fa fa-arrows-h fa-fw"></i> Correspondance entre les cat&eacute;gories d'articles et les cat&eacute;gories de composants pour les devis pr&eacute;d&eacute;finis
       	</div>
        <div class="part_param_devis">
            <div class="devis_cat">Processeur</div>
            <div class="devis_content_cat">
            	<div class="linked_cat_content">
                	<?php
					//On va récupérer les catégories actuellements liées
					$sql="SELECT c.categorie, cc.id";
					$sql.=" FROM ".$tblpref."cat_x_cat_devis as cc";
					$sql.=" LEFT JOIN ".$tblpref."categorie as c ON c.id_cat = cc.id_cat";
					$sql.=" WHERE cc.cat_devis='processeur'";
					$req=mysql_query($sql);
					while($obj = mysql_fetch_object($req)) {
						?>
                        <div class="linked_cat">
							<form class="autosubmit" action="./include/form/del_cat_dev_predef.php" method="post">
                            	<input type="hidden" name="id" value="<?php echo $obj->id;?>"/>
								<span><?php echo $obj->categorie;?></span><button class="icons fa-times del" style="float:right;"></button>
                            </form>
                        </div>
                        <?php
					}
					?>
                </div>
            	<form class="autosubmit" action="./include/form/add_cat_dev_predef.php" method="post">
                    <div class="content_select_param_devis">
                        <select name="cat" id="cat_proc" class="select_param_devis">
                            <?php
                            $sql="SELECT * FROM ".$tblpref."categorie ORDER BY categorie ASC";
                            $req=mysql_query($sql);
                            while ($obj = mysql_fetch_object($req)) {
                                ?>
                                <option value="<?php echo $obj->id_cat;?>"><?php echo $obj->categorie.' | Lvl : '.$obj->cat_level;?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <input type="hidden" name="type" value="processeur"/>
                    <button class="icons fa-plus-square-o fa-3x add"></button>
                </form>
            </div>
        </div>
        
        <div class="part_param_devis">
            <div class="devis_cat">Carte m&egrave;re</div>
            <div class="devis_content_cat">
            	<div class="linked_cat_content">
                	<?php
					//On va récupérer les catégories actuellements liées
					$sql="SELECT c.categorie, cc.id";
					$sql.=" FROM ".$tblpref."cat_x_cat_devis as cc";
					$sql.=" LEFT JOIN ".$tblpref."categorie as c ON c.id_cat = cc.id_cat";
					$sql.=" WHERE cc.cat_devis='motherboard'";
					$req=mysql_query($sql);
					while($obj = mysql_fetch_object($req)) {
						?>
                        <div class="linked_cat">
							<form class="autosubmit" action="./include/form/del_cat_dev_predef.php" method="post">
                            	<input type="hidden" name="id" value="<?php echo $obj->id;?>"/>
								<span><?php echo $obj->categorie;?></span><button class="icons fa-times del" style="float:right;"></button>
                            </form>
                        </div>
                        <?php
					}
					?>
                </div>
            	<form class="autosubmit" action="./include/form/add_cat_dev_predef.php" method="post">
                    <div class="content_select_param_devis">
                        <select name="cat" id="cat_proc" class="select_param_devis">
                            <?php
                            $sql="SELECT * FROM ".$tblpref."categorie ORDER BY categorie ASC";
                            $req=mysql_query($sql);
                            while ($obj = mysql_fetch_object($req)) {
                                ?>
                                <option value="<?php echo $obj->id_cat;?>"><?php echo $obj->categorie.' | Lvl : '.$obj->cat_level;?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <input type="hidden" name="type" value="motherboard"/>
                    <button class="icons fa-plus-square-o fa-3x add"></button>
                </form>
            </div>
        </div>
        
        <div class="part_param_devis">
            <div class="devis_cat">M&eacute;moire RAM</div>
            <div class="devis_content_cat">
            	<div class="linked_cat_content">
                	<?php
					//On va récupérer les catégories actuellements liées
					$sql="SELECT c.categorie, cc.id";
					$sql.=" FROM ".$tblpref."cat_x_cat_devis as cc";
					$sql.=" LEFT JOIN ".$tblpref."categorie as c ON c.id_cat = cc.id_cat";
					$sql.=" WHERE cc.cat_devis='ram'";
					$req=mysql_query($sql);
					while($obj = mysql_fetch_object($req)) {
						?>
                        <div class="linked_cat">
							<form class="autosubmit" action="./include/form/del_cat_dev_predef.php" method="post">
                            	<input type="hidden" name="id" value="<?php echo $obj->id;?>"/>
								<span><?php echo $obj->categorie;?></span><button class="icons fa-times del" style="float:right;"></button>
                            </form>
                        </div>
                        <?php
					}
					?>
                </div>
            	<form class="autosubmit" action="./include/form/add_cat_dev_predef.php" method="post">
                    <div class="content_select_param_devis">
                        <select name="cat" id="cat_proc" class="select_param_devis">
                            <?php
                            $sql="SELECT * FROM ".$tblpref."categorie ORDER BY categorie ASC";
                            $req=mysql_query($sql);
                            while ($obj = mysql_fetch_object($req)) {
                                ?>
                                <option value="<?php echo $obj->id_cat;?>"><?php echo $obj->categorie.' | Lvl : '.$obj->cat_level;?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <input type="hidden" name="type" value="ram"/>
                    <button class="icons fa-plus-square-o fa-3x add"></button>
                </form>
            </div>
        </div>
        
        <div class="part_param_devis">
            <div class="devis_cat">Refroidissement CPU</div>
            <div class="devis_content_cat">
            	<div class="linked_cat_content">
                	<?php
					//On va récupérer les catégories actuellements liées
					$sql="SELECT c.categorie, cc.id";
					$sql.=" FROM ".$tblpref."cat_x_cat_devis as cc";
					$sql.=" LEFT JOIN ".$tblpref."categorie as c ON c.id_cat = cc.id_cat";
					$sql.=" WHERE cc.cat_devis='fan'";
					$req=mysql_query($sql);
					while($obj = mysql_fetch_object($req)) {
						?>
                        <div class="linked_cat">
							<form class="autosubmit" action="./include/form/del_cat_dev_predef.php" method="post">
                            	<input type="hidden" name="id" value="<?php echo $obj->id;?>"/>
								<span><?php echo $obj->categorie;?></span><button class="icons fa-times del" style="float:right;"></button>
                            </form>
                        </div>
                        <?php
					}
					?>
                </div>
            	<form class="autosubmit" action="./include/form/add_cat_dev_predef.php" method="post">
                    <div class="content_select_param_devis">
                        <select name="cat" id="cat_proc" class="select_param_devis">
                            <?php
                            $sql="SELECT * FROM ".$tblpref."categorie ORDER BY categorie ASC";
                            $req=mysql_query($sql);
                            while ($obj = mysql_fetch_object($req)) {
                                ?>
                                <option value="<?php echo $obj->id_cat;?>"><?php echo $obj->categorie.' | Lvl : '.$obj->cat_level;?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <input type="hidden" name="type" value="fan"/>
                    <button class="icons fa-plus-square-o fa-3x add"></button>
                </form>
            </div>
        </div>
        
        <div class="part_param_devis">
            <div class="devis_cat">P&acirc;te thermique</div>
            <div class="devis_content_cat">
            	<div class="linked_cat_content">
                	<?php
					//On va récupérer les catégories actuellements liées
					$sql="SELECT c.categorie, cc.id";
					$sql.=" FROM ".$tblpref."cat_x_cat_devis as cc";
					$sql.=" LEFT JOIN ".$tblpref."categorie as c ON c.id_cat = cc.id_cat";
					$sql.=" WHERE cc.cat_devis='pate'";
					$req=mysql_query($sql);
					while($obj = mysql_fetch_object($req)) {
						?>
                        <div class="linked_cat">
							<form class="autosubmit" action="./include/form/del_cat_dev_predef.php" method="post">
                            	<input type="hidden" name="id" value="<?php echo $obj->id;?>"/>
								<span><?php echo $obj->categorie;?></span><button class="icons fa-times del" style="float:right;"></button>
                            </form>
                        </div>
                        <?php
					}
					?>
                </div>
            	<form class="autosubmit" action="./include/form/add_cat_dev_predef.php" method="post">
                    <div class="content_select_param_devis">
                        <select name="cat" id="cat_proc" class="select_param_devis">
                            <?php
                            $sql="SELECT * FROM ".$tblpref."categorie ORDER BY categorie ASC";
                            $req=mysql_query($sql);
                            while ($obj = mysql_fetch_object($req)) {
                                ?>
                                <option value="<?php echo $obj->id_cat;?>"><?php echo $obj->categorie.' | Lvl : '.$obj->cat_level;?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <input type="hidden" name="type" value="pate"/>
                    <button class="icons fa-plus-square-o fa-3x add"></button>
                </form>
            </div>
        </div>
        
        <div class="part_param_devis">
            <div class="devis_cat">Carte graphique</div>
            <div class="devis_content_cat">
            	<div class="linked_cat_content">
                	<?php
					//On va récupérer les catégories actuellements liées
					$sql="SELECT c.categorie, cc.id";
					$sql.=" FROM ".$tblpref."cat_x_cat_devis as cc";
					$sql.=" LEFT JOIN ".$tblpref."categorie as c ON c.id_cat = cc.id_cat";
					$sql.=" WHERE cc.cat_devis='gpu'";
					$req=mysql_query($sql);
					while($obj = mysql_fetch_object($req)) {
						?>
                        <div class="linked_cat">
							<form class="autosubmit" action="./include/form/del_cat_dev_predef.php" method="post">
                            	<input type="hidden" name="id" value="<?php echo $obj->id;?>"/>
								<span><?php echo $obj->categorie;?></span><button class="icons fa-times del" style="float:right;"></button>
                            </form>
                        </div>
                        <?php
					}
					?>
                </div>
            	<form class="autosubmit" action="./include/form/add_cat_dev_predef.php" method="post">
                    <div class="content_select_param_devis">
                        <select name="cat" id="cat_proc" class="select_param_devis">
                            <?php
                            $sql="SELECT * FROM ".$tblpref."categorie ORDER BY categorie ASC";
                            $req=mysql_query($sql);
                            while ($obj = mysql_fetch_object($req)) {
                                ?>
                                <option value="<?php echo $obj->id_cat;?>"><?php echo $obj->categorie.' | Lvl : '.$obj->cat_level;?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <input type="hidden" name="type" value="gpu"/>
                    <button class="icons fa-plus-square-o fa-3x add"></button>
                </form>
            </div>
        </div>
        
        <div class="part_param_devis">
            <div class="devis_cat">HDD/SSD</div>
            <div class="devis_content_cat">
            	<div class="linked_cat_content">
                	<?php
					//On va récupérer les catégories actuellements liées
					$sql="SELECT c.categorie, cc.id";
					$sql.=" FROM ".$tblpref."cat_x_cat_devis as cc";
					$sql.=" LEFT JOIN ".$tblpref."categorie as c ON c.id_cat = cc.id_cat";
					$sql.=" WHERE cc.cat_devis='hdd'";
					$req=mysql_query($sql);
					while($obj = mysql_fetch_object($req)) {
						?>
                        <div class="linked_cat">
							<form class="autosubmit" action="./include/form/del_cat_dev_predef.php" method="post">
                            	<input type="hidden" name="id" value="<?php echo $obj->id;?>"/>
								<span><?php echo $obj->categorie;?></span><button class="icons fa-times del" style="float:right;"></button>
                            </form>
                        </div>
                        <?php
					}
					?>
                </div>
            	<form class="autosubmit" action="./include/form/add_cat_dev_predef.php" method="post">
                    <div class="content_select_param_devis">
                        <select name="cat" id="cat_proc" class="select_param_devis">
                            <?php
                            $sql="SELECT * FROM ".$tblpref."categorie ORDER BY categorie ASC";
                            $req=mysql_query($sql);
                            while ($obj = mysql_fetch_object($req)) {
                                ?>
                                <option value="<?php echo $obj->id_cat;?>"><?php echo $obj->categorie.' | Lvl : '.$obj->cat_level;?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <input type="hidden" name="type" value="hdd"/>
                    <button class="icons fa-plus-square-o fa-3x add"></button>
                </form>
            </div>
        </div>
        
        <div class="part_param_devis">
            <div class="devis_cat">Lecteur/Graveur</div>
            <div class="devis_content_cat">
            	<div class="linked_cat_content">
                	<?php
					//On va récupérer les catégories actuellements liées
					$sql="SELECT c.categorie, cc.id";
					$sql.=" FROM ".$tblpref."cat_x_cat_devis as cc";
					$sql.=" LEFT JOIN ".$tblpref."categorie as c ON c.id_cat = cc.id_cat";
					$sql.=" WHERE cc.cat_devis='cd'";
					$req=mysql_query($sql);
					while($obj = mysql_fetch_object($req)) {
						?>
                        <div class="linked_cat">
							<form class="autosubmit" action="./include/form/del_cat_dev_predef.php" method="post">
                            	<input type="hidden" name="id" value="<?php echo $obj->id;?>"/>
								<span><?php echo $obj->categorie;?></span><button class="icons fa-times del" style="float:right;"></button>
                            </form>
                        </div>
                        <?php
					}
					?>
                </div>
            	<form class="autosubmit" action="./include/form/add_cat_dev_predef.php" method="post">
                    <div class="content_select_param_devis">
                        <select name="cat" id="cat_proc" class="select_param_devis">
                            <?php
                            $sql="SELECT * FROM ".$tblpref."categorie ORDER BY categorie ASC";
                            $req=mysql_query($sql);
                            while ($obj = mysql_fetch_object($req)) {
                                ?>
                                <option value="<?php echo $obj->id_cat;?>"><?php echo $obj->categorie.' | Lvl : '.$obj->cat_level;?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <input type="hidden" name="type" value="cd"/>
                    <button class="icons fa-plus-square-o fa-3x add"></button>
                </form>
            </div>
        </div>
        
        <div class="part_param_devis">
            <div class="devis_cat">Lecteur de carte</div>
            <div class="devis_content_cat">
            	<div class="linked_cat_content">
                	<?php
					//On va récupérer les catégories actuellements liées
					$sql="SELECT c.categorie, cc.id";
					$sql.=" FROM ".$tblpref."cat_x_cat_devis as cc";
					$sql.=" LEFT JOIN ".$tblpref."categorie as c ON c.id_cat = cc.id_cat";
					$sql.=" WHERE cc.cat_devis='carte'";
					$req=mysql_query($sql);
					while($obj = mysql_fetch_object($req)) {
						?>
                        <div class="linked_cat">
							<form class="autosubmit" action="./include/form/del_cat_dev_predef.php" method="post">
                            	<input type="hidden" name="id" value="<?php echo $obj->id;?>"/>
								<span><?php echo $obj->categorie;?></span><button class="icons fa-times del" style="float:right;"></button>
                            </form>
                        </div>
                        <?php
					}
					?>
                </div>
            	<form class="autosubmit" action="./include/form/add_cat_dev_predef.php" method="post">
                    <div class="content_select_param_devis">
                        <select name="cat" id="cat_proc" class="select_param_devis">
                            <?php
                            $sql="SELECT * FROM ".$tblpref."categorie ORDER BY categorie ASC";
                            $req=mysql_query($sql);
                            while ($obj = mysql_fetch_object($req)) {
                                ?>
                                <option value="<?php echo $obj->id_cat;?>"><?php echo $obj->categorie.' | Lvl : '.$obj->cat_level;?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <input type="hidden" name="type" value="carte"/>
                    <button class="icons fa-plus-square-o fa-3x add"></button>
                </form>
            </div>
        </div>
        
        <div class="part_param_devis">
            <div class="devis_cat">Carte WiFi</div>
            <div class="devis_content_cat">
            	<div class="linked_cat_content">
                	<?php
					//On va récupérer les catégories actuellements liées
					$sql="SELECT c.categorie, cc.id";
					$sql.=" FROM ".$tblpref."cat_x_cat_devis as cc";
					$sql.=" LEFT JOIN ".$tblpref."categorie as c ON c.id_cat = cc.id_cat";
					$sql.=" WHERE cc.cat_devis='wifi'";
					$req=mysql_query($sql);
					while($obj = mysql_fetch_object($req)) {
						?>
                        <div class="linked_cat">
							<form class="autosubmit" action="./include/form/del_cat_dev_predef.php" method="post">
                            	<input type="hidden" name="id" value="<?php echo $obj->id;?>"/>
								<span><?php echo $obj->categorie;?></span><button class="icons fa-times del" style="float:right;"></button>
                            </form>
                        </div>
                        <?php
					}
					?>
                </div>
            	<form class="autosubmit" action="./include/form/add_cat_dev_predef.php" method="post">
                    <div class="content_select_param_devis">
                        <select name="cat" id="cat_proc" class="select_param_devis">
                            <?php
                            $sql="SELECT * FROM ".$tblpref."categorie ORDER BY categorie ASC";
                            $req=mysql_query($sql);
                            while ($obj = mysql_fetch_object($req)) {
                                ?>
                                <option value="<?php echo $obj->id_cat;?>"><?php echo $obj->categorie.' | Lvl : '.$obj->cat_level;?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <input type="hidden" name="type" value="wifi"/>
                    <button class="icons fa-plus-square-o fa-3x add"></button>
                </form>
            </div>
        </div>
        
        <div class="part_param_devis">
            <div class="devis_cat">Carte son</div>
            <div class="devis_content_cat">
            	<div class="linked_cat_content">
                	<?php
					//On va récupérer les catégories actuellements liées
					$sql="SELECT c.categorie, cc.id";
					$sql.=" FROM ".$tblpref."cat_x_cat_devis as cc";
					$sql.=" LEFT JOIN ".$tblpref."categorie as c ON c.id_cat = cc.id_cat";
					$sql.=" WHERE cc.cat_devis='son'";
					$req=mysql_query($sql);
					while($obj = mysql_fetch_object($req)) {
						?>
                        <div class="linked_cat">
							<form class="autosubmit" action="./include/form/del_cat_dev_predef.php" method="post">
                            	<input type="hidden" name="id" value="<?php echo $obj->id;?>"/>
								<span><?php echo $obj->categorie;?></span><button class="icons fa-times del" style="float:right;"></button>
                            </form>
                        </div>
                        <?php
					}
					?>
                </div>
            	<form class="autosubmit" action="./include/form/add_cat_dev_predef.php" method="post">
                    <div class="content_select_param_devis">
                        <select name="cat" id="cat_proc" class="select_param_devis">
                            <?php
                            $sql="SELECT * FROM ".$tblpref."categorie ORDER BY categorie ASC";
                            $req=mysql_query($sql);
                            while ($obj = mysql_fetch_object($req)) {
                                ?>
                                <option value="<?php echo $obj->id_cat;?>"><?php echo $obj->categorie.' | Lvl : '.$obj->cat_level;?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <input type="hidden" name="type" value="son"/>
                    <button class="icons fa-plus-square-o fa-3x add"></button>
                </form>
            </div>
        </div>
        
        <div class="part_param_devis">
            <div class="devis_cat">Boitier</div>
            <div class="devis_content_cat">
            	<div class="linked_cat_content">
                	<?php
					//On va récupérer les catégories actuellements liées
					$sql="SELECT c.categorie, cc.id";
					$sql.=" FROM ".$tblpref."cat_x_cat_devis as cc";
					$sql.=" LEFT JOIN ".$tblpref."categorie as c ON c.id_cat = cc.id_cat";
					$sql.=" WHERE cc.cat_devis='case'";
					$req=mysql_query($sql);
					while($obj = mysql_fetch_object($req)) {
						?>
                        <div class="linked_cat">
							<form class="autosubmit" action="./include/form/del_cat_dev_predef.php" method="post">
                            	<input type="hidden" name="id" value="<?php echo $obj->id;?>"/>
								<span><?php echo $obj->categorie;?></span><button class="icons fa-times del" style="float:right;"></button>
                            </form>
                        </div>
                        <?php
					}
					?>
                </div>
            	<form class="autosubmit" action="./include/form/add_cat_dev_predef.php" method="post">
                    <div class="content_select_param_devis">
                        <select name="cat" id="cat_proc" class="select_param_devis">
                            <?php
                            $sql="SELECT * FROM ".$tblpref."categorie ORDER BY categorie ASC";
                            $req=mysql_query($sql);
                            while ($obj = mysql_fetch_object($req)) {
                                ?>
                                <option value="<?php echo $obj->id_cat;?>"><?php echo $obj->categorie.' | Lvl : '.$obj->cat_level;?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <input type="hidden" name="type" value="case"/>
                    <button class="icons fa-plus-square-o fa-3x add"></button>
                </form>
            </div>
        </div>
        
        <div class="part_param_devis">
            <div class="devis_cat">Alimentation</div>
            <div class="devis_content_cat">
            	<div class="linked_cat_content">
                	<?php
					//On va récupérer les catégories actuellements liées
					$sql="SELECT c.categorie, cc.id";
					$sql.=" FROM ".$tblpref."cat_x_cat_devis as cc";
					$sql.=" LEFT JOIN ".$tblpref."categorie as c ON c.id_cat = cc.id_cat";
					$sql.=" WHERE cc.cat_devis='alimentation'";
					$req=mysql_query($sql);
					while($obj = mysql_fetch_object($req)) {
						?>
                        <div class="linked_cat">
							<form class="autosubmit" action="./include/form/del_cat_dev_predef.php" method="post">
                            	<input type="hidden" name="id" value="<?php echo $obj->id;?>"/>
								<span><?php echo $obj->categorie;?></span><button class="icons fa-times del" style="float:right;"></button>
                            </form>
                        </div>
                        <?php
					}
					?>
                </div>
            	<form class="autosubmit" action="./include/form/add_cat_dev_predef.php" method="post">
                    <div class="content_select_param_devis">
                        <select name="cat" id="cat_proc" class="select_param_devis">
                            <?php
                            $sql="SELECT * FROM ".$tblpref."categorie ORDER BY categorie ASC";
                            $req=mysql_query($sql);
                            while ($obj = mysql_fetch_object($req)) {
                                ?>
                                <option value="<?php echo $obj->id_cat;?>"><?php echo $obj->categorie.' | Lvl : '.$obj->cat_level;?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <input type="hidden" name="type" value="alimentation"/>
                    <button class="icons fa-plus-square-o fa-3x add"></button>
                </form>
            </div>
        </div>
        
        <div class="part_param_devis">
            <div class="devis_cat">OS</div>
            <div class="devis_content_cat">
            	<div class="linked_cat_content">
                	<?php
					//On va récupérer les catégories actuellements liées
					$sql="SELECT c.categorie, cc.id";
					$sql.=" FROM ".$tblpref."cat_x_cat_devis as cc";
					$sql.=" LEFT JOIN ".$tblpref."categorie as c ON c.id_cat = cc.id_cat";
					$sql.=" WHERE cc.cat_devis='os'";
					$req=mysql_query($sql);
					while($obj = mysql_fetch_object($req)) {
						?>
                        <div class="linked_cat">
							<form class="autosubmit" action="./include/form/del_cat_dev_predef.php" method="post">
                            	<input type="hidden" name="id" value="<?php echo $obj->id;?>"/>
								<span><?php echo $obj->categorie;?></span><button class="icons fa-times del" style="float:right;"></button>
                            </form>
                        </div>
                        <?php
					}
					?>
                </div>
            	<form class="autosubmit" action="./include/form/add_cat_dev_predef.php" method="post">
                    <div class="content_select_param_devis">
                        <select name="cat" id="cat_proc" class="select_param_devis">
                            <?php
                            $sql="SELECT * FROM ".$tblpref."categorie ORDER BY categorie ASC";
                            $req=mysql_query($sql);
                            while ($obj = mysql_fetch_object($req)) {
                                ?>
                                <option value="<?php echo $obj->id_cat;?>"><?php echo $obj->categorie.' | Lvl : '.$obj->cat_level;?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <input type="hidden" name="type" value="os"/>
                    <button class="icons fa-plus-square-o fa-3x add"></button>
                </form>
            </div>
        </div>
        
        <div class="part_param_devis">
            <div class="devis_cat">Logiciel</div>
            <div class="devis_content_cat">
            	<div class="linked_cat_content">
                	<?php
					//On va récupérer les catégories actuellements liées
					$sql="SELECT c.categorie, cc.id";
					$sql.=" FROM ".$tblpref."cat_x_cat_devis as cc";
					$sql.=" LEFT JOIN ".$tblpref."categorie as c ON c.id_cat = cc.id_cat";
					$sql.=" WHERE cc.cat_devis='software'";
					$req=mysql_query($sql);
					while($obj = mysql_fetch_object($req)) {
						?>
                        <div class="linked_cat">
							<form class="autosubmit" action="./include/form/del_cat_dev_predef.php" method="post">
                            	<input type="hidden" name="id" value="<?php echo $obj->id;?>"/>
								<span><?php echo $obj->categorie;?></span><button class="icons fa-times del" style="float:right;"></button>
                            </form>
                        </div>
                        <?php
					}
					?>
                </div>
            	<form class="autosubmit" action="./include/form/add_cat_dev_predef.php" method="post">
                    <div class="content_select_param_devis">
                        <select name="cat" id="cat_proc" class="select_param_devis">
                            <?php
                            $sql="SELECT * FROM ".$tblpref."categorie ORDER BY categorie ASC";
                            $req=mysql_query($sql);
                            while ($obj = mysql_fetch_object($req)) {
                                ?>
                                <option value="<?php echo $obj->id_cat;?>"><?php echo $obj->categorie.' | Lvl : '.$obj->cat_level;?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <input type="hidden" name="type" value="software"/>
                    <button class="icons fa-plus-square-o fa-3x add"></button>
                </form>
            </div>
        </div>
        
        <div class="part_param_devis">
            <div class="devis_cat">Ecran</div>
            <div class="devis_content_cat">
            	<div class="linked_cat_content">
                	<?php
					//On va récupérer les catégories actuellements liées
					$sql="SELECT c.categorie, cc.id";
					$sql.=" FROM ".$tblpref."cat_x_cat_devis as cc";
					$sql.=" LEFT JOIN ".$tblpref."categorie as c ON c.id_cat = cc.id_cat";
					$sql.=" WHERE cc.cat_devis='screen'";
					$req=mysql_query($sql);
					while($obj = mysql_fetch_object($req)) {
						?>
                        <div class="linked_cat">
							<form class="autosubmit" action="./include/form/del_cat_dev_predef.php" method="post">
                            	<input type="hidden" name="id" value="<?php echo $obj->id;?>"/>
								<span><?php echo $obj->categorie;?></span><button class="icons fa-times del" style="float:right;"></button>
                            </form>
                        </div>
                        <?php
					}
					?>
                </div>
            	<form class="autosubmit" action="./include/form/add_cat_dev_predef.php" method="post">
                    <div class="content_select_param_devis">
                        <select name="cat" id="cat_proc" class="select_param_devis">
                            <?php
                            $sql="SELECT * FROM ".$tblpref."categorie ORDER BY categorie ASC";
                            $req=mysql_query($sql);
                            while ($obj = mysql_fetch_object($req)) {
                                ?>
                                <option value="<?php echo $obj->id_cat;?>"><?php echo $obj->categorie.' | Lvl : '.$obj->cat_level;?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <input type="hidden" name="type" value="screen"/>
                    <button class="icons fa-plus-square-o fa-3x add"></button>
                </form>
            </div>
        </div>
        
        <div class="part_param_devis">
            <div class="devis_cat">Clavier</div>
            <div class="devis_content_cat">
            	<div class="linked_cat_content">
                	<?php
					//On va récupérer les catégories actuellements liées
					$sql="SELECT c.categorie, cc.id";
					$sql.=" FROM ".$tblpref."cat_x_cat_devis as cc";
					$sql.=" LEFT JOIN ".$tblpref."categorie as c ON c.id_cat = cc.id_cat";
					$sql.=" WHERE cc.cat_devis='keyboard'";
					$req=mysql_query($sql);
					while($obj = mysql_fetch_object($req)) {
						?>
                        <div class="linked_cat">
							<form class="autosubmit" action="./include/form/del_cat_dev_predef.php" method="post">
                            	<input type="hidden" name="id" value="<?php echo $obj->id;?>"/>
								<span><?php echo $obj->categorie;?></span><button class="icons fa-times del" style="float:right;"></button>
                            </form>
                        </div>
                        <?php
					}
					?>
                </div>
            	<form class="autosubmit" action="./include/form/add_cat_dev_predef.php" method="post">
                    <div class="content_select_param_devis">
                        <select name="cat" id="cat_proc" class="select_param_devis">
                            <?php
                            $sql="SELECT * FROM ".$tblpref."categorie ORDER BY categorie ASC";
                            $req=mysql_query($sql);
                            while ($obj = mysql_fetch_object($req)) {
                                ?>
                                <option value="<?php echo $obj->id_cat;?>"><?php echo $obj->categorie.' | Lvl : '.$obj->cat_level;?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <input type="hidden" name="type" value="keyboard"/>
                    <button class="icons fa-plus-square-o fa-3x add"></button>
                </form>
            </div>
        </div>
        
        <div class="part_param_devis">
            <div class="devis_cat">Souris</div>
            <div class="devis_content_cat">
            	<div class="linked_cat_content">
                	<?php
					//On va récupérer les catégories actuellements liées
					$sql="SELECT c.categorie, cc.id";
					$sql.=" FROM ".$tblpref."cat_x_cat_devis as cc";
					$sql.=" LEFT JOIN ".$tblpref."categorie as c ON c.id_cat = cc.id_cat";
					$sql.=" WHERE cc.cat_devis='mouse'";
					$req=mysql_query($sql);
					while($obj = mysql_fetch_object($req)) {
						?>
                        <div class="linked_cat">
							<form class="autosubmit" action="./include/form/del_cat_dev_predef.php" method="post">
                            	<input type="hidden" name="id" value="<?php echo $obj->id;?>"/>
								<span><?php echo $obj->categorie;?></span><button class="icons fa-times del" style="float:right;"></button>
                            </form>
                        </div>
                        <?php
					}
					?>
                </div>
            	<form class="autosubmit" action="./include/form/add_cat_dev_predef.php" method="post">
                    <div class="content_select_param_devis">
                        <select name="cat" id="cat_proc" class="select_param_devis">
                            <?php
                            $sql="SELECT * FROM ".$tblpref."categorie ORDER BY categorie ASC";
                            $req=mysql_query($sql);
                            while ($obj = mysql_fetch_object($req)) {
                                ?>
                                <option value="<?php echo $obj->id_cat;?>"><?php echo $obj->categorie.' | Lvl : '.$obj->cat_level;?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <input type="hidden" name="type" value="mouse"/>
                    <button class="icons fa-plus-square-o fa-3x add"></button>
                </form>
            </div>
        </div>
        
        <div class="part_param_devis">
            <div class="devis_cat">Enceintes</div>
            <div class="devis_content_cat">
            	<div class="linked_cat_content">
                	<?php
					//On va récupérer les catégories actuellements liées
					$sql="SELECT c.categorie, cc.id";
					$sql.=" FROM ".$tblpref."cat_x_cat_devis as cc";
					$sql.=" LEFT JOIN ".$tblpref."categorie as c ON c.id_cat = cc.id_cat";
					$sql.=" WHERE cc.cat_devis='hifi'";
					$req=mysql_query($sql);
					while($obj = mysql_fetch_object($req)) {
						?>
                        <div class="linked_cat">
							<form class="autosubmit" action="./include/form/del_cat_dev_predef.php" method="post">
                            	<input type="hidden" name="id" value="<?php echo $obj->id;?>"/>
								<span><?php echo $obj->categorie;?></span><button class="icons fa-times del" style="float:right;"></button>
                            </form>
                        </div>
                        <?php
					}
					?>
                </div>
            	<form class="autosubmit" action="./include/form/add_cat_dev_predef.php" method="post">
                    <div class="content_select_param_devis">
                        <select name="cat" id="cat_proc" class="select_param_devis">
                            <?php
                            $sql="SELECT * FROM ".$tblpref."categorie ORDER BY categorie ASC";
                            $req=mysql_query($sql);
                            while ($obj = mysql_fetch_object($req)) {
                                ?>
                                <option value="<?php echo $obj->id_cat;?>"><?php echo $obj->categorie.' | Lvl : '.$obj->cat_level;?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <input type="hidden" name="type" value="hifi"/>
                    <button class="icons fa-plus-square-o fa-3x add"></button>
                </form>
            </div>
        </div>
        
        <div class="part_param_devis">
            <div class="devis_cat">Casque/Micro</div>
            <div class="devis_content_cat">
            	<div class="linked_cat_content">
                	<?php
					//On va récupérer les catégories actuellements liées
					$sql="SELECT c.categorie, cc.id";
					$sql.=" FROM ".$tblpref."cat_x_cat_devis as cc";
					$sql.=" LEFT JOIN ".$tblpref."categorie as c ON c.id_cat = cc.id_cat";
					$sql.=" WHERE cc.cat_devis='headset'";
					$req=mysql_query($sql);
					while($obj = mysql_fetch_object($req)) {
						?>
                        <div class="linked_cat">
							<form class="autosubmit" action="./include/form/del_cat_dev_predef.php" method="post">
                            	<input type="hidden" name="id" value="<?php echo $obj->id;?>"/>
								<span><?php echo $obj->categorie;?></span><button class="icons fa-times del" style="float:right;"></button>
                            </form>
                        </div>
                        <?php
					}
					?>
                </div>
            	<form class="autosubmit" action="./include/form/add_cat_dev_predef.php" method="post">
                    <div class="content_select_param_devis">
                        <select name="cat" id="cat_proc" class="select_param_devis">
                            <?php
                            $sql="SELECT * FROM ".$tblpref."categorie ORDER BY categorie ASC";
                            $req=mysql_query($sql);
                            while ($obj = mysql_fetch_object($req)) {
                                ?>
                                <option value="<?php echo $obj->id_cat;?>"><?php echo $obj->categorie.' | Lvl : '.$obj->cat_level;?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <input type="hidden" name="type" value="headset"/>
                    <button class="icons fa-plus-square-o fa-3x add"></button>
                </form>
            </div>
        </div>
        
        <div class="part_param_devis">
            <div class="devis_cat">Cl&eacute; Wifi</div>
            <div class="devis_content_cat">
            	<div class="linked_cat_content">
                	<?php
					//On va récupérer les catégories actuellements liées
					$sql="SELECT c.categorie, cc.id";
					$sql.=" FROM ".$tblpref."cat_x_cat_devis as cc";
					$sql.=" LEFT JOIN ".$tblpref."categorie as c ON c.id_cat = cc.id_cat";
					$sql.=" WHERE cc.cat_devis='wifikey'";
					$req=mysql_query($sql);
					while($obj = mysql_fetch_object($req)) {
						?>
                        <div class="linked_cat">
							<form class="autosubmit" action="./include/form/del_cat_dev_predef.php" method="post">
                            	<input type="hidden" name="id" value="<?php echo $obj->id;?>"/>
								<span><?php echo $obj->categorie;?></span><button class="icons fa-times del" style="float:right;"></button>
                            </form>
                        </div>
                        <?php
					}
					?>
                </div>
            	<form class="autosubmit" action="./include/form/add_cat_dev_predef.php" method="post">
                    <div class="content_select_param_devis">
                        <select name="cat" id="cat_proc" class="select_param_devis">
                            <?php
                            $sql="SELECT * FROM ".$tblpref."categorie ORDER BY categorie ASC";
                            $req=mysql_query($sql);
                            while ($obj = mysql_fetch_object($req)) {
                                ?>
                                <option value="<?php echo $obj->id_cat;?>"><?php echo $obj->categorie.' | Lvl : '.$obj->cat_level;?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <input type="hidden" name="type" value="wifikey"/>
                    <button class="icons fa-plus-square-o fa-3x add"></button>
                </form>
            </div>
        </div>
        
        <div class="part_param_devis">
            <div class="devis_cat">Imprimante</div>
            <div class="devis_content_cat">
            	<div class="linked_cat_content">
                	<?php
					//On va récupérer les catégories actuellements liées
					$sql="SELECT c.categorie, cc.id";
					$sql.=" FROM ".$tblpref."cat_x_cat_devis as cc";
					$sql.=" LEFT JOIN ".$tblpref."categorie as c ON c.id_cat = cc.id_cat";
					$sql.=" WHERE cc.cat_devis='printer'";
					$req=mysql_query($sql);
					while($obj = mysql_fetch_object($req)) {
						?>
                        <div class="linked_cat">
							<form class="autosubmit" action="./include/form/del_cat_dev_predef.php" method="post">
                            	<input type="hidden" name="id" value="<?php echo $obj->id;?>"/>
								<span><?php echo $obj->categorie;?></span><button class="icons fa-times del" style="float:right;"></button>
                            </form>
                        </div>
                        <?php
					}
					?>
                </div>
            	<form class="autosubmit" action="./include/form/add_cat_dev_predef.php" method="post">
                    <div class="content_select_param_devis">
                        <select name="cat" id="cat_proc" class="select_param_devis">
                            <?php
                            $sql="SELECT * FROM ".$tblpref."categorie ORDER BY categorie ASC";
                            $req=mysql_query($sql);
                            while ($obj = mysql_fetch_object($req)) {
                                ?>
                                <option value="<?php echo $obj->id_cat;?>"><?php echo $obj->categorie.' | Lvl : '.$obj->cat_level;?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <input type="hidden" name="type" value="printer"/>
                    <button class="icons fa-plus-square-o fa-3x add"></button>
                </form>
            </div>
        </div>
        
        <div class="part_param_devis">
            <div class="devis_cat">Webcam</div>
            <div class="devis_content_cat">
            	<div class="linked_cat_content">
                	<?php
					//On va récupérer les catégories actuellements liées
					$sql="SELECT c.categorie, cc.id";
					$sql.=" FROM ".$tblpref."cat_x_cat_devis as cc";
					$sql.=" LEFT JOIN ".$tblpref."categorie as c ON c.id_cat = cc.id_cat";
					$sql.=" WHERE cc.cat_devis='webcam'";
					$req=mysql_query($sql);
					while($obj = mysql_fetch_object($req)) {
						?>
                        <div class="linked_cat">
							<form class="autosubmit" action="./include/form/del_cat_dev_predef.php" method="post">
                            	<input type="hidden" name="id" value="<?php echo $obj->id;?>"/>
								<span><?php echo $obj->categorie;?></span><button class="icons fa-times del" style="float:right;"></button>
                            </form>
                        </div>
                        <?php
					}
					?>
                </div>
            	<form class="autosubmit" action="./include/form/add_cat_dev_predef.php" method="post">
                    <div class="content_select_param_devis">
                        <select name="cat" id="cat_proc" class="select_param_devis">
                            <?php
                            $sql="SELECT * FROM ".$tblpref."categorie ORDER BY categorie ASC";
                            $req=mysql_query($sql);
                            while ($obj = mysql_fetch_object($req)) {
                                ?>
                                <option value="<?php echo $obj->id_cat;?>"><?php echo $obj->categorie.' | Lvl : '.$obj->cat_level;?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <input type="hidden" name="type" value="webcam"/>
                    <button class="icons fa-plus-square-o fa-3x add"></button>
                </form>
            </div>
        </div>
        
        <div class="part_param_devis">
            <div class="devis_cat">Autre</div>
            <div class="devis_content_cat">
            	<div class="linked_cat_content">
                	<?php
					//On va récupérer les catégories actuellements liées
					$sql="SELECT c.categorie, cc.id";
					$sql.=" FROM ".$tblpref."cat_x_cat_devis as cc";
					$sql.=" LEFT JOIN ".$tblpref."categorie as c ON c.id_cat = cc.id_cat";
					$sql.=" WHERE cc.cat_devis='other'";
					$req=mysql_query($sql);
					while($obj = mysql_fetch_object($req)) {
						?>
                        <div class="linked_cat">
							<form class="autosubmit" action="./include/form/del_cat_dev_predef.php" method="post">
                            	<input type="hidden" name="id" value="<?php echo $obj->id;?>"/>
								<span><?php echo $obj->categorie;?></span><button class="icons fa-times del" style="float:right;"></button>
                            </form>
                        </div>
                        <?php
					}
					?>
                </div>
            	<form class="autosubmit" action="./include/form/add_cat_dev_predef.php" method="post">
                    <div class="content_select_param_devis">
                        <select name="cat" id="cat_proc" class="select_param_devis">
                            <?php
                            $sql="SELECT * FROM ".$tblpref."categorie ORDER BY categorie ASC";
                            $req=mysql_query($sql);
                            while ($obj = mysql_fetch_object($req)) {
                                ?>
                                <option value="<?php echo $obj->id_cat;?>"><?php echo $obj->categorie.' | Lvl : '.$obj->cat_level;?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <input type="hidden" name="type" value="other"/>
                    <button class="icons fa-plus-square-o fa-3x add"></button>
                </form>
            </div>
        </div>
        
        <div class="part_param_devis">
            <div class="devis_cat">C&acirc;ble</div>
            <div class="devis_content_cat">
            	<div class="linked_cat_content">
                	<?php
					//On va récupérer les catégories actuellements liées
					$sql="SELECT c.categorie, cc.id";
					$sql.=" FROM ".$tblpref."cat_x_cat_devis as cc";
					$sql.=" LEFT JOIN ".$tblpref."categorie as c ON c.id_cat = cc.id_cat";
					$sql.=" WHERE cc.cat_devis='wire'";
					$req=mysql_query($sql);
					while($obj = mysql_fetch_object($req)) {
						?>
                        <div class="linked_cat">
							<form class="autosubmit" action="./include/form/del_cat_dev_predef.php" method="post">
                            	<input type="hidden" name="id" value="<?php echo $obj->id;?>"/>
								<span><?php echo $obj->categorie;?></span><button class="icons fa-times del" style="float:right;"></button>
                            </form>
                        </div>
                        <?php
					}
					?>
                </div>
            	<form class="autosubmit" action="./include/form/add_cat_dev_predef.php" method="post">
                    <div class="content_select_param_devis">
                        <select name="cat" id="cat_proc" class="select_param_devis">
                            <?php
                            $sql="SELECT * FROM ".$tblpref."categorie ORDER BY categorie ASC";
                            $req=mysql_query($sql);
                            while ($obj = mysql_fetch_object($req)) {
                                ?>
                                <option value="<?php echo $obj->id_cat;?>"><?php echo $obj->categorie.' | Lvl : '.$obj->cat_level;?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <input type="hidden" name="type" value="wire"/>
                    <button class="icons fa-plus-square-o fa-3x add"></button>
                </form>
            </div>
        </div>
    </div>
</div>     
        
<?php 
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>