<?php
require_once("include/verif.php");
include_once("include/config/common.php");
echo '<link rel="stylesheet" type="text/css" href="include/style.css">';
echo'<link rel="shortcut icon" type="image/x-icon" href="image/favicon.ico" >';

$quanti=isset($_POST['quanti'])?$_POST['quanti']:"";
$num_cont=isset($_POST['num_cont'])?$_POST['num_cont']:"";
$bl_num=isset($_POST['bl_num'])?$_POST['bl_num']:"";
$article=isset($_POST['article'])?$_POST['article']:"";

$serial=isset($_POST['serial'])?$_POST['serial']:"";
$serial1=isset($_POST['serial1'])?$_POST['serial1']:"";
$serial2=isset($_POST['serial2'])?$_POST['serial2']:"";
$serial3=isset($_POST['serial3'])?$_POST['serial3']:"";
$serial4=isset($_POST['serial4'])?$_POST['serial4']:"";
$serial5=isset($_POST['serial5'])?$_POST['serial5']:"";
$serial6=isset($_POST['serial6'])?$_POST['serial6']:"";
$serial7=isset($_POST['serial7'])?$_POST['serial7']:"";
$serial8=isset($_POST['serial8'])?$_POST['serial8']:"";
$serial9=isset($_POST['serial9'])?$_POST['serial9']:"";
$serial10=isset($_POST['serial10'])?$_POST['serial10']:"";
$serial11=isset($_POST['serial11'])?$_POST['serial11']:"";
$serial12=isset($_POST['serial12'])?$_POST['serial12']:"";
$serial13=isset($_POST['serial13'])?$_POST['serial13']:"";
$serial14=isset($_POST['serial14'])?$_POST['serial14']:"";
$serial15=isset($_POST['serial15'])?$_POST['serial15']:"";
$serial16=isset($_POST['serial16'])?$_POST['serial16']:"";
$serial17=isset($_POST['serial17'])?$_POST['serial17']:"";
$serial18=isset($_POST['serial18'])?$_POST['serial18']:"";
$serial19=isset($_POST['serial19'])?$_POST['serial19']:"";
$serial20=isset($_POST['serial20'])?$_POST['serial20']:"";
$serial21=isset($_POST['serial21'])?$_POST['serial21']:"";
$serial22=isset($_POST['serial22'])?$_POST['serial22']:"";
$serial23=isset($_POST['serial23'])?$_POST['serial23']:"";
$serial24=isset($_POST['serial24'])?$_POST['serial24']:"";
$serial25=isset($_POST['serial25'])?$_POST['serial25']:"";
$serial26=isset($_POST['serial26'])?$_POST['serial26']:"";
$serial27=isset($_POST['serial27'])?$_POST['serial27']:"";
$serial28=isset($_POST['serial28'])?$_POST['serial28']:"";
$serial29=isset($_POST['serial29'])?$_POST['serial29']:"";
$serial30=isset($_POST['serial30'])?$_POST['serial30']:"";

