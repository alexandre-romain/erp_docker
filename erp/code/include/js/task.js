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

function createObject2() {
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
var http2 = createObject2();

/* Fonction permettant de définir le onload ie/autres navigateurs */
function addEvent(obj, event, fct) {
    if (obj.attachEvent) //Est-ce IE ?
        obj.attachEvent("on" + event, fct); //Ne pas oublier le "on"
    else
        obj.addEventListener(event, fct, true);
}

function lancer() {
    addEvent(window, "load", fct);
}

/* Fonction permettant de peupler le select du nombre d'articles a lier (via bon comm.) */
function nbr_articles() {
	//alert ('Je rentre');
	nocache = Math.random();
	var article = document.getElementById("articles").value; 													//On récupère l'id du cont_bon sélectionné
	http2.open('get', 'include/ajax/autocomplete_nbr_article_task.php?article='+article+'&nocache='+nocache); 	//On appelle le code permettant de construire le select en fonction de la qty d'articles dans cont_bon
	//alert ('J\'ai traite')
	http2.onreadystatechange = rep_nbr_articles;
	http2.send(null);	
}
/* Réponse de la fonction précedente */
function rep_nbr_articles() {
	//alert ('Je rentre reponse')
	if(http2.readyState == 4){		
		var response = http2.responseText;				//On place la réponse dans la variable.
		e = document.getElementById('nbr_articles');	//On récupère l'élement ou la réponse devra être insérée.
		if(response!=""){								
			e.innerHTML=response;						//Si la réponse n'est pas vide, on l'injecte dans l'élément désigné ci-dessus.
		}
	}
}

/* Fonction permettant de peupler le select du nombre d'articles a lier (articles de stock Fastit) */
function nbr_articles_stock() {
	//alert ('Je rentre');
	nocache = Math.random();
	var article = document.getElementById("articles_stock").value; 													//On récupère l'id du cont_bon sélectionné
	http.open('get', 'include/ajax/autocomplete_nbr_article_stock_task.php?article='+article+'&nocache='+nocache); 	//On appelle le code permettant de construire le select en fonction de la qty d'articles dans cont_bon
	//alert ('J\'ai traite')
	http.onreadystatechange = rep_nbr_articles_stock;
	http.send(null);	
}
/* Réponse de la fonction précedente */
function rep_nbr_articles_stock() {
	//alert ('Je rentre reponse')
	if(http.readyState == 4){		
		var response = http.responseText;					//On place la réponse dans la variable.
		e = document.getElementById('nbr_articles_stock');	//On récupère l'élement ou la réponse devra être insérée.
		if(response!=""){								
			e.innerHTML=response;							//Si la réponse n'est pas vide, on l'injecte dans l'élément désigné ci-dessus.
		}
	}
}

/* Fonction permettant de lier les articles à la tâche (articles FROM BON COMM.) */
function add_article_com() {
	//alert ('Je rentre');
	nocache = Math.random();
	var article = document.getElementById("articles").value; 		//On récupère l'id du cont_bon sélectionné
	var nbr = document.getElementById("nbr_articles").value; 		//On récupère le nombre d'articles à lier
	var num_task = document.getElementById("num_task").value; 		//On récupère l'is de la task
	http.open('get', 'include/ajax/AddArticle_Com_To_task.php?article='+article+'&nbr='+nbr+'&num_task='+num_task+'&nocache='+nocache); 	//On appelle le code permettant de construire le select en fonction de la qty d'articles dans cont_bon
	//alert ('J\'ai traite')
	http.onreadystatechange = function() { recharger() };
	http.send(null);
}

/* Fonction permettant de lier les articles à la tâche (articles FROM STOCKS.) */
function add_article_stock() {
	//alert ('Je rentre');
	nocache = Math.random();
	var article = document.getElementById("articles_stock").value; 		//On récupère l'id du cont_bon sélectionné
	var nbr = document.getElementById("nbr_articles_stock").value; 		//On récupère le nombre d'articles à lier
	var num_task = document.getElementById("num_task").value; 		//On récupère l'is de la task
	http.open('get', 'include/ajax/AddArticle_Stock_To_task.php?article='+article+'&nbr='+nbr+'&num_task='+num_task+'&nocache='+nocache); 	//On appelle le code permettant de construire le select en fonction de la qty d'articles dans cont_bon
	//alert ('J\'ai traite')
	http.onreadystatechange = function() { recharger() };
	http.send(null);	
}

function recharger() {
	window.location.reload(); 
}