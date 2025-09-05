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
//On place la date du jour dans une variable
$date_day=date('Y-m-d');

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//REQUESTS 30 DERNIERS JOURS
//
//On récupère la date d'il y a 30 jours, pour la condition BETWEEN de la req sql
$date_30day_ago=date('Y-m-d',strtotime('-1 month'));
//Request de récupération des infos de time_fact pour les 30 derniers Jours
$sql="SELECT TIME_TO_SEC(time_fact) as sectime_fact";
$sql.=" FROM ".$tblpref."inter";
$sql.=" WHERE DATE(date_debut) BETWEEN DATE ('".$date_30day_ago."') AND DATE('".$date_day."')";
//$sql=" AND date_debut > ".$date_day." - interval 30";
$resql=mysql_query($sql);
if ($resql)
{
	$num =mysql_num_rows($resql);
	$i = 0;
	if ($num)
	{
		while ($i < $num)
		{
					$obj_30days =mysql_fetch_object($resql);					
					if ($obj_30days)
					{
						//results
						$timesec_inter_fact_30days=$obj_30days->sectime_fact;
						$timesec_fact_30days=$timesec_fact_30days+$timesec_inter_fact_30days;
					}
			$i++;
		}
	}
}
// On convertit les secondes en HH:mm:ss	
$heures=intval($timesec_fact_30days / 3600);
$minutes=intval(($timesec_fact_30days % 3600) / 60);
$secondes=intval((($timesec_fact_30days % 3600) % 60));
//On reconstruit l'heure
$time_fact_30days=$heures.'.'.$minutes;

//Request de récupération des infos de time_spent pour les 30 derniers Jours
$sqlt = "SELECT TIME_TO_SEC(it.time_spent) as sectime";
$sqlt .= " FROM ".$tblpref."inter_tache as it";
$sqlt .= " LEFT JOIN ".$tblpref."inter as i ON i.rowid = it.fk_inter";
$sqlt .= " WHERE DATE(i.date_debut) BETWEEN DATE ('".$date_30day_ago."') AND DATE('".$date_day."')";
$reqtimesqlt=mysql_query($sqlt);
if ($reqtimesqlt)
{
	$num = mysql_num_rows($reqtimesqlt);
	$i = 0;
	if ($num)
	{
		while ($i < $num)
		{
			$objtimespent_30days = mysql_fetch_object($reqtimesqlt);
			if ($objtimespent_30days)
			{
				$timesec_inter_spent_30days=$objtimespent_30days->sectime;
				$timesec_spent_30days=$$timesec_spent_30days+$timesec_inter_spent_30days;
			}	
			$i++;
		}
	}
}
// On convertit les secondes en HH:mm:ss	
$heures=intval($timesec_spent_30days / 3600);
$minutes=intval(($timesec_spent_30days % 3600) / 60);
$secondes=intval((($timesec_spent_30days % 3600) % 60));
//On reconstruit l'heure
$time_spent_30days=$heures.'.'.$minutes;
//
//FIN REQUESTS 30 DERNIERS JOURS
//

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//REQUESTS DERNIERE ANNEE
//
//On récupère la date d'il y a 1an, pour la condition BETWEEN de la req sql
$date_1year_ago=date('Y-m-d',strtotime('-1 year'));
//Request de récupération des infos de time_fact pour la derniere année
$sql="SELECT TIME_TO_SEC(time_fact) as sectime_fact";
$sql.=" FROM ".$tblpref."inter";
$sql.=" WHERE DATE(date_debut) BETWEEN DATE ('".$date_1year_ago."') AND DATE('".$date_day."')";
$resql=mysql_query($sql);
if ($resql)
{
	$num =mysql_num_rows($resql);
	$i = 0;
	if ($num)
	{
		while ($i < $num)
		{
			$obj =mysql_fetch_object($resql);					
			if ($obj)
			{
				//results
				$timesec_inter_fact_1year=$obj->sectime_fact;
				$timesec_fact_1year=$timesec_fact_1year+$timesec_inter_fact_1year;
			}
			$i++;
		}
	}
}
// On convertit les secondes en HH:mm:ss	
$heures=intval($timesec_fact_1year / 3600);
$minutes=intval(($timesec_fact_1year % 3600) / 60);
$secondes=intval((($timesec_fact_1year % 3600) % 60));
//On reconstruit l'heure
$time_fact_1year=$heures.'.'.$minutes;

