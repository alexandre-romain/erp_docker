/* ---------------------------- */
/* XMLHTTPRequest Enable 		*/
/* ---------------------------- */
/*
function showprice() {
	nocache = Math.random();
	var cli = document.getElementById("fk_product").value;
	http.open('get', 'include/ajax/autocomplete_price.php?cli='+cli+'&nocache = '+nocache);
	http.onreadystatechange = showrep5;
	http.send(null);
}

function showrep5() {
	if(http.readyState == 4){
	
		var response = http.responseText;
		e = document.getElementById('div_price');
	
		if(response!=""){
			e.innerHTML=response;
		}
	
}
}
*/

/* FONCTION DE BASE, PERMET DE DEFINIR L'OBJET 'http' */
function createObject() {
	var request_type;
	var browser = navigator.appName;
	if(browser == "Microsoft Internet Explorer"){
	request_type = new ActiveXObject("Microsoft.XMLHTTP");
	}else{
		request_type = new XMLHttpRequest();
	}
		return request_type;
}

var http = createObject();


/* -------------------------- */
/* SEARCH					 */
/* -------------------------- */

/* FONCTION PERMETTANT D'AFFICHE UNE LISTE DES CLIENTS, UTILISEE dans new_task.php (creation de ticket) et dans choix_cli.php (appelé sur les page ou une selection client est nécessaire) */
function autosuggest(rech) {
	nocache = Math.random();	// Set te random number to add to URL request
	if(rech == "asoc")
	{
		q = document.getElementById('search_soc').value;
		http.open('get', 'include/ajax/autocomplete_client.php?q='+q+'&nocache = '+nocache);
		http.onreadystatechange = autosuggestReply1;
	} 
	/*else if (rech == "soc")
	{
		q = document.getElementById('search_soc').value;
		http.open('get', 'include/ajax/autocomplete_client.php?q='+q+'&nocache = '+nocache);
		http.onreadystatechange = autosuggestReply5;
		
	}*/
	/*
	else if(rech == "inter")
	
	{
		q = document.getElementById('search_inter').value;
		http.open('get', 'include/ajax/autocomplete_inter.php?q='+q+'&nocache = '+nocache);
		http.onreadystatechange = autosuggestReply3;
	} else if(rech == "product")
	{
		q = document.getElementById('search_product').value;
		http.open('get', 'include/ajax/autocomplete_product.php?q='+q+'&nocache = '+nocache);
		http.onreadystatechange = autosuggestReply4;
	} else if(rech == "prix")
	{
		q = document.getElementById('fk_product').value;
		http.open('get', 'include/ajax/autocomplete_price.php?q='+q+'&nocache = '+nocache);
		http.onreadystatechange = autosuggestReply4;
		showprice()
	}
	*/
	
		//r = document.getElementById('rotation').value;
	http.send(null);
}
function autosuggestReply1() {
	if(http.readyState == 4){
		var response = http.responseText;
		e = document.getElementById('listeville');
		if(response!=""){
			e.innerHTML=response;
		}
		showcontrat();
	}
}
/* FIN FONCTION PERMETTANT D'AFFICHE UNE LISTE DES CLIENTS, UTILISEE dans new_task.php (creation de ticket) et dans choix_cli.php (appelé sur les page ou une selection client est nécessaire) */
/* Si l'on recherche un PC, on utilise la fonction AutosuggestReply2 */
/*function autosuggestReply2() {
if(http.readyState == 4){
	
	var response = http.responseText;
	ro = document.getElementById('pc');
	
	if(response!=""){
		ro.innerHTML=response;
	}
}
}*/
/* Si l'on recherche une intervention, on utilise la fonction AutosuggestReply3 */
/*function autosuggestReply3() {
if(http.readyState == 4){
	
	var response = http.responseText;
	ro = document.getElementById('fk_inter');
	
	if(response!=""){
		ro.innerHTML=response;
	}
}
}*/
/* Si l'on recherche un produit, on utilise la fonction AutosuggestReply4 */
/*function autosuggestReply4() {
if(http.readyState == 4){
	
	var response = http.responseText;
	ro = document.getElementById('fk_product');
	
	if(response!=""){
		ro.innerHTML=response;
		showprice()
	}
}
}*/
/*function autosuggestReply5() {
if(http.readyState == 4){
	
	var response = http.responseText;
	ro = document.getElementById('price');
	
	if(response!=""){
		ro.innerHTML=response;
	}
}
}*/

/* FONCTION PERMETTANT D'AFFICHE UNE LISTE DES ARTICLES, UTILISEE dans categorie_choix.php (appelé sur les pages ou une sélection des articles est nécessaire) */
function showarticle() {
	
	nocache = Math.random();
	var rech = document.getElementById("rech").value;
	http.open('get', 'include/ajax/autocomplete_article.php?rech='+rech+'&nocache = '+nocache);
	http.onreadystatechange = function() { repshowarticle(rech) };
	http.send(null);
	
}

function repshowarticle(rech) {
	if(http.readyState == 4){
		var response = http.responseText;
		e = document.getElementById('article');
		f = document.getElementById('create_article_link');
		if(response!="" && response!="no"){
			/*e.innerHTML=response;
			e.style.display="block";
			ro.style.display="none";*/
			e.innerHTML=response;
			f.style.display='none';
		}
		else {
			if (response == 'no') {
				f.style.display='inline-block';
			}
		}
	
}
}
/* FIN FONCTION PERMETTANT D'AFFICHE UNE LISTE DES ARTICLES, UTILISEE dans categorie_choix.php (appelé sur les pages ou une sélection des articles est nécessaire) */
/*function showclient() {
	
	nocache = Math.random();
	var rech = document.getElementById("rech_cli").value;
	http.open('get', 'include/ajax/autocomplete_client2.php?rech='+rech+'&nocache = '+nocache);
	http.onreadystatechange = repshowclient;
	http.send(null);
	
}

function repshowclient() {
	if(http.readyState == 4){
		
		var response = http.responseText;
		e = document.getElementById('listeville');
	
		if(response!=""){
			e.innerHTML=response;
		}	
	}
}*/

<!--Fonction utilisée sur lister_articles_form.php(liste des articles) - Sert sur le champ de recherche-->
function recherche_article() {
	nocache = Math.random();
	var rech = document.getElementById("search_article").value;
	s = document.getElementById('aff_filtres');
	s.innerHTML='( Filtres : '+rech+'... )';
	http.open('get', 'include/ajax/search_list_article.php?rech='+rech+'&nocache = '+nocache);
	http.onreadystatechange = rep_recherche_article;
	http.send(null);
	
}

function rep_recherche_article() {
	if(http.readyState == 4){
		var response = http.responseText;
		e = document.getElementById('tableau_results');
		$("#show_article").hide();
		$("#hide_article").show();
		$("#article").show(500);
		if(response!=""){
			/*e.innerHTML=response;
			e.style.display="block";
			ro.style.display="none";*/
			e.innerHTML=response;
			$('.edit_name').editable('./include/ajax/edit_name_aff.php');
			/* DATATABLES DEVIS PREDEFINIS */
			/* Formatting function for row details - modify as you need */
			function format ( d ) {
				// `d` is the original data object for the row
				return '<div id="details['+d.id+']" class="container_details"></div>';
			} 
			$(document).ready(function() {						   
				var table = $('#list').DataTable( {
					"columns": [
						{
							"className":      'details-control',
							"orderable":      false,
							"data":           null,
							"defaultContent": '&nbsp;',
							"width":		  "5%"	
						},
						{ "data": "id","width": "5%" },
						{ "data": "topcat", "width": "5%" },
						{ "data": "midcat", "width": "5%" },
						{ "data": "botcat", "width": "5%" },
						{ "data": "marque", "width": "5%" },
						{ "data": "article", "width": "5%" },
						{ "data": "nomaff", "width": "5%" },
						{ "data": "pn", "width": "5%" },
						{ "data": "stock", "width": "5%" },
						{ "data": "pa", "width": "5%" },
						{ "data": "pvht", "width": "5%" },
						{ "data": "pvttc", "width": "5%" },
						{ "data": "actions", "width": "5%" }
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
				$('#list tbody').on('click', 'td.details-control', function () {
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
						show_det_article(idline);
						
					}
				} );
			} );
		}
		else {
			/* MESSAGE PAS DE RESULTS */
			e.innerHTML='Aucun resultat ne correspond à votre recherche.';
		}
	}
}

<!--Fonction utilisée sur lister_articles_form.php(liste des articles) - Sert sur le select topcat-->
function top_to_middle_cat() {
	
	nocache = Math.random();
	var rech = document.getElementById("top_cat").value;
	http.open('get', 'include/ajax/autocomplete_cat.php?rech='+rech+'&nocache = '+nocache);
	http.onreadystatechange = rep_top_to_middle_cat;
	http.send(null);
	
}

function rep_top_to_middle_cat() {
	if(http.readyState == 4){
		
		var response = http.responseText;
		e = document.getElementById('mid_cat');
	
		if(response!=""){
			/*e.innerHTML=response;
			e.style.display="block";
			ro.style.display="none";*/
			e.innerHTML=response;
			document.getElementById('bot_cat').innerHTML=''; //Permet de vider la botcat des resultats précédents (case: mouse clic botcat and then change topcat)
		}	
	}
}

<!--Fonction utilisée sur lister_articles_form.php(liste des articles) - Sert sur le select middlecat-->
function middle_to_bot_cat() {
	
	nocache = Math.random();
	var rech = document.getElementById("mid_cat").value;
	http.open('get', 'include/ajax/autocomplete_cat.php?rech='+rech+'&nocache = '+nocache);
	http.onreadystatechange = rep_middle_to_bot_cat;
	http.send(null);
	
}

function rep_middle_to_bot_cat() {
	if(http.readyState == 4){
		
		var response = http.responseText;
		e = document.getElementById('bot_cat');
	
		if(response!=""){
			/*e.innerHTML=response;
			e.style.display="block";
			ro.style.display="none";*/
			e.innerHTML=response;
		}	
	}
}

function top_to_middle_cat2() {
	
	nocache = Math.random();
	var rech = document.getElementById("cat1").value;
	http.open('get', 'include/ajax/autocomplete_cat.php?rech='+rech+'&nocache = '+nocache);
	http.onreadystatechange = rep_top_to_middle_cat2;
	http.send(null);
	
}

function rep_top_to_middle_cat2() {
	if(http.readyState == 4){
		
		var response = http.responseText;
		e = document.getElementById('cat2');
	
		if(response!=""){
			/*e.innerHTML=response;
			e.style.display="block";
			ro.style.display="none";*/
			e.innerHTML=response;
			document.getElementById('cat3').innerHTML=''; //Permet de vider la botcat des resultats précédents (case: mouse clic botcat and then change topcat)
		}	
	}
}

<!--Fonction utilisée sur lister_articles_form.php(liste des articles) - Sert sur le select middlecat-->
function middle_to_bot_cat2() {
	
	nocache = Math.random();
	var rech = document.getElementById("cat2").value;
	http.open('get', 'include/ajax/autocomplete_cat.php?rech='+rech+'&nocache = '+nocache);
	http.onreadystatechange = rep_middle_to_bot_cat2;
	http.send(null);
	
}

function rep_middle_to_bot_cat2() {
	if(http.readyState == 4){
		
		var response = http.responseText;
		e = document.getElementById('cat3');
	
		if(response!=""){
			/*e.innerHTML=response;
			e.style.display="block";
			ro.style.display="none";*/
			e.innerHTML=response;
		}	
	}
}

<!--Fonction utilisée sur lister_articles_form.php(liste des articles) - Permet d'afficher (déplier) le détail article-->
function show_det_article(arg) {
	nocache = Math.random();
	var rech = arg;
	http.open('get', 'include/ajax/details_article.php?id='+rech+'&nocache='+nocache);
	http.onreadystatechange = function() { rep_show_det_article(arg) };
	http.send(null);
}

function rep_show_det_article(arg) {
	if(http.readyState == 4){	
		var response = http.responseText;
		e = document.getElementById('details['+arg+']');	
		if(response!=""){
			e.innerHTML=response;
			$('.edit_stock_fi').editable('./include/ajax/edit_article.php?num='+arg, {
			 tooltip   : 'Cliquez pour modifier...',
			 cssclass : 'jedit'
			});  
			$('.edit_stomin').editable('./include/ajax/edit_article.php?num='+arg, {
			 tooltip   : 'Cliquez pour modifier...',
			 cssclass : 'jedit'
			}); 
			$('.edit_stomax').editable('./include/ajax/edit_article.php?num='+arg, {				   
			 tooltip   : 'Cliquez pour modifier...',
			 cssclass : 'jedit'
			}); 
			$('.edit_garantie').editable('./include/ajax/edit_article.php?num='+arg, {
			 tooltip   : 'Cliquez pour modifier...',
			 cssclass : 'jedit'
			}); 
			$('.edit_marge').editable('./include/ajax/edit_article.php?num='+arg, {
			 tooltip   : 'Cliquez pour modifier...',
			 cssclass : 'jedit'
			}); 
			$('.edit_tva').editable('./include/ajax/edit_article.php?num='+arg, {
			 tooltip   : 'Cliquez pour modifier...',
			 cssclass : 'jedit'
			}); 
			 $('.edit_note').editable('./include/ajax/edit_article.php?num='+arg, {
			 tooltip   : 'Cliquez pour modifier...',
			 cssclass : 'jedit'
		 	}); 
			 $('.edit_n_perso').editable('./include/ajax/edit_article.php?num='+arg, {
			 tooltip   : 'Cliquez pour modifier...',
			 cssclass : 'jedit'
		 	}); 
			 $('.edit_art').editable('./include/ajax/edit_article.php?num='+arg, {
			 tooltip   : 'Cliquez pour modifier...',
			 cssclass : 'jedit'
		 	}); 
		}	
	}
}

<!--Fonction utilisée sur lister_articles_form.php(liste des articles) - Permet de faire disparaitre le détail article-->
function hide_det(arg) {
		var response = '';
		e = document.getElementById('detail['+arg+']');	
		e.innerHTML=response;
}

function add_line_article_package() {
	nbr = document.getElementById('nbr_lines').value;
	e = document.getElementById('added_articles');
	var newnbr = ++nbr;
	document.getElementById('nbr_lines').value = newnbr;
	e.innerHTML+='<tr id="line'+newnbr+'"><td class=""><i class="fa fa-search fa-fw"></i> <input type="text" id="search_art_'+newnbr+'" onKeyUp="rech_art('+newnbr+')" class="styled"></td><td class=""><div class="styled-select-inline" style="width:100%"><select class="styled-inline" name="articles['+newnbr+'][name]" id="articles'+newnbr+'"><option value="">Veuillez d\'abord effectuer une recherche...</option></select></div></td><td width="20%">Qt&eacute; : <input type="text" name="articles['+newnbr+'][qty]" id="qty_'+newnbr+'" class="styled"></td><td><i class="fa fa-minus-circle fa-fw fa-2x del" onclick="del_line_package('+newnbr+')"></i></td></tr>';
}

function del_line_package(id) {
	var ligne = document.getElementById("line"+id);
    document.getElementById("add_package").deleteRow(ligne.rowIndex);
}

function rech_art(id) {
	
	nocache = Math.random();
	rech = document.getElementById('search_art_'+id).value;
	http.open('get', 'include/ajax/rech_article.php?rech='+rech+'&nocache='+nocache);
	http.onreadystatechange = function() { rep_rech_art(id) };
	http.send(null);
}

function rep_rech_art(id) {
	
	if(http.readyState == 4){	
		var response = http.responseText;
		e = document.getElementById('articles'+id);	
		if(response!=""){
			e.innerHTML=response;
		}	
	}
}

function det_package(id) {
	nocache = Math.random();
	http.open('get', 'include/ajax/det_package.php?id='+id+'&nocache='+nocache);
	http.onreadystatechange = function() { rep_det_package(id) };
	http.send(null);
}

function rep_det_package(id) {
	if(http.readyState == 4){	
		var response = http.responseText;
		e = document.getElementById('cont_details'+id);	
		if(response!=""){
			e.innerHTML=response;
			$('.autosubmit').ajaxForm(function() { 
				det_package(id);
			});
		}	
	}
}

function del_cont_package(id_cont,id_package) {
	nocache = Math.random();
	http.open('get', 'include/form/del_cont_package.php?id='+id_cont+'&nocache='+nocache);
	http.onreadystatechange = function() { det_package(id_package) };
	http.send(null);
}

function edit_package(id) {
	nocache = Math.random();
	http.open('get', 'include/ajax/edit_package.php?id='+id+'&nocache='+nocache);
	http.onreadystatechange = function() { rep_edit_package() };
	http.send(null);
}

function rep_edit_package() {
	if(http.readyState == 4){	
		var response = http.responseText;
		e = document.getElementById('cont_modale');	
		if(response!=""){
			e.innerHTML=response;
			$(function() {
				$( ".datepicker" ).datepicker({
					changeMonth: true,
					changeYear: true,
					dateFormat: "dd-mm-yy" 
				})
			});
		}	
	}
}

function add_line_edit_package() {
	nbr = document.getElementById('nbr_lines_edit').value;
	e = document.getElementById('addes_lines');
	var newnbr = ++nbr;
	document.getElementById('nbr_lines_edit').value = newnbr;
	e.innerHTML+='<Label class="inline">Recherche article '+newnbr+':</label><input type="text" id="search_art_'+newnbr+'" onKeyUp="rech_art('+newnbr+')"><div align="center"><select name="articles[]" id="articles'+newnbr+'"></select></div>';
}

function rech_art_inline() {
	nocache = Math.random();
	rech = document.getElementById('search_art').value;
	http.open('get', 'include/ajax/rech_article.php?rech='+rech+'&nocache='+nocache);
	http.onreadystatechange = function() { rep_rech_art_inline() };
	http.send(null);
}

function rep_rech_art_inline() {
	if(http.readyState == 4){	
		var response = http.responseText;
		e = document.getElementById('articles');	
		if(response!=""){
			e.innerHTML=response;
		}	
	}
}

function add_line_task() {
	nocache = Math.random();
	nbr = document.getElementById('nbr_lines').value;
	var newnbr = ++nbr;
	document.getElementById('nbr_lines').value = newnbr;
	http.open('get', 'include/ajax/add_line_task.php?nbr='+newnbr+'&nocache='+nocache);
	http.onreadystatechange = function() { rep_add_line_task() };
	http.send(null);
}

function rep_add_line_task() {
	if(http.readyState == 4){	
		var response = http.responseText;
		e = document.getElementById('added_task');	
		if(response!=""){
			e.innerHTML+=response;
			$(function() {
				$( ".datepicker" ).datepicker({
					changeMonth: true,
					changeYear: true,
					dateFormat: "dd-mm-yy" })
			});
		}	
	}
}

function del_line_task(id) {
	var ligne = document.getElementById("line"+id);
    document.getElementById("add_task").deleteRow(ligne.rowIndex);
}

function copy_name_ticket() {
	name = document.getElementById('name_ticket').value;
	document.getElementById('name_task').value = name;
}

function copy_date_ticket() {
	name = document.getElementById('date_due_ticket').value;
	document.getElementById('date_due_task').value = name;
}

function copy_hour_ticket() {
	name = document.getElementById('hour_due_ticket').value;
	document.getElementById('hour_due_task').value = name;
}

function copy_min_ticket() {
	name = document.getElementById('min_due_ticket').value;
	document.getElementById('min_due_task').value = name;
}

function recharger() {
	window.location.reload(); 
}

function save_pref(type, state) {
	nocache = Math.random();
	http.open('get', 'include/ajax/save_pref_acceuil.php?type='+type+'&state='+state+'&nocache='+nocache);
	http.send(null);
}

function save_aff(type, state) {
	nocache = Math.random();
	http.open('get', 'include/ajax/save_aff_acceuil.php?type='+type+'&state='+state+'&nocache='+nocache);
	http.onreadystatechange = function() { recharger() };
	http.send(null);
}

function change_back(name) {
	nocache = Math.random();
	http.open('get', 'include/ajax/save_back.php?name='+name+'&nocache='+nocache);
	http.onreadystatechange = function() { recharger() };
	http.send(null);
}

function copy_pn() {
	nocache = Math.random();
	id = document.getElementById('article').value;
	http.open('get', 'include/ajax/copy_pn.php?id='+id+'&nocache='+nocache);
	http.onreadystatechange = function() { rep_copy_pn() };
	http.send(null);
}

function rep_copy_pn() {
	if(http.readyState == 4){	
		var response = http.responseText;
		e = document.getElementById('pn_copy');	
		if(response!=""){
			e.value=response;
		}	
	}
}

/*function check_fact_contrat() {
	var fact = document.getElementById('facturation').value;
	place = document.getElementById('contract_place');	
	if (fact == 'pon') {
		place.style.display = 'none';
	}
	else {
		place.style.display = 'table';
	}
}*/

function check_monitoring() {
	e = document.getElementById('monitoring_place');
	f = document.getElementById('fact_place');
	test = document.getElementById('contrat');
	if (document.getElementById('monitoring').checked == true) {
		e.style.display = 'table-row-group';
		f.style.display = 'table-row-group';
	} 
	else if (document.getElementById('monitoring').checked == false && test === null || document.getElementById('monitoring').checked == false && document.getElementById('contrat').checked == false){
		e.style.display = 'none';
		f.style.display = 'none';
	} 
	else if (document.getElementById('monitoring').checked == false && document.getElementById('contrat').checked == true) {
		e.style.display = 'none';
		f.style.display = 'table-row-group';
	}
}

function check_contrat() {
	e = document.getElementById('contract_place');
	f = document.getElementById('fact_place');
	test = document.getElementById('monitoring');
	if (document.getElementById('contrat').checked == true) {
		e.style.display = 'table-row-group';
		f.style.display = 'table-row-group';
	} 
	else if (document.getElementById('contrat').checked == false && test === null || document.getElementById('monitoring').checked == false && document.getElementById('contrat').checked == false) {
		e.style.display = 'none';
		f.style.display = 'none';
	} else if (document.getElementById('monitoring').checked == true && document.getElementById('contrat').checked == false) {
		e.style.display = 'none';
		f.style.display = 'table-row-group';
	}
}

function check_sign() {
	f = document.getElementById('fact_first_place');
	test = document.getElementById('sign_m');
	if (document.getElementById('sign').checked == true) {
		f.style.display = 'table-row-group';
	} 
	else if (document.getElementById('sign').checked == false && test === null || document.getElementById('sign').checked == false && document.getElementById('sign_m').checked == false) {
		f.style.display = 'none';
	}
	else if (document.getElementById('sign').checked == false && document.getElementById('sign_m').checked == true) {
		f.style.display = 'table-row-group';
	} 
	
}

function check_sign_m() {
	f = document.getElementById('fact_first_place');
	test = document.getElementById('sign');
	if (document.getElementById('sign_m').checked == true) {
		f.style.display = 'table-row-group';
	} 
	else if (test === null && document.getElementById('sign_m').checked == false || document.getElementById('sign').checked == false && document.getElementById('sign_m').checked == false) {
		f.style.display = 'none';
	}
	else if (document.getElementById('sign').checked == true && document.getElementById('sign_m').checked == false) {
		f.style.display = 'table-row-group';
	} 
}

function calc_price() {
	var pc = document.getElementById('nbr_pc').value;
	var notebook = document.getElementById('nbr_laptop').value;
	var server = document.getElementById('nbr_server').value;
	var mobile = document.getElementById('nbr_mobile').value;
	var printer = document.getElementById('nbr_printer').value;
	var fact = document.getElementById('facturation').value;
	if (fact == 'pon') {
		document.getElementById("prix_c").value = '';
		document.getElementById("prix_m").value = '';
		return
	}
	else if (fact == 'men') {
		var multiplier = 1;
	}
	else if (fact == 'tri') {
		var multiplier = 3;
	}
	else if (fact == 'sem') {
		var multiplier = 6;
	}
	else if (fact == 'ann') {
		var multiplier = 12;
	}
	/* CALCUL DU PRIX CONTRAT */
	/* ON REGROUPE LES POSTE DE TRAVAIL (PC + LAPTOP)*/
	var pc = pc*1;
	var notebook = notebook*1;	
	var poste = pc + notebook;
	/* CALCUL DU PRIX POSTES DE TRAVAILS */
	if (poste < 6) {
		var p_pc=40*poste;
	}
	else if (poste < 11) {
		var p_pc=200+(35*(poste-5));
	}
	else if (poste < 16) {
		var p_pc=375+(30*(poste-10));
	}
	else if (poste < 21) {
		var p_pc=525+(25*(poste-15));
	}
	else if (poste > 20) {
		var p_pc=625+(20*(poste-20));
	}
	/* CALCUL DU PRIX SERVER */
	var p_server = 80*server;
	/* CALCUL DU PRIX MOBILE */
	var p_mobile = 0*mobile;
	/* CALCUL DU PRIX PRINTER */
	var p_printer = 0*printer;
	/* CALCUL DU TOTAL */
	var p_tot = (p_pc + p_server + p_mobile + p_printer)*multiplier;
	document.getElementById("prix_c").value = p_tot;
	/* CALCUL DU PRIX MAINTENANCE */
	var fact_m = document.getElementById('facturation').value;
	if (fact_m == 'men') {
		var multiplier_m = 1;
	}
	else if (fact_m == 'tri') {
		var multiplier_m = 3;
	}
	else if (fact_m == 'sem') {
		var multiplier_m = 6;
	}
	else if (fact_m == 'ann') {
		var multiplier_m = 12;
	}
	/* CALCUL DU PRIX POSTES DE TRAVAILS */
	var m_poste = 5*poste;
	/* CALCUL DU PRIX SERVER */
	var m_server = 30*server;
	/* CALCUL DU PRIX MOBILE */
	var m_mobile = 0*mobile;
	/* CALCUL DU PRIX PRINTER */
	var m_printer = 0*printer;
	/* CALCUL DU TOTAL */
	var m_tot = (m_printer + m_mobile + m_server + m_poste)*multiplier_m;
	document.getElementById("prix_m").value = m_tot;
}

function calc_price_gen() {
	var pc = document.getElementById('nbr_pc').value;
	var notebook = document.getElementById('nbr_laptop').value;
	var server = document.getElementById('nbr_server').value;
	var mobile = document.getElementById('nbr_mobile').value;
	var printer = document.getElementById('nbr_printer').value;
	var fact = document.getElementById('facturation').value;
	if (fact == 'men') {
		var multiplier = 1;
	}
	else if (fact == 'tri') {
		var multiplier = 3;
	}
	else if (fact == 'sem') {
		var multiplier = 6;
	}
	else if (fact == 'ann') {
		var multiplier = 12;
	}
	
	/* CALCUL DU PRIX CONTRAT */
	/* ON REGROUPE LES POSTE DE TRAVAIL (PC + LAPTOP)*/
	var pc = pc*1;
	var notebook = notebook*1;	
	var poste = pc + notebook;
	/* CALCUL DU PRIX POSTES DE TRAVAILS */
	if (poste < 6) {
		var p_pc=40*poste;
	}
	else if (poste < 11) {
		var p_pc=200+(35*(poste-5));
	}
	else if (poste < 16) {
		var p_pc=375+(30*(poste-10));
	}
	else if (poste < 21) {
		var p_pc=525+(25*(poste-15));
	}
	else if (poste > 20) {
		var p_pc=625+(20*(poste-20));
	}
	/* CALCUL DU PRIX SERVER */
	var p_server = 80*server;
	/* CALCUL DU PRIX MOBILE */
	var p_mobile = 0*mobile;
	/* CALCUL DU PRIX PRINTER */
	var p_printer = 0*printer;
	/* CALCUL DU TOTAL */
	var p_tot = (p_pc + p_server + p_mobile + p_printer)*multiplier;
	test = document.getElementById("prix_c");
	if (test === null) {
	}
	else {
		document.getElementById("prix_c").value = p_tot;
	}
	/* CALCUL DU PRIX MAINTENANCE */
	var fact_m = document.getElementById('facturation').value;
	if (fact_m == 'men') {
		var multiplier_m = 1;
	}
	else if (fact_m == 'tri') {
		var multiplier_m = 3;
	}
	else if (fact_m == 'sem') {
		var multiplier_m = 6;
	}
	else if (fact_m == 'ann') {
		var multiplier_m = 12;
	}
	/* CALCUL DU PRIX POSTES DE TRAVAILS */
	var m_poste = 5*poste;
	/* CALCUL DU PRIX SERVER */
	var m_server = 30*server;
	/* CALCUL DU PRIX MOBILE */
	var m_mobile = 0*mobile;
	/* CALCUL DU PRIX PRINTER */
	var m_printer = 0*printer;
	/* CALCUL DU TOTAL */
	var m_tot = (m_printer + m_mobile + m_server + m_poste)*multiplier_m;
	document.getElementById("prix_m").value = m_tot;
}

function calc_price_c() {
	var pc = document.getElementById('nbr_pc_c').value;
	var notebook = document.getElementById('nbr_laptop_c').value;
	var server = document.getElementById('nbr_server_c').value;
	var mobile = document.getElementById('nbr_mobile_c').value;
	var printer = document.getElementById('nbr_printer_c').value;
	var fact = document.getElementById('facturation_c').value;
	if (fact == 'men') {
		var multiplier = 1;
	}
	else if (fact == 'tri') {
		var multiplier = 3;
	}
	else if (fact == 'sem') {
		var multiplier = 6;
	}
	else if (fact == 'ann') {
		var multiplier = 12;
	}
	/* CALCUL DU PRIX CONTRAT */
	/* ON REGROUPE LES POSTE DE TRAVAIL (PC + LAPTOP)*/
	var pc = pc*1;
	var notebook = notebook*1;	
	var poste = pc + notebook;
	/* CALCUL DU PRIX POSTES DE TRAVAILS */
	if (poste < 6) {
		var p_pc=40*poste;
	}
	else if (poste < 11) {
		var p_pc=200+(35*(poste-5));
	}
	else if (poste < 16) {
		var p_pc=375+(30*(poste-10));
	}
	else if (poste < 21) {
		var p_pc=525+(25*(poste-15));
	}
	else if (poste > 20) {
		var p_pc=625+(20*(poste-20));
	}
	/* CALCUL DU PRIX SERVER */
	var p_server = 80*server;
	/* CALCUL DU PRIX MOBILE */
	var p_mobile = 0*mobile;
	/* CALCUL DU PRIX PRINTER */
	var p_printer = 0*printer;
	/* CALCUL DU TOTAL */
	var p_tot = (p_pc + p_server + p_mobile + p_printer)*multiplier;
	document.getElementById("prix_contrat").value = p_tot;
}

function calc_price_m() {
	var pc = document.getElementById('nbr_pc_m').value;
	var notebook = document.getElementById('nbr_laptop_m').value;
	var server = document.getElementById('nbr_server_m').value;
	var mobile = document.getElementById('nbr_mobile_m').value;
	var printer = document.getElementById('nbr_printer_m').value;
	/* ON REGROUPE LES POSTE DE TRAVAIL (PC + LAPTOP)*/
	var pc = pc*1;
	var notebook = notebook*1;	
	var poste = pc + notebook;
	
	/* CALCUL DU PRIX MAINTENANCE */
	var fact_m = document.getElementById('facturation_m').value;
	if (fact_m == 'men') {
		var multiplier_m = 1;
	}
	else if (fact_m == 'tri') {
		var multiplier_m = 3;
	}
	else if (fact_m == 'sem') {
		var multiplier_m = 6;
	}
	else if (fact_m == 'ann') {
		var multiplier_m = 12;
	}
	/* CALCUL DU PRIX POSTES DE TRAVAILS */
	var m_poste = 5*poste;
	/* CALCUL DU PRIX SERVER */
	var m_server = 30*server;
	/* CALCUL DU PRIX MOBILE */
	var m_mobile = 0*mobile;
	/* CALCUL DU PRIX PRINTER */
	var m_printer = 0*printer;
	/* CALCUL DU TOTAL */
	var m_tot = (m_printer + m_mobile + m_server + m_poste)*multiplier_m;
	document.getElementById("prix_m").value = m_tot;
}

function add_compos(type, id_parc) {
	nocache = Math.random();
	http.open('get', 'include/form/add_compos_parc.php?type='+type+'&parc='+id_parc+'&nocache='+nocache);
	http.onreadystatechange = function() { refresh_parc(id_parc) };
	http.send(null);
}

function sub_compos(type, id_parc) {
	nocache = Math.random();
	http.open('get', 'include/form/sub_compos_parc.php?type='+type+'&parc='+id_parc+'&nocache='+nocache);
	http.onreadystatechange = function() { refresh_parc(id_parc) };
	http.send(null);
}

function refresh_parc(id) {
		var response = http.responseText;
		nocache = Math.random();
		http.open('get', 'include/ajax/refresh_parc.php?id='+id+'&nocache='+nocache);
		http.onreadystatechange = function() { rep_refresh_parc(id) };
		http.send(null);
}

function rep_refresh_parc(id) {
	if(http.readyState == 4){	
		var response = http.responseText;
		e = document.getElementById('parc');	
		if(response!=""){
			e.innerHTML=response;
			$('.autosubmit').ajaxForm(function() { 
				refresh_parc(id); 
			}); 
		}	
	}
}