<?php	
include("../config/common.php");

	// si une variable queryString a été posté
	if(isset($_GET['q'])) 	{
										$q=addslashes($_GET['q']);
										// si la longueur du contenu de la variable est superieur à 0			
										if(strlen($q) >2)	{
											
																	// requete sql à personnaliser pour correspondre à votre base de données
																	$result = mysql_query("SELECT nom,num_client FROM ".$tblpref."client WHERE actif != 'non' AND nom LIKE '".$q."%' LIMIT 10" );
																	if($result) {
																	// on parcourt les resultats
																	while ($soc = mysql_fetch_object($result)) {
																	// on affiche les resultats dans un element de liste en ajoutant la fonction la fill sur l'evenenement onClick
																											echo '<option value="'.$soc->num_client.'">'.utf8_encode($soc->nom).'</option>';
																												}
																				} 
																	else 	{
																				echo 'Il y a une probleme avec la requete sql.';
																			}
																	} 
										else 	{					
												} 
										} 
		else 	{
				echo 'Il ne devrait pas avoir un accès direct à ce script !!!';
				}
?>