//Request de récupération des infos de time_spent pour la derniere année
$sql = "SELECT TIME_TO_SEC(it.time_spent) as sectime";
$sql .= " FROM ".$tblpref."inter_tache as it";
$sql .= " LEFT JOIN ".$tblpref."inter as i ON i.rowid = it.fk_inter";
$sql .= " WHERE DATE(i.date_debut) BETWEEN DATE ('".$date_1year_ago."') AND DATE('".$date_day."')";
$resql=mysql_query($sql);
if ($resql)
{
	$num = mysql_num_rows($resql);
	$i = 0;
	if ($num)
	{
		while ($i < $num)
		{
			$obj = mysql_fetch_object($resql);
			if ($obj)
			{
				$timesec_inter_spent_1year=$obj->sectime;
				$timesec_spent_1year=$timesec_spent_1year+$timesec_inter_spent_1year;
			}	
			$i++;
		}
	}
}
// On convertit les secondes en HH:mm:ss	
$heures=intval($timesec_spent_1year / 3600);
$minutes=intval(($timesec_spent_1year % 3600) / 60);
$secondes=intval((($timesec_spent_1year % 3600) % 60));
//On reconstruit l'heure
$time_spent_1year=$heures.'.'.$minutes;
//
//FIN REQUESTS DERNIERE ANNEE
//

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//REQUESTS TOUT
//
//Request de récupération des infos de time_fact pour tout
$sql="SELECT TIME_TO_SEC(time_fact) as sectime_fact";
$sql.=" FROM ".$tblpref."inter";
$resql=mysql_query($sql);
if ($resql)
{
	$num =mysql_num_rows($resql);
	$i = 0;
	if ($num)
	{
		while ($i < $num)
		{
			$obj =mysql_fetch_object($resql);					
			if ($obj)
			{
				//results
				$timesec_inter_fact_all=$obj->sectime_fact;
				$timesec_fact_all=$timesec_fact_all+$timesec_inter_fact_all;
			}
			$i++;
		}
	}
}
// On convertit les secondes en HH:mm:ss	
$heures=intval($timesec_fact_all / 3600);
$minutes=intval(($timesec_fact_all % 3600) / 60);
$secondes=intval((($timesec_fact_all % 3600) % 60));
//On reconstruit l'heure
$time_fact_all=$heures.'.'.$minutes;

//Request de récupération des infos de time_spent pour tout
$sql = "SELECT TIME_TO_SEC(it.time_spent) as sectime";
$sql .= " FROM ".$tblpref."inter_tache as it";
$resql=mysql_query($sql);
if ($resql)
{
	$num = mysql_num_rows($resql);
	$i = 0;
	if ($num)
	{
		while ($i < $num)
		{
			$obj = mysql_fetch_object($resql);
			if ($obj)
			{
				$timesec_inter_spent_all=$obj->sectime;
				$timesec_spent_all=$timesec_spent_all+$timesec_inter_spent_all;
			}	
			$i++;
		}
	}
}
// On convertit les secondes en HH:mm:ss	
$heures=intval($timesec_spent_all / 3600);
$minutes=intval(($timesec_spent_all % 3600) / 60);
$secondes=intval((($timesec_spent_all % 3600) % 60));
//On reconstruit l'heure
$time_spent_all=$heures.'.'.$minutes;
//
//FIN REQUESTS TOUT
//

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//REQUESTS CORENTIN
//
//Request de récupération des infos de time_fact pour tout
$sql="SELECT TIME_TO_SEC(time_fact) as sectime_fact";
$sql.=" FROM ".$tblpref."inter";
$sql.=" WHERE fk_createur='11' OR fk_technician='11' OR fk_technician2='11'";
$resql=mysql_query($sql);
if ($resql)
{
	$num =mysql_num_rows($resql);
	$i = 0;
	if ($num)
	{
		while ($i < $num)
		{
			$obj =mysql_fetch_object($resql);					
			if ($obj)
			{
				//results
				$timesec_inter_fact_corentin=$obj->sectime_fact;
				$timesec_fact_corentin=$timesec_fact_corentin+$timesec_inter_fact_corentin;
			}
			$i++;
		}
	}
}
// On convertit les secondes en HH:mm:ss	
$heures=intval($timesec_fact_corentin / 3600);
$minutes=intval(($timesec_fact_corentin % 3600) / 60);
$secondes=intval((($timesec_fact_corentin % 3600) % 60));
//On reconstruit l'heure
$time_fact_corentin=$heures.'.'.$minutes;

