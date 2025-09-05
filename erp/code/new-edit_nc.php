<?php 
require_once("include/verif.php");
include_once("include/config/common.php");

include_once("include/language/$lang.php");

if (isset($update_article)) {
	foreach ($update_article as $test2) {
		$sql3 = "SELECT stock FROM " . $tblprefluc ."article  WHERE num = $test2 ";
		$result3 = mysql_query($sql3) or die ("requete foreach1 impossible");
		$data3 = mysql_fetch_array($result3);
		$stock = $data3['stock'];
		$stock = $stock+1;
		
		$sql2 = "UPDATE " . $tblprefluc ."article SET stock=$stock WHERE num = $test2 ";
		mysql_query($sql2) OR die("<p>Erreur Mysql<br/>$sql2<br/>".mysql_error()."</p>");
		//$message= "<h2>article mis à jour</h2><br><hr>";
		$result2 = mysql_query($sql2) or die ("requete foreach2 impossible");
	}
}

if (isset($update_stock)) {
	foreach ($update_stock as $test) {
		if (isset($sery)) {
			foreach ($sery as $serial) {
				mysql_select_db($db) or die ("Could not select $db database");
				$sql = "UPDATE " . $tblprefluc ."stock SET status='in' WHERE article = $test AND serial= '".$serial."' ";
				mysql_query($sql) OR die("<p>Erreur Mysql<br/>$sql2<br/>".mysql_error()."</p>");
				//$message= "<h2>$lang_stock_jour</h2><br><hr>";
				$result = mysql_query($sql) or die ("requete foreach1 impossible");
			}
		}
	}
} ?>