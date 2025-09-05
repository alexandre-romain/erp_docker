// JavaScript Document
function showcontrat() {
	nocache = Math.random();
	var cli = document.getElementById("soc").value;
	http.open('get', 'include/ajax/showcontrat.php?cli='+cli+'&nocache = '+nocache);
	http.onreadystatechange = showrep;
	http.send(null);
}

function showrep() {
	if(http.readyState == 4){
	
		var response = http.responseText;
		e = document.getElementById('infoparc');
	
		if(response!=""){

			/*e.innerHTML=response;
			e.style.display="block";
			ro.style.display="none";*/
			e.innerHTML=response;
			$(function() {
				$( "#date_debut" ).datepicker({
											changeMonth: true,
											changeYear: true,
											dateFormat: "dd-mm-yy" })
				$( "#date_fin" ).datepicker({
											changeMonth: true,
											changeYear: true,
											dateFormat: "dd-mm-yy" })
			});
		}
	
}
}