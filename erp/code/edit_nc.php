<?php 
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/language/$lang.php");

$num_client=$_POST['client'];
$sql1 = " INSERT INTO " . $tblpref ."nc (client_num) VALUES ('$num_client')";
$result1 = mysql_query($sql1) or die('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());

foreach($_POST['line'] as $ligne){//-----------------------------------------------------
	$sql4 = "SELECT serial, status, bl_cont_sortie FROM ".$tblpref."stock  WHERE bl_cont_sortie = '$ligne' ";
	$result4 = mysql_query($sql4) or die ("requete foreach2 select stock impossible");
	$data4 = mysql_fetch_array($result4);
	$serial = $data4['serial'];	
	$status = $data4['status'];	
	$control = $data4['bl_cont_sortie'];	
			
	$sql5 = "SELECT p_u_jour, bl_num, article_num, serial, quanti FROM ".$tblpref."cont_bl WHERE num='$ligne'";
	$result5 = mysql_query($sql5) or die ("requete foreach2 select cont_bl impossible");
	$data5 = mysql_fetch_array($result5);
	$prix= $data5['p_u_jour'];
	$bl_num= $data5['bl_num'];
	$article_num = $data5['article_num'];
	$quanti = $data5['quanti'];
			
	$sql6 = "SELECT fact_num FROM ".$tblpref."bl WHERE num_bl='$bl_num'";
	$result6 = mysql_query($sql6) or die ("requete foreach2 select bl impossible");
	$data6 = mysql_fetch_array($result6);
	$fact_num = $data6['fact_num'];
			
	$sql7 = "SELECT MAX(num_nc) As Maxi FROM " . $tblpref ."nc";
	$result7 = mysql_query($sql7) or die('Erreur');
	$num_nc = mysql_result($result7, 'Maxi');
		
	$sql8 = "INSERT INTO ".$tblpref."cont_nc (article_num, nc_num, p_u_jour, fact_num, serial, quanti ) VALUES ('$article_num', '$num_nc', '$prix', '$fact_num', '$serial', '$quanti' )";
	$result8 = mysql_query($sql8) or die('Erreur SQL !<br>'.$sql8.'<br>'.mysql_error());
	
  if($control==""){
  	$serial = $data5['serial'];
	$sql9 = "INSERT INTO ".$tblpref."stock (article, serial, facture_achat, bl_cont_sortie, status) VALUES ('$article_num', '$serial', '$fact_num', '$ligne', 'in')";
	$result9 = mysql_query($sql9) or die('Erreur SQL !<br>'.$sql9.'<br>'.mysql_error());
  }
  if($status=="out"){//--------------------------------------------------------------
  	$sql3 = "SELECT stock FROM ".$tblpref."article  WHERE num = '$article_num' ";
	$result3 = mysql_query($sql3) or die ("requete foreach1 select article impossible");
	$data3 = mysql_fetch_array($result3);
	$stock = $data3['stock'];
	$stock = $stock+1;
	
	$sql2 = "UPDATE ".$tblpref."article SET stock=$stock WHERE num = '$article_num' ";
	mysql_query($sql2) OR die("<p>Erreur Mysql<br/>$sql2<br/>".mysql_error()."</p>");
	$result2 = mysql_query($sql2) or die ("requete foreach1 update article impossible");
			
	mysql_select_db($db) or die ("Could not select $db database");
	$sql = "UPDATE ".$tblpref."stock SET status='in' WHERE article = '$article_num' AND serial = '$serial' AND bl_cont_sortie = '$ligne' ";
	mysql_query($sql) OR die("<p>Erreur Mysql<br/>$sql2<br/>".mysql_error()."</p>");
	$result = mysql_query($sql) or die ("requete foreach2 update stock impossible");
  }//fin du if ----------------------------------------------------			
};//fin 1er foreach -----------------------------------------------
header("Location: lister_nc.php");
exit;
?>