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
var http2 = createObject();


/*function add_serial(qty, art_id, num) {
	nocache = Math.random();
	var recu = document.getElementById("recu["+num+"]").value; 																			//On r�cup�re la valeur du select de la ligne.
		//alert(recu);
	if (recu == 'oui') {
		http.open('get', 'include/ajax/received_done.php?recu='+recu+'&num='+num+'&art_id='+art_id+'&qty='+qty+'&nocache='+nocache); 	//On appelle le code permettant de passer la ligne a re�u et on lui passe les arguments n�cessaires
		http.send(null); 																												//On ex�cute le code charg� pr�cedement																					
		http2.open('get', 'include/ajax/serials.php?qty='+qty+'&num='+num+'&art_id='+art_id+'&nocache='+nocache); 						//On appelle le code, qui va permettre d'injecter le formulaire "serials" 
		http2.onreadystatechange = rep_serial;
		http2.send(null);	
	}
}

function rep_serial() {
	if(http2.readyState == 4){		
		var response = http2.responseText;				//On place la r�ponse dans la variable.
		e = document.getElementById('content');			//On r�cup�re l'�lement ou la r�ponse devra �tre ins�r�e.
		if(response!=""){								
			e.innerHTML=response;						//Si la r�ponse n'est pas vide, on l'injecte dans l'�l�ment d�sign� ci-dessus.
		}
		$("#overlay").show(); 							//On affiche l'overlay pour force l'user � interagir avec la modale.
		$("#modal").show();								//On affiche la modale.
	}
}*/

function commande_ok(id) {
	var etat = document.getElementById("commander_"+id).value;
	if (etat == 'oui') {
		document.getElementById("empl_com_"+id).innerHTML='<span style="font-size:13px;color:#3ac836;font-weight:bold;">oui</span>';
	}
	else {
		return;
	}
}

function recu_ok(id) {
	var etat = document.getElementById("recu_"+id).value;
	if (etat == 'oui') {
		document.getElementById("empl_rec_"+id).innerHTML='<span style="font-size:13px;color:#3ac836;font-weight:bold;">oui</span>';
	}
	else {
		return;
	}
}