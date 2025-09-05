// JavaScript Document
function showprice() {
	nocache = Math.random();
	var cli = document.getElementById("fk_product").value;
	http.open('get', '../include/ajax/autocomplete_price.php?cli='+cli+'&nocache = '+nocache);
	http.onreadystatechange = showrep;
	http.send(null);
}

function showrep() {
	if(http.readyState == 4){
	
		var response = http.responseText;
		e = document.getElementById('div_price');
	
		if(response!=""){

			/*e.innerHTML=response;
			e.style.display="block";
			ro.style.display="none";*/
			e.innerHTML=response;
		}
	
}
}