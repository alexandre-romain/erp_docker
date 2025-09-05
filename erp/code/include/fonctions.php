<?php

function dateUSA_to_dateEU($date)
{
	$inter=explode('-',$date);
	$year	= $inter[0];
	$month	= $inter[1];
	$day	= $inter[2];
	$date_correct = $day.'-'.$month.'-'.$year;
	
	return $date_correct;
}

function dateEU_to_dateUSA($date)
{
	$inter=explode('-',$date);
	$day	= $inter[0];
	$month	= $inter[1];
	$year	= $inter[2];
	$date_correct = $year.'-'.$month.'-'.$day;
	
	return $date_correct;
}

function retirer_accent($string){
	return strtr($string,'ΰαβγδηθικλμνξορςστυφωϊϋόύÿΐΑΒΓΔΗΘΙΚΛΜΝΞΟΡÒΣΤΥΦΩΪΫάέ',
'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
}
?>