//Request de récupération des infos de time_spent pour tout
$sql = "SELECT TIME_TO_SEC(it.time_spent) as sectime";
$sql .= " FROM ".$tblpref."inter_tache as it";
$sql .= " LEFT JOIN ".$tblpref."inter as i ON i.rowid = it.fk_inter";
$sql .= " WHERE i.fk_createur='11' OR i.fk_technician='11' OR i.fk_technician2='11'";

$resql=mysql_query($sql);
if ($resql)
{
	$num = mysql_num_rows($resql);
	$i = 0;
	if ($num)
	{
		while ($i < $num)
		{
			$obj = mysql_fetch_object($resql);
			if ($obj)
			{
				$timesec_inter_spent_corentin=$obj->sectime;
				$timesec_spent_corentin=$timesec_spent_corentin+$timesec_inter_spent_corentin;
			}	
			$i++;
		}
	}
}
// On convertit les secondes en HH:mm:ss	
$heures=intval($timesec_spent_corentin / 3600);
$minutes=intval(($timesec_spent_corentin % 3600) / 60);
$secondes=intval((($timesec_spent_corentin % 3600) % 60));
//On reconstruit l'heure
$time_spent_corentin=$heures.'.'.$minutes;
//
//FIN REQUESTS CORENTIN
//

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//REQUESTS JEREM
//
//Request de récupération des infos de time_fact pour tout
$sql="SELECT TIME_TO_SEC(time_fact) as sectime_fact";
$sql.=" FROM ".$tblpref."inter";
$sql.=" WHERE fk_createur='12' OR fk_technician='12' OR fk_technician2='12'";
$resql=mysql_query($sql);
if ($resql)
{
	$num =mysql_num_rows($resql);
	$i = 0;
	if ($num)
	{
		while ($i < $num)
		{
			$obj =mysql_fetch_object($resql);					
			if ($obj)
			{
				//results
				$timesec_inter_fact_jeremy=$obj->sectime_fact;
				$timesec_fact_jeremy=$timesec_fact_jeremy+$timesec_inter_fact_jeremy;
			}
			$i++;
		}
	}
}
// On convertit les secondes en HH:mm:ss	
$heures=intval($timesec_fact_jeremy / 3600);
$minutes=intval(($timesec_fact_jeremy % 3600) / 60);
$secondes=intval((($timesec_fact_jeremy % 3600) % 60));
//On reconstruit l'heure
$time_fact_jeremy=$heures.'.'.$minutes;

//Request de récupération des infos de time_spent pour tout
$sql = "SELECT TIME_TO_SEC(it.time_spent) as sectime";
$sql .= " FROM ".$tblpref."inter_tache as it";
$sql .= " LEFT JOIN ".$tblpref."inter as i ON i.rowid = it.fk_inter";
$sql .= " WHERE i.fk_createur='12' OR i.fk_technician='12' OR i.fk_technician2='12'";

$resql=mysql_query($sql);
if ($resql)
{
	$num = mysql_num_rows($resql);
	$i = 0;
	if ($num)
	{
		while ($i < $num)
		{
			$obj = mysql_fetch_object($resql);
			if ($obj)
			{
				$timesec_inter_spent_jeremy=$obj->sectime;
				$timesec_spent_jeremy=$timesec_spent_jeremy+$timesec_inter_spent_jeremy;
			}	
			$i++;
		}
	}
}
// On convertit les secondes en HH:mm:ss	
$heures=intval($timesec_spent_jeremy / 3600);
$minutes=intval(($timesec_spent_jeremy % 3600) / 60);
$secondes=intval((($timesec_spent_jeremy % 3600) % 60));
//On reconstruit l'heure
$time_spent_jeremy=$heures.'.'.$minutes;
//
//FIN REQUESTS JEREM
//

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//REQUESTS RENAUD
//
//Request de récupération des infos de time_fact pour tout
$sql="SELECT TIME_TO_SEC(time_fact) as sectime_fact";
$sql.=" FROM ".$tblpref."inter";
$sql.=" WHERE fk_createur='10' OR fk_technician='10' OR fk_technician2='10'";
$resql=mysql_query($sql);
if ($resql)
{
	$num =mysql_num_rows($resql);
	$i = 0;
	if ($num)
	{
		while ($i < $num)
		{
			$obj =mysql_fetch_object($resql);					
			if ($obj)
			{
				//results
				$timesec_inter_fact_renaud=$obj->sectime_fact;
				$timesec_fact_renaud=$timesec_fact_renaud+$timesec_inter_fact_renaud;
			}
			$i++;
		}
	}
}
// On convertit les secondes en HH:mm:ss	
$heures=intval($timesec_fact_renaud / 3600);
$minutes=intval(($timesec_fact_renaud % 3600) / 60);
$secondes=intval((($timesec_fact_renaud % 3600) % 60));
//On reconstruit l'heure
$time_fact_renaud=$heures.'.'.$minutes;

