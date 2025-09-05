// JavaScript Document
/*function showinfoticket() {
	nocache = Math.random();
	var newexist = document.getElementById("new_or_existing").value; //Renvoi 0 si ticket existant, 1 si nouveau
	var cli = document.getElementById("listeville").value;
	http.open('get', 'include/ajax/showinfoticket.php?newexist='+newexist+'&cli='+cli+'&nocache='+nocache);
	http.onreadystatechange = showrepticket;
	http.send(null);
}
function showrepticket() {
	if(http.readyState == 4){
	
		var response = http.responseText;
		e = document.getElementById('infoticket');
	
		if(response!=""){

			/*e.innerHTML=response;
			e.style.display="block";
			ro.style.display="none";*/
			/*e.innerHTML=response;
			$(function() {
				$( "#date_due_ticket" ).datepicker({
											changeMonth: true,
											changeYear: true,
											dateFormat: "dd-mm-yy" })
			});
		}
	}
}*/
function showinfoclient() {
	nocache = Math.random();
	var cli = document.getElementById("listeville").value;
	http.open('get', 'include/ajax/showinfoclient.php?cli='+cli+'&nocache='+nocache);
	http.onreadystatechange = showrepclient;
	http.send(null);
}
function showrepclient() {
	if(http.readyState == 4){
	
		var response = http.responseText;
		e = document.getElementById('infoclient');
		var cli = document.getElementById("listeville").value;
		if(response!=""){

			/*e.innerHTML=response;
			e.style.display="block";
			ro.style.display="none";*/
			e.innerHTML=response;
			$(function() {
				$('.edit_name').editable('./include/ajax/Edit_cli.php?num_cli='+cli, {
					 data    : function(string) {return $.trim(string)},
					 tooltip   : 'Cliquez pour modifier...'
				 });
				$('.edit_mail').editable('./include/ajax/Edit_cli.php?num_cli='+cli, {
					 data    : function(string) {return $.trim(string)},
					 tooltip   : 'Cliquez pour modifier...'
				 });
				$('.edit_tel').editable('./include/ajax/Edit_cli.php?num_cli='+cli, {
					 data    : function(string) {return $.trim(string)},
					 tooltip   : 'Cliquez pour modifier...'
				 });
				$('.edit_gsm').editable('./include/ajax/Edit_cli.php?num_cli='+cli, {
					 data    : function(string) {return $.trim(string)},
					 tooltip   : 'Cliquez pour modifier...'
				 });
				$('.edit_tva').editable('./include/ajax/Edit_cli.php?num_cli='+cli, {
					 data    : function(string) {return $.trim(string)},
					 tooltip   : 'Cliquez pour modifier...'
				 });
				$('.edit_rue').editable('./include/ajax/Edit_cli.php?num_cli='+cli, {
					 data    : function(string) {return $.trim(string)},
					 tooltip   : 'Cliquez pour modifier...'
				 });
				$('.edit_numero').editable('./include/ajax/Edit_cli.php?num_cli='+cli, {
					 data    : function(string) {return $.trim(string)},
					 tooltip   : 'Cliquez pour modifier...'
				 });
				$('.edit_boite').editable('./include/ajax/Edit_cli.php?num_cli='+cli, {
					 data    : function(string) {return $.trim(string)},
					 tooltip   : 'Cliquez pour modifier...'
				 });
				$('.edit_cp').editable('./include/ajax/Edit_cli.php?num_cli='+cli, {
					 data    : function(string) {return $.trim(string)},
					 tooltip   : 'Cliquez pour modifier...'
				 });
				$('.edit_ville').editable('./include/ajax/Edit_cli.php?num_cli='+cli, {
					 data    : function(string) {return $.trim(string)},
					 tooltip   : 'Cliquez pour modifier...'
				 });
			});
		}
	
	}
}

/*function showmoretask() {
	nocache = Math.random();
	var statetask = document.getElementById("state_task").value; //Renvoi 0 si ticket existant, 1 si nouveau
	http.open('get', 'include/ajax/showmoretask.php?statetask='+statetask+'&nocache = '+nocache);
	http.onreadystatechange = showreptask;
	http.send(null);
}
function showreptask() {
	if(http.readyState == 4){
	
		var response = http.responseText;
		e = document.getElementById('infotask');
	
		if(response!=""){

			/*e.innerHTML=response;
			e.style.display="block";
			ro.style.display="none";*/
			/*e.innerHTML=response;
						$(function() {
			$( "#date_due_task" ).datepicker({
										changeMonth: true,
										changeYear: true,
										dateFormat: "dd-mm-yy" })
			});
		}
	
	}
}*/

/*function showmoretask2() {
	nocache = Math.random();
	var statetask = document.getElementById("state_task2").value; //Renvoi 0 si ticket existant, 1 si nouveau
	http.open('get', 'include/ajax/showmoretask2.php?statetask='+statetask+'&nocache = '+nocache);
	http.onreadystatechange = showreptask2;
	http.send(null);
}
function showreptask2() {
	if(http.readyState == 4){
	
		var response = http.responseText;
		e = document.getElementById('infotask2');
	
		if(response!=""){

			/*e.innerHTML=response;
			e.style.display="block";
			ro.style.display="none";*/
			/*e.innerHTML=response;
						$(function() {
			$( "#date_due_task2" ).datepicker({
										changeMonth: true,
										changeYear: true,
										dateFormat: "dd-mm-yy" })
			});
		}
	
	}
}*/

function check_state() {
	var statetask = document.getElementById("state_task").value;
	e = document.getElementById('worktime_place');
	if (statetask == 1) {
		e.innerHTML='<tr><td class="right">Temps de travail :</td><td class="left"><input type="text" size="4" id="time_spent_hours" name="time_spent_hours" value="00" class="styled" style="width:10%"> : <input type="text" size="4" id="time_spent_min" name="time_spent_min" value="00" class="styled" style="width:10%"></td></tr>';
	}
	else {
		e.innerHTML='';
	}
}

function check_end(num) {
	e = document.getElementById('time'+num);
	if (document.getElementById('task_terminate_'+num).checked) {
		e.innerHTML='<input type="text" size="4" id="time_spent_hours" name="task['+num+'][hours_spent]" value="00" class="styled" style="width:20%"> : <input type="text" size="4" id="time_spent_min" name="task['+num+'][min_spent]" value="00" class="styled" style="width:20%">';
	} else {
		e.innerHTML='';
	}
}

function check_contact() {
	e = document.getElementById('contact_place');
	if (document.getElementById('contact').checked) {
		e.innerHTML='<tr><td class="right">Nom du contact :</td><td class="left"><input type="text" name="nom_contact" class="styled"></td></tr><tr><td class="right">Pr&eacute;nom du contact :</td><td class="left"><input type="text" name="prenom_contact" class="styled"></td></tr><tr><td class="right">E-mail du contact :</td><td class="left"><input type="text" name="mail_contact" class="styled"></td></tr><tr><td class="right">T&eacute;l&eacute;phone du contact :</td><td class="left"><input type="text" name="tel_contact" class="styled"></td></tr>';
	} else {
		e.innerHTML='';
	}
}