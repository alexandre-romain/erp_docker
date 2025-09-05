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
/* FONCTION PERMETTANT D'AFFICHE LE DETAILS DES DEVELLOPEMENT dans journal_dev.php */
function showdet_dev(num) {
	nocache = Math.random();
	http.open('get', 'include/ajax/details_dev.php?num='+num+'&nocache = '+nocache);
	http.onreadystatechange = function() { repshowdet_dev(num) };
	http.send(null);	
}
function repshowdet_dev(num) {
	if(http.readyState == 4){		
		var response = http.responseText;
		e = document.getElementById('det_dev['+num+']');	
		if(response!=""){
			e.innerHTML=response;
		}
	
	}
}
<!--FONCTION PERMETTANT DE FAIRE DISPARAITRE LES DETAILS D'UN DEV-->
function hide_dev(arg) {
		var response = '';
		e = document.getElementById('det_dev['+arg+']');	
		e.innerHTML=response;
}
<!--FONCTION SERVANT A AJOUTER UN DETAIL A UN DEV EXISTANT-->
function add_detail(num) {
	nocache = Math.random();
	var nom = document.getElementById('nom_det['+num+']').value;
	var parent = document.getElementById('parent_dev['+num+']').value;
	http.open('get', 'include/ajax/add_det_dev.php?nom='+nom+'&parent='+parent+'&nocache='+nocache);
	http.send(null);
	http.onreadystatechange = function() { showdet_dev(num) };
	//function() { showdet_dev(num) };
}

<!--FONCTION SERVANT A SUPPRIMER UN DETAIL POUR UN DEV EXISTANT-->
function del_det_dev(arg, num_parent) {
	nocache = Math.random();
	http.open('get', 'include/ajax/Delete_dev_det.php?num='+arg+'&nocache='+nocache);
	http.send(null);
	http.onreadystatechange = function() { showdet_dev(num_parent) };
}

<!--FONCTION SERVANT A EDITER L'ETAT DES DETAILS DES DEVS-->
function edit_state_det_dev(arg, num_parent) {
	nocache = Math.random();
	var state = document.getElementById('state_det_dev['+arg+']').value;
	http.open('get', 'include/ajax/Update_det_dev.php?num='+arg+'&state='+state+'&nocache='+nocache);
	http.send(null);
	http.onreadystatechange = function() { showdet_dev(num_parent) };
}