//Request de récupération des infos de time_spent pour tout
$sql = "SELECT TIME_TO_SEC(it.time_spent) as sectime";
$sql .= " FROM ".$tblpref."inter_tache as it";
$sql .= " LEFT JOIN ".$tblpref."inter as i ON i.rowid = it.fk_inter";
$sql .= " WHERE i.fk_createur='10' OR i.fk_technician='10' OR i.fk_technician2='10'";

$resql=mysql_query($sql);
if ($resql)
{
	$num = mysql_num_rows($resql);
	$i = 0;
	if ($num)
	{
		while ($i < $num)
		{
			$obj = mysql_fetch_object($resql);
			if ($obj)
			{
				$timesec_inter_spent_renaud=$obj->sectime;
				$timesec_spent_renaud=$timesec_spent_renaud+$timesec_inter_spent_renaud;
			}	
			$i++;
		}
	}
}
// On convertit les secondes en HH:mm:ss	
$heures=intval($timesec_spent_renaud / 3600);
$minutes=intval(($timesec_spent_renaud % 3600) / 60);
$secondes=intval((($timesec_spent_renaud % 3600) % 60));
//On reconstruit l'heure
$time_spent_renaud=$heures.'.'.$minutes;
//
//FIN REQUESTS RENAUD
//

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//REQUESTS ALEX
//
//Request de récupération des infos de time_fact pour tout
$sql="SELECT TIME_TO_SEC(time_fact) as sectime_fact";
$sql.=" FROM ".$tblpref."inter";
$sql.=" WHERE fk_createur='2' OR fk_technician='2' OR fk_technician2='2'";
$resql=mysql_query($sql);
if ($resql)
{
	$num =mysql_num_rows($resql);
	$i = 0;
	if ($num)
	{
		while ($i < $num)
		{
			$obj =mysql_fetch_object($resql);					
			if ($obj)
			{
				//results
				$timesec_inter_fact_alex=$obj->sectime_fact;
				$timesec_fact_alex=$timesec_fact_alex+$timesec_inter_fact_alex;
			}
			$i++;
		}
	}
}
// On convertit les secondes en HH:mm:ss	
$heures=intval($timesec_fact_alex / 3600);
$minutes=intval(($timesec_fact_alex % 3600) / 60);
$secondes=intval((($timesec_fact_alex % 3600) % 60));
//On reconstruit l'heure
$time_fact_alex=$heures.'.'.$minutes;

//Request de récupération des infos de time_spent pour tout
$sql = "SELECT TIME_TO_SEC(it.time_spent) as sectime";
$sql .= " FROM ".$tblpref."inter_tache as it";
$sql .= " LEFT JOIN ".$tblpref."inter as i ON i.rowid = it.fk_inter";
$sql .= " WHERE i.fk_createur='2' OR i.fk_technician='2' OR i.fk_technician2='2'";

$resql=mysql_query($sql);
if ($resql)
{
	$num = mysql_num_rows($resql);
	$i = 0;
	if ($num)
	{
		while ($i < $num)
		{
			$obj = mysql_fetch_object($resql);
			if ($obj)
			{
				$timesec_inter_spent_alex=$obj->sectime;
				$timesec_spent_alex=$timesec_spent_alex+$timesec_inter_spent_alex;
			}	
			$i++;
		}
	}
}
// On convertit les secondes en HH:mm:ss	
$heures=intval($timesec_spent_alex / 3600);
$minutes=intval(($timesec_spent_alex % 3600) / 60);
$secondes=intval((($timesec_spent_alex % 3600) % 60));
//On reconstruit l'heure
$time_spent_alex=$heures.'.'.$minutes;
//
//FIN REQUESTS ALEX
//

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//REQUESTS CHRIS
//
//Request de récupération des infos de time_fact pour tout
$sql="SELECT TIME_TO_SEC(time_fact) as sectime_fact";
$sql.=" FROM ".$tblpref."inter";
$sql.=" WHERE fk_createur='13' OR fk_technician='13' OR fk_technician2='13'";
$resql=mysql_query($sql);
if ($resql)
{
	$num =mysql_num_rows($resql);
	$i = 0;
	if ($num)
	{
		while ($i < $num)
		{
			$obj =mysql_fetch_object($resql);					
			if ($obj)
			{
				//results
				$timesec_inter_fact_chris=$obj->sectime_fact;
				$timesec_fact_chris=$timesec_fact_chris+$timesec_inter_fact_chris;
			}
			$i++;
		}
	}
}
// On convertit les secondes en HH:mm:ss	
$heures=intval($timesec_fact_chris / 3600);
$minutes=intval(($timesec_fact_chris % 3600) / 60);
$secondes=intval((($timesec_fact_chris % 3600) % 60));
//On reconstruit l'heure
$time_fact_chris=$heures.'.'.$minutes;

//Request de récupération des infos de time_spent pour tout
$sql = "SELECT TIME_TO_SEC(it.time_spent) as sectime";
$sql .= " FROM ".$tblpref."inter_tache as it";
$sql .= " LEFT JOIN ".$tblpref."inter as i ON i.rowid = it.fk_inter";
$sql .= " WHERE i.fk_createur='13' OR i.fk_technician='13' OR i.fk_technician2='13'";

$resql=mysql_query($sql);
if ($resql)
{
	$num = mysql_num_rows($resql);
	$i = 0;
	if ($num)
	{
		while ($i < $num)
		{
			$obj = mysql_fetch_object($resql);
			if ($obj)
			{
				$timesec_inter_spent_chris=$obj->sectime;
				$timesec_spent_chris=$timesec_spent_chris+$timesec_inter_spent_chris;
			}	
			$i++;
		}
	}
}
// On convertit les secondes en HH:mm:ss	
$heures=intval($timesec_spent_alex / 3600);
$minutes=intval(($timesec_spent_alex % 3600) / 60);
$secondes=intval((($timesec_spent_alex % 3600) % 60));
//On reconstruit l'heure
$time_spent_alex=$heures.'.'.$minutes;
//
//FIN REQUESTS CHRIS
//
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
			text: 'Rapports Heures de travail prestees/facturees'
		},
		subtitle: {
			text: 'Source: Donnees des interventions'
		},
		xAxis: {
			categories: [
				'1 Mois',
				'1 An',
				'Tout',
				'Corentin',
				'Jeremy',
				'Renaud',
				'Alex',
				'Christophe'
			]
		},
		yAxis: {
			min: 0,
			title: {
				text: 'Heures de travail'
			}
		},
		tooltip: {
			headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
			pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
				'<td style="padding:0"><b>{point.y:.1f} H.min</b></td></tr>',
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
			name: 'Prestees',
			data: [
				   <?php echo $time_spent_30days; //30derniers Jours?>
				   , 
				   <?php echo $time_spent_1year; //Dernier Mois?>
				   , 
				   <?php echo $time_spent_all; //Tout?>
				   ,
				   <?php echo $time_spent_corentin; //Corentin?>
				   ,
				   <?php echo $time_spent_jeremy; //Jeremy?>
				   ,
				   <?php echo $time_spent_renaud; //Renaud?>
				   ,
				   <?php echo $time_spent_alex; //Alex?>
				   , 
				   <?php echo $time_spent_chris; //Christophe?>
				   ]

		}, {
			name: 'Facturees',
			data: [
				   <?php echo $time_fact_30days; //30 derniers Jours?>
				   , 
				   <?php echo $time_fact_1year; //Dernier mois?>
				   , 
				   <?php echo $time_fact_all; //Tout?>
				   , 
				   <?php echo $time_fact_corentin; //Corentin?>
				   , 
				   <?php echo $time_fact_jeremy; //Jerem?>
				   ,
				   <?php echo $time_fact_renaud; //Renaud?>
				   ,
				   <?php echo $time_fact_alex; //Alex?>
				   ,
				   <?php echo $time_fact_chris; //Christophe?>
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

   