// on concatène le serial genre manière forte ...
	if ($serial1 != 'aucun' && $serial1 != '')
	{
	$serial = $serial1;
	
	$sql3 = "UPDATE `" . $tblpref ."stock` SET `status` = 'out', `bl_cont_sortie` = '$num_cont' WHERE `serial` = '$serial1'";
	mysql_query($sql3) or die('Erreur SQL11 !<br>'.$sql3.'<br>'.mysql_error());
	
		if ($serial2 != 'aucun' && $serial2 != '')
		{
		$serial = $serial." | ".$serial2;
		$sql3 = "UPDATE `" . $tblpref ."stock` SET `status` = 'out', `bl_cont_sortie` = '$num_cont' WHERE `serial` = '$serial2'";
		mysql_query($sql3) or die('Erreur SQL11 !<br>'.$sql3.'<br>'.mysql_error());
		
			if ($serial3 != 'aucun' && $serial3 != '')
			{
			$serial = $serial." | ".$serial3;
			$sql3 = "UPDATE `" . $tblpref ."stock` SET `status` = 'out', `bl_cont_sortie` = '$num_cont' WHERE `serial` = '$serial3'";
			mysql_query($sql3) or die('Erreur SQL11 !<br>'.$sql3.'<br>'.mysql_error());
			
				if ($serial4 != 'aucun' && $serial4 != '')
				{
				$serial = $serial." | ".$serial4;
				$sql3 = "UPDATE `" . $tblpref ."stock` SET `status` = 'out', `bl_cont_sortie` = '$num_cont' WHERE `serial` = '$serial4'";
				mysql_query($sql3) or die('Erreur SQL11 !<br>'.$sql3.'<br>'.mysql_error());
				
					if ($serial5 != 'aucun' && $serial5 != '')
					{
					$serial = $serial." | ".$serial5;
					$sql3 = "UPDATE `" . $tblpref ."stock` SET `status` = 'out', `bl_cont_sortie` = '$num_cont' WHERE `serial` = '$serial5'";
					mysql_query($sql3) or die('Erreur SQL11 !<br>'.$sql3.'<br>'.mysql_error());
					
						if ($serial6 != 'aucun' && $serial6 != '')
						{
						$serial = $serial." | ".$serial6;
						$sql3 = "UPDATE `" . $tblpref ."stock` SET `status` = 'out', `bl_cont_sortie` = '$num_cont' WHERE `serial` = '$serial6'";
						mysql_query($sql3) or die('Erreur SQL11 !<br>'.$sql3.'<br>'.mysql_error());
						
							if ($serial7 != 'aucun' && $serial7 != '')
							{
							$serial = $serial." | ".$serial7;
							$sql3 = "UPDATE `" . $tblpref ."stock` SET `status` = 'out', `bl_cont_sortie` = '$num_cont' WHERE `serial` = '$serial7'";
							mysql_query($sql3) or die('Erreur SQL11 !<br>'.$sql3.'<br>'.mysql_error());
							
								if ($serial8 != 'aucun' && $serial8 != '')
								{
								$serial = $serial." | ".$serial8;
								$sql3 = "UPDATE `" . $tblpref ."stock` SET `status` = 'out', `bl_cont_sortie` = '$num_cont' WHERE `serial` = '$serial8'";
								mysql_query($sql3) or die('Erreur SQL11 !<br>'.$sql3.'<br>'.mysql_error());
								
									if ($serial9 != 'aucun' && $serial9 != '')
									{
									$serial = $serial." | ".$serial9;
									$sql3 = "UPDATE `" . $tblpref ."stock` SET `status` = 'out', `bl_cont_sortie` = '$num_cont' WHERE `serial` = '$serial9'";
									mysql_query($sql3) or die('Erreur SQL11 !<br>'.$sql3.'<br>'.mysql_error());
									
										if ($serial10 != 'aucun' && $serial10 != '')
										{
										$serial = $serial." | ".$serial10;
										$sql3 = "UPDATE `" . $tblpref ."stock` SET `status` = 'out', `bl_cont_sortie` = '$num_cont' WHERE `serial` = '$serial10'";
										mysql_query($sql3) or die('Erreur SQL11 !<br>'.$sql3.'<br>'.mysql_error());
										
											if ($serial11 != 'aucun' && $serial11 != '')
											{
											$serial = $serial." | ".$serial11;
											$sql3 = "UPDATE `" . $tblpref ."stock` SET `status` = 'out', `bl_cont_sortie` = '$num_cont' WHERE `serial` = '$serial11'";
											mysql_query($sql3) or die('Erreur SQL11 !<br>'.$sql3.'<br>'.mysql_error());
											
												if ($serial12 != 'aucun' && $serial12 != '')
												{
												$serial = $serial." | ".$serial12;
												$sql3 = "UPDATE `" . $tblpref ."stock` SET `status` = 'out', `bl_cont_sortie` = '$num_cont' WHERE `serial` = '$serial12'";
												mysql_query($sql3) or die('Erreur SQL11 !<br>'.$sql3.'<br>'.mysql_error());
												
													if ($serial13 != 'aucun' && $serial13 != '')
													{
													$serial = $serial." | ".$serial13;
													$sql3 = "UPDATE `" . $tblpref ."stock` SET `status` = 'out', `bl_cont_sortie` = '$num_cont' WHERE `serial` = '$serial13'";
													mysql_query($sql3) or die('Erreur SQL11 !<br>'.$sql3.'<br>'.mysql_error());
													
														if ($serial14 != 'aucun' && $serial14 != '')
														{
														$serial = $serial." | ".$serial14;
														$sql3 = "UPDATE `" . $tblpref ."stock` SET `status` = 'out', `bl_cont_sortie` = '$num_cont' WHERE `serial` = '$serial14'";
														mysql_query($sql3) or die('Erreur SQL11 !<br>'.$sql3.'<br>'.mysql_error());
														
															if ($serial15 != 'aucun' && $serial15 != '')
															{
															$serial = $serial." | ".$serial15;
															$sql3 = "UPDATE `" . $tblpref ."stock` SET `status` = 'out', `bl_cont_sortie` = '$num_cont' WHERE `serial` = '$serial15'";
															mysql_query($sql3) or die('Erreur SQL11 !<br>'.$sql3.'<br>'.mysql_error());
															
																if ($serial16 != 'aucun' && $serial16 != '')
																{
																$serial = $serial." | ".$serial16;
																$sql3 = "UPDATE `" . $tblpref ."stock` SET `status` = 'out', `bl_cont_sortie` = '$num_cont' WHERE `serial` = '$serial16'";
																mysql_query($sql3) or die('Erreur SQL11 !<br>'.$sql3.'<br>'.mysql_error());
																
																	if ($serial17 != 'aucun' && $serial17 != '')
																	{
																	$serial = $serial." | ".$serial17;
																	$sql3 = "UPDATE `" . $tblpref ."stock` SET `status` = 'out', `bl_cont_sortie` = '$num_cont' WHERE `serial` = '$serial17'";
																	mysql_query($sql3) or die('Erreur SQL11 !<br>'.$sql3.'<br>'.mysql_error());
																	
																		if ($serial18 != 'aucun' && $serial18 != '')
																		{
																		$serial = $serial." | ".$serial18;
																		$sql3 = "UPDATE `" . $tblpref ."stock` SET `status` = 'out', `bl_cont_sortie` = '$num_cont' WHERE `serial` = '$serial18'";
																		mysql_query($sql3) or die('Erreur SQL11 !<br>'.$sql3.'<br>'.mysql_error());
																		
																			if ($serial19 != 'aucun' && $serial19 != '')
																			{
																			$serial = $serial." | ".$serial19;
																			$sql3 = "UPDATE `" . $tblpref ."stock` SET `status` = 'out', `bl_cont_sortie` = '$num_cont' WHERE `serial` = '$serial19'";
																			mysql_query($sql3) or die('Erreur SQL11 !<br>'.$sql3.'<br>'.mysql_error());
																			
																				if ($serial20 != 'aucun' && $serial20 != '')
																				{
																				$serial = $serial." | ".$serial20;
																				$sql3 = "UPDATE `" . $tblpref ."stock` SET `status` = 'out', `bl_cont_sortie` = '$num_cont' WHERE `serial` = '$serial20'";
																				mysql_query($sql3) or die('Erreur SQL11 !<br>'.$sql3.'<br>'.mysql_error());
																				
																					if ($serial21 != 'aucun' && $serial21 != '')
																					{
																					$serial = $serial." | ".$serial21;
																					$sql3 = "UPDATE `" . $tblpref ."stock` SET `status` = 'out', `bl_cont_sortie` = '$num_cont' WHERE `serial` = '$serial21'";
																					mysql_query($sql3) or die('Erreur SQL11 !<br>'.$sql3.'<br>'.mysql_error());
																					
																						if ($serial22 != 'aucun' && $serial22 != '')
																						{
																						$serial = $serial." | ".$serial22;
																						$sql3 = "UPDATE `" . $tblpref ."stock` SET `status` = 'out', `bl_cont_sortie` = '$num_cont' WHERE `serial` = '$serial22'";
																						mysql_query($sql3) or die('Erreur SQL11 !<br>'.$sql3.'<br>'.mysql_error());
																						
																							if ($serial23 != 'aucun' && $serial23 != '')
																							{
																							$serial = $serial." | ".$serial23;
																							$sql3 = "UPDATE `" . $tblpref ."stock` SET `status` = 'out', `bl_cont_sortie` = '$num_cont' WHERE `serial` = '$serial23'";
																							mysql_query($sql3) or die('Erreur SQL11 !<br>'.$sql3.'<br>'.mysql_error());
																							
																								if ($serial24 != 'aucun' && $serial24 != '')
																								{
																								$serial = $serial." | ".$serial24;
																								$sql3 = "UPDATE `" . $tblpref ."stock` SET `status` = 'out', `bl_cont_sortie` = '$num_cont' WHERE `serial` = '$serial24'";
																								mysql_query($sql3) or die('Erreur SQL11 !<br>'.$sql3.'<br>'.mysql_error());
																								
																									if ($serial25 != 'aucun' && $serial25 != '')
																									{
																									$serial = $serial." | ".$serial25;
																									$sql3 = "UPDATE `" . $tblpref ."stock` SET `status` = 'out', `bl_cont_sortie` = '$num_cont' WHERE `serial` = '$serial25'";
																									mysql_query($sql3) or die('Erreur SQL11 !<br>'.$sql3.'<br>'.mysql_error());
																									
																										if ($serial26 != 'aucun' && $serial26 != '')
																										{
																										$serial = $serial." | ".$serial26;
																										$sql3 = "UPDATE `" . $tblpref ."stock` SET `status` = 'out', `bl_cont_sortie` = '$num_cont' WHERE `serial` = '$serial26'";
																										mysql_query($sql3) or die('Erreur SQL11 !<br>'.$sql3.'<br>'.mysql_error());
																										
																											if ($serial27 != 'aucun' && $serial27 != '')
																											{
																											$serial = $serial." | ".$serial27;
																											$sql3 = "UPDATE `" . $tblpref ."stock` SET `status` = 'out', `bl_cont_sortie` = '$num_cont' WHERE `serial` = '$serial27'";
																											mysql_query($sql3) or die('Erreur SQL11 !<br>'.$sql3.'<br>'.mysql_error());
																											
																												if ($serial28 != 'aucun' && $serial28 != '')
																												{
																												$serial = $serial." | ".$serial28;
																												$sql3 = "UPDATE `" . $tblpref ."stock` SET `status` = 'out', `bl_cont_sortie` = '$num_cont' WHERE `serial` = '$serial28'";
																												mysql_query($sql3) or die('Erreur SQL11 !<br>'.$sql3.'<br>'.mysql_error());
																												
																													if ($serial29 != 'aucun' && $serial29 != '')
																													{
																													$serial = $serial." | ".$serial29;
																													$sql3 = "UPDATE `" . $tblpref ."stock` SET `status` = 'out', `bl_cont_sortie` = '$num_cont' WHERE `serial` = '$serial29'";
																													mysql_query($sql3) or die('Erreur SQL11 !<br>'.$sql3.'<br>'.mysql_error());
																													
																														if ($serial30 != 'aucun' && $serial30 != '')
																														{
																														$serial = $serial." | ".$serial30;
																														$sql3 = "UPDATE `" . $tblpref ."stock` SET `status` = 'out', `bl_cont_sortie` = '$num_cont' WHERE `serial` = '$serial30'";
																														mysql_query($sql3) or die('Erreur SQL11 !<br>'.$sql3.'<br>'.mysql_error());
																														}																														
																														
																													}
																													
																												}
																												
																											}
																											
																										}
																										
																									}
																																																		
																								}
																								
																							}
																							
																						}
																					}
																					
																				}
																				
																			}
																			
																		}
																		
																	}
																	
																}
																
															}
															
														}
													}
												}
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}
	
	}
if ($serial == ''){$serial='aucun';}

//on recupere le n° de ligne du bdc depuis la table ligne bl
$sql2 = "SELECT num_cont_bon FROM " . $tblpref ."cont_bl WHERE  num = $num_cont";
$req2 = mysql_query($sql2) or die('Erreur SQL !<br>'.$sql2.'<br>'.mysql_error());
while($data2 = mysql_fetch_array($req2))
{ $num_cont_bon = $data2['num_cont_bon'];}

//on récupère les infos de la ligne du bdc
$sql3 = "SELECT quanti, livre, p_u_jour FROM " . $tblpref ."cont_bon WHERE  num = $num_cont_bon";
$req3 = mysql_query($sql3) or die('Erreur SQL !<br>'.$sql3.'<br>'.mysql_error());

while($data3 = mysql_fetch_array($req3))
{ 
$commande = $data3['quanti'];
$dejalivre = $data3['livre'];
$bo = $commande - $dejalivre;
$p_u_jour = $data3['p_u_jour'];
}
if ($quanti > $bo)
{
echo "<center><h2>Quantité livrée excessive</h2></center>";
$num_bl = $bl_num;
include("edit_bl.php");
exit;
}
// si quantité livrée 0 suppression de la ligne sur le bl
if ($quanti == '0')
{
$sql1 = "DELETE FROM " . $tblpref ."cont_bl WHERE num = '".$num_cont."'";
mysql_query($sql1) or die('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());

}else{ 

$tot_htva = $p_u_jour * $quanti ;
$tot_tva = $tot_htva / 100 * 21 ;

//on met a jour les données du bl
$sql2 = "UPDATE " . $tblpref ."cont_bl 
SET  quanti='".$quanti."', tot_art_htva ='".$tot_htva."', to_tva_art ='".$tot_tva."', serial='".$serial."'  
WHERE num = '".$num_cont."'";
mysql_query($sql2) OR die("<p>Erreur Mysql<br/>$sql2<br/>".mysql_error()."</p>");

}

//on met a jour les données du bdc


//$sql4 = "UPDATE " . $tblpref ."cont_bon 
//SET  livre = (livre +'".$quanti."')   
//WHERE num = '".$num_cont_bon."'";
//mysql_query($sql4) OR die("<p>Erreur Mysql<br/>$sql4<br/>".mysql_error()."</p>");


$num_bl=$bl_num; //pour le bas

include_once("edit_bl.php");
 ?> 