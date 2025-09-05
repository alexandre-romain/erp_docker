<?php 
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/language/".$lang.".php");
include_once("include/utils.php");
include_once("include/headers.php");
include_once("include/finhead.php");			
include_once("include/head.php");
?>
<style type="text/css" media="screen">
	@import "";

</style> 
<!-- Import des javascripts -->
<script type="text/javascript" src="include/js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="include/js/highcharts.js"></script>
<script type="text/javascript" src="include/js/modules/exporting.js"></script>

<?php
//ON récupère la date du jours
$date_day=date('Y-m-d');
//On récupère la date d'il y a un mois, pour la condition BETWEEN de la req sql
$date_30day_ago=date('Y-m-d',strtotime('-1 month'));
//On récupère la date d'il y a 1 an, pour la condition BETWEEN de la req sql
$date_1year_ago=date('Y-m-d',strtotime('-1 year'));

//Requete Nbre de Lead Corentin (1mois)
$sql="SELECT l.rowid";
$sql.=" FROM ".$tblpref."lead as l";
$sql.=" WHERE (DATE(date) BETWEEN DATE ('".$date_30day_ago."') AND DATE('".$date_day."')) AND fk_user='corentin'";
$resql=mysql_query($sql);
$num_30d_corentin =mysql_num_rows($resql);
//Requete Nbre de Lead Corentin (1an)
$sql="SELECT l.rowid";
$sql.=" FROM ".$tblpref."lead as l";
$sql.=" WHERE (DATE(date) BETWEEN DATE ('".$date_1year_ago."') AND DATE('".$date_day."')) AND fk_user='corentin'";
$resql=mysql_query($sql);
$num_1y_corentin =mysql_num_rows($resql);

//Requete Nbre de Lead Jeremy (1mois)
$sql="SELECT l.rowid";
$sql.=" FROM ".$tblpref."lead as l";
$sql.=" WHERE (DATE(date) BETWEEN DATE ('".$date_30day_ago."') AND DATE('".$date_day."')) AND fk_user='jeremy'";
$resql=mysql_query($sql);
$num_30d_jeremy =mysql_num_rows($resql);
//Requete Nbre de Lead Jeremy (1an)
$sql="SELECT l.rowid";
$sql.=" FROM ".$tblpref."lead as l";
$sql.=" WHERE (DATE(date) BETWEEN DATE ('".$date_1year_ago."') AND DATE('".$date_day."')) AND fk_user='jeremy'";
$resql=mysql_query($sql);
$num_1y_jeremy =mysql_num_rows($resql);

//Requete Nbre de Lead Renaud (1mois)
$sql="SELECT l.rowid";
$sql.=" FROM ".$tblpref."lead as l";
$sql.=" WHERE (DATE(date) BETWEEN DATE ('".$date_30day_ago."') AND DATE('".$date_day."')) AND fk_user='renaud'";
$resql=mysql_query($sql);
$num_30d_renaud =mysql_num_rows($resql);
//Requete Nbre de Lead Renaud (1an)
$sql="SELECT l.rowid";
$sql.=" FROM ".$tblpref."lead as l";
$sql.=" WHERE (DATE(date) BETWEEN DATE ('".$date_1year_ago."') AND DATE('".$date_day."')) AND fk_user='renaud'";
$resql=mysql_query($sql);
$num_1y_renaud =mysql_num_rows($resql);

//Requete Nbre de Lead Alex (1mois)
$sql="SELECT l.rowid";
$sql.=" FROM ".$tblpref."lead as l";
$sql.=" WHERE (DATE(date) BETWEEN DATE ('".$date_30day_ago."') AND DATE('".$date_day."')) AND fk_user='alex'";
$resql=mysql_query($sql);
$num_30d_alex =mysql_num_rows($resql);
//Requete Nbre de Lead Alex (1an)
$sql="SELECT l.rowid";
$sql.=" FROM ".$tblpref."lead as l";
$sql.=" WHERE (DATE(date) BETWEEN DATE ('".$date_1year_ago."') AND DATE('".$date_day."')) AND fk_user='alex'";
$resql=mysql_query($sql);
$num_1y_alex =mysql_num_rows($resql);

//Requete Nbre de Lead Chris (1mois)
$sql="SELECT l.rowid";
$sql.=" FROM ".$tblpref."lead as l";
$sql.=" WHERE (DATE(date) BETWEEN DATE ('".$date_30day_ago."') AND DATE('".$date_day."')) AND fk_user='christophe'";
$resql=mysql_query($sql);
$num_30d_christophe =mysql_num_rows($resql);
//Requete Nbre de Lead Chris (1an)
$sql="SELECT l.rowid";
$sql.=" FROM ".$tblpref."lead as l";
$sql.=" WHERE (DATE(date) BETWEEN DATE ('".$date_1year_ago."') AND DATE('".$date_day."')) AND fk_user='christophe'";
$resql=mysql_query($sql);
$num_1y_christophe =mysql_num_rows($resql);



?>
<head>
<!--Fonction du graphique-->
<script type="text/javascript">
$(function () {
	$('#container').highcharts({
		chart: {
			type: 'column'
		},
		title: {
			text: 'Nombres de Lead par personne'
		},
		subtitle: {
			text: 'Source: BDD des leads FastIT'
		},
		xAxis: {
			categories: [
				'Corentin',
				'Jeremy',
				'Renaud',
				'Alex',
				'Christophe',
			]
		},
		yAxis: {
			min: 0,
			title: {
				text: 'Nombre de Leads'
			}
		},
		tooltip: {
			headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
			pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
				'<td style="padding:0"><b>{point.y:.1f} Lead(s)</b></td></tr>',
			footerFormat: '</table>',
			shared: true,
			useHTML: true
		},
		plotOptions: {
			column: {
				pointPadding: 0.1,
				borderWidth: 0
			}
		},
		series: [{
			name: 'Mois en cours',
			data: [
				   <?php echo $num_30d_corentin; //Corentin?>
				   ,
				   <?php echo $num_30d_jeremy; //Jeremy?>
				   ,
				   <?php echo $num_30d_renaud; //Renaud?>
				   ,
				   <?php echo $num_30d_alex; //Alex?>
				   , 
				   <?php echo $num_30d_christophe; //Christophe?>
				   ]

		}, {
			name: 'Annee en cours',
			data: [
				   <?php echo $num_1y_corentin; //Corentin?>
				   , 
				   <?php echo $num_1y_jeremy; //Jerem?>
				   ,
				   <?php echo $num_1y_renaud; //Renaud?>
				   ,
				   <?php echo $num_1y_alex; //Alex?>
				   ,
				   <?php echo $num_1y_christophe; //Christophe?>
				   ]

		}]
	});
});
</script>
</head>
<body>
<br />
<br />
<!--Div dans lequel s'affiche le graphique-->
<div id="container" style="min-width: 310px; height: 800px; margin: 0 auto"></div>
</body>

   