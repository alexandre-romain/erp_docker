<?php
//Contient le doctype + inclusions générales
include_once("include/headers.php");
//Récupération du temps de travail pour les utilisateurs actifs.
$sql ="SELECT * FROM ".$tblpref."user";
$sql.=" WHERE actif = '1'";
$req=mysql_query($sql);
$i=0;
while ($obj=mysql_fetch_object($req)) {
	//Temps GLOBAL
	$users[$i][name]=$obj->prenom[0].'. '.$obj->nom;
	$users[$i][id]=$obj->num;
	$sql_time="SELECT TIME_TO_SEC(t.time_spent) as sectimespent, TIME_TO_SEC(t.time_fact) as sectimefact";
	$sql_time.=" FROM ".$tblpref."task as t";
	$sql_time.=" WHERE t.user_intervenant='".$obj->num."'";
	$req_time=mysql_query($sql_time);
	$users[$i][timespent]=0;
	while ($obj_time=mysql_fetch_object($req_time)) {
		$users[$i][timespent]+=$obj_time->sectimespent*1000; // *1000 pour convertion en millisecondes
	}
	//TEMPS FACTURE
	$sql_time="SELECT TIME_TO_SEC(t.time_spent) as sectimespent, TIME_TO_SEC(t.time_fact) as sectimefact";
	$sql_time.=" FROM ".$tblpref."task as t";
	$sql_time.=" WHERE t.user_intervenant='".$obj->num."' AND t.fact_num != 'ABONNEMENT' AND t.fact_num != 'PURGE' AND facture = 'ok'";
	$req_time=mysql_query($sql_time);
	$users[$i][timenonfact]=0;
	$users[$i][timefact]=0;
	while ($obj_time=mysql_fetch_object($req_time)) {
		$users[$i][timefact]+=$obj_time->sectimefact*1000;
		
	}
	//TEMPS ABONNEMENT
	$sql_time="SELECT TIME_TO_SEC(t.time_spent) as sectimespent, TIME_TO_SEC(t.time_fact) as sectimefact";
	$sql_time.=" FROM ".$tblpref."task as t";
	$sql_time.=" WHERE t.user_intervenant='".$obj->num."' AND fact_num = 'ABONNEMENT'";
	$req_time=mysql_query($sql_time);
	$users[$i][timeabo]=0;
	while ($obj_time=mysql_fetch_object($req_time)) {
		$users[$i][timeabo]+=$obj_time->sectimespent*1000; // *1000 pour convertion en millisecondes
	}
	//TEMPS PURGE
	$sql_time="SELECT TIME_TO_SEC(t.time_spent) as sectimespent, TIME_TO_SEC(t.time_fact) as sectimefact";
	$sql_time.=" FROM ".$tblpref."task as t";
	$sql_time.=" WHERE t.user_intervenant='".$obj->num."' AND fact_num = 'PURGE'";
	$req_time=mysql_query($sql_time);
	$users[$i][timepurge]=0;
	while ($obj_time=mysql_fetch_object($req_time)) {
		$users[$i][timepurge]+=$obj_time->sectimespent*1000; // *1000 pour convertion en millisecondes
	}
	//TEMPS NON FACTURE
	$users[$i][timenonfact]=$users[$i][timespent]-$users[$i][timefact]-$users[$i][timeabo]-$users[$i][timepurge];
	$i++;
}
?>
<!--INCLUSION JS, CSS, LIBRAIRIES PROPRES A LA PAGE-->
<script type="text/javascript" src="include/js/highcharts.js"></script>
<script type="text/javascript" src="include/js/modules/exporting.js"></script>
<script>
$(document).ready(function() {
	$("#show_stat").hide();
	$("#hide_stat").click(function(){
		$("#stat").hide(500);	
		$("#hide_stat").hide();
		$("#show_stat").show();
	});
	$("#show_stat").click(function(){
		$("#stat").show(500);	
		$("#hide_stat").show();
		$("#show_stat").hide();
	});
});
<!-- STATS TEMPS DE TRAVAIL -->
function conversion_seconde_heure(time) {
	var reste=time/1000;
	var result='';
	var nbHours=Math.floor(reste/3600);
	reste -= nbHours*3600;
	var nbMinutes=Math.floor(reste/60);
	reste -= nbMinutes*60;
	var nbSeconds=reste;
	if (nbHours>0)
		result=result+nbHours+'h ';
	if (nbMinutes>0)
		result=result+nbMinutes+'min ';
	if (nbSeconds>0)
		result=result+nbSeconds+'s ';
	return result;
}
$(function () {
    $('#container_new').highcharts({
		chart: {
			type: 'column'
		},
		title: {
			text: ''
		},
		xAxis: {
			categories: [
				<?php
				foreach ($users as $user) {
					echo '"'.$user['name'].'", ';
				}
				?>
			],
		},
		yAxis: {
			title: {
                text: 'Temps de travail (HH:mm)'
            },
			tickInterval: 3600 * 1000 * 10,
            labels: {
                formatter: function () {
                    var time = this.value;
                    var hours1=parseInt(time/3600000);
                    var mins1=parseInt((parseInt(time%3600000))/60000);
                    return hours1 + ':' + mins1+'0';
                }
            }
		},
		tooltip: {
            formatter: function () {
                return '<b>' + this.x + '</b><br/>' +
                    this.series.name + ': ' + conversion_seconde_heure(this.y);
            }
        },
		series: [{
				name: 'Facturé',
				data: [<?php foreach ($users as $user) { echo $user['timefact'].', ';}?>]
			}, {
				name: 'Abo',
				data: [<?php foreach ($users as $user) { echo $user['timeabo'].', ';}?>]
			},{
				name: 'Purge',
				data: [<?php foreach ($users as $user) { echo $user['timepurge'].', ';}?>]
			}, {
				name: 'Non-facturé',
				data: [<?php foreach ($users as $user) { echo $user['timenonfact'].', ';}?>]
			},{
				name: 'Total',
				data:[<?php foreach ($users as $user) { echo $user['timespent'].', ';}?>]
			}]
	});
});

</script>
<?php 
//Ferme le <head>, ouvre le <body> & inclus le menu + ouverture content
include_once("include/finhead.php");
//Gestion des messages informatifs
include_once("include/message_info.php");
?>
<!--STATS-->
<div class="portion">
    <!-- TITRE - STATS -->
    <div class="choice_action">
        <span class="fa-stack fa-lg">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-pie-chart fa-stack-1x"></i>
        </span>
        Statistiques temps de travail Factur&eacute; / Non-factur&eacute; / Total par utilisateur
        <span class="fa-stack fa-lg add" style="float:right" id="show_stat">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-down fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg del" style="float:right" id="hide_stat">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-chevron-up fa-stack-1x" id="show_list_dev"></i>
        </span>
        <span class="fa-stack fa-lg action" style="float:right">
          <i class="fa fa-square-o fa-stack-2x"></i>
          <i class="fa fa-info fa-stack-1x"></i>
        </span>
    </div>
    <!-- CONTENT - STATS -->
    <div class="content_traitement" id="stat">
    	
        <!--Div dans lequel s'affiche le graphique-->
        <div id="container_new" style="height: 70%; margin: 0 auto;width:100%;"></div>
	</div>
</div>
<?php
//Ferme le <body> + <html> & inclusions de JS
include_once("include/elements/footer.php");
?>