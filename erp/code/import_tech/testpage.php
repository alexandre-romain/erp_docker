<?php
$modif_date="20-01-2014  00:00:00";

/*$date_inter=explode(" ", $modif_date);
$x=explode("-", $date_inter[0]);
$jours=$x[0];
$mois=$x[1];
$annee=$x[2];
$modif_date=$annee.'-'.$mois.'-'.$jours;*/




$date_inter=explode(" ", $modif_date);
$date=$date_inter[0];
$time=$date_inter[1];
$date_inter=explode("-", $date);
$jours	=$date_inter[0];
$mois	=$date_inter[1];
$annee	=$date_inter[2];
$modif_date=$annee.'-'.$mois.'-'.$jours;

echo $modif_date;
?>