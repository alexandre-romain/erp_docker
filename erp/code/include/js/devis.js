// JavaScript Document
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
//On passe la focntion dans la variable
var http = createObject();

/* FONCTION PERMETTANT DE RECHERCHER DES ARTICLES PAR CAT DANS LES DEVIS PREDEFINIS */

function filter_article(id_rech, id_cible) {
	nocache = Math.random();
	var rech = document.getElementById(id_rech).value;
	if (rech != "") {
		http.open('get', 'include/ajax/devis_filter_articles.php?rech='+rech+'&id_rech='+id_rech+'&nocache='+nocache);
		http.onreadystatechange = function() { rep_filter_article(id_cible) };
		http.send(null);
	}
}

function filter_article_inline(id_cible) {
	nocache = Math.random();
	var id_rech = document.getElementById("type_add_cont").value;
	var rech = document.getElementById("rech_add_cont").value;
	http.open('get', 'include/ajax/devis_filter_articles.php?rech='+rech+'&id_rech='+id_rech+'&nocache='+nocache);
	http.onreadystatechange = function() { rep_filter_article(id_cible) };
	http.send(null);
}

function rep_filter_article(id_cible) {
	if(http.readyState == 4){
		var response = http.responseText;
		e = document.getElementById(id_cible);
		if(response!=""){
			e.innerHTML=response;
		}
	}
}

function actualiser_parametres() {
	nocache = Math.random();
	http.open('get', 'include/ajax/actualiser_param_devis.php?nocache='+nocache);
	http.onreadystatechange = function() { rep_actualiser_parametres() };
	http.send(null);
}

function rep_actualiser_parametres() {
	if(http.readyState == 4){
		var response = http.responseText;
		e = document.getElementById("param");
		if(response!=""){
			e.innerHTML=response;
			$('.autosubmit').ajaxForm(function() { 
				actualiser_parametres();
			});
		}
	}
}

function add_element(nom, cible, value_e) {
	nocache = Math.random();
	var article=document.getElementById(value_e).value;
	http.open('get', 'include/ajax/add_element_devis.php?article='+article+'&nom='+nom+'&cible='+cible+'&nocache='+nocache);
	http.onreadystatechange = function() { rep_add_element(cible) };
	http.send(null);
}

function rep_add_element(cible) {
	if(http.readyState == 4){
		var response = http.responseText;
		e = document.getElementById(cible);
		if(response!=""){
			e.innerHTML+=response;
		}
	}
}

function del_element(id, id_parent) {
	var parent = document.getElementById(id_parent);
	var child = document.getElementById(id);
	parent.removeChild(child);
}

function det_devis_predef(id) {
	nocache = Math.random();
	http.open('get', 'include/ajax/det_devis_predef.php?id='+id+'&nocache='+nocache);
	http.onreadystatechange = function() { rep_det_devis_predef(id) };
	http.send(null);
}

function rep_det_devis_predef(id) {
	if(http.readyState == 4){
		var response = http.responseText;
		e = document.getElementById('cont_details'+id);
		if(response!=""){
			e.innerHTML=response;
			$('.autosubmit_list').ajaxForm(function() { 
				det_devis_predef(id);
			});
			$('.edit').editable('include/ajax/jeditable_cont_dev_predef.php?id_dev='+id, {
				width : '50px',
				height : '20px',
			});
		}
	}
}

function attrib_dev_predef(id) {
	nocache = Math.random();
	http.open('get', 'include/ajax/attrib_devis.php?id='+id+'&nocache='+nocache);
	http.onreadystatechange = function() { rep_attrib_dev_predef(id) };
	http.send(null);
}

function rep_attrib_dev_predef(id) {
	if(http.readyState == 4){
		var response = http.responseText;
		e = document.getElementById('content_modale');
		if(response!=""){
			e.innerHTML=response;
		}
	}
}

function test(test) {
	alert(test);
}

function test2() {
	alert('call');
}
