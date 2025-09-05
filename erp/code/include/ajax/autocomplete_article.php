<?php	
include("../config/common.php");
	// si une variable queryString a été posté
	if(isset($_GET['rech'])) 	{
		$rech=$_GET['rech'];
		// si la longueur du contenu de la variable est superieur à 0			
		if(strlen($rech) >1)	{										
			// requete sql à personnaliser pour correspondre à votre base de données
			$req = mysql_query("SELECT article, article_name, prix_htva, taux_tva, marge, reference, marque, num, stock_tech, stock FROM ".$tblpref."article WHERE actif != 'non' AND (article LIKE '%".$rech."%' OR reference LIKE '%".$rech."%' OR marque LIKE '%".$rech."%' OR article_name LIKE '%".$rech."%') ORDER BY marque ASC, article ASC" );
			if($req) {
				$exists=mysql_num_rows($req);
				if ($exists > 0) {
					// on parcourt les resultats
					while ($obj = mysql_fetch_object($req)) {
						//Calcul du PV
						$one_percent=$obj->prix_htva/100;
						$marge=$one_percent*$obj->marge;
						$pv_inter=$obj->prix_htva+$marge;
						$tva_inter=$pv_inter/100;
						$tva=$tva_inter*$obj->taux_tva;
						$pv=$pv_inter+$tva;
					// on affiche les resultats dans un element de liste en ajoutant la fonction la fill sur l'evenenement onClick
						echo '<option value="'.$obj->num.'">'.$obj->marque.' | '.htmlentities($obj->article).' | '.$obj->article_name.' | PN: '.$obj->reference.' | PA: '.$obj->prix_htva.' &euro; | PV: '.$pv_inter.' &euro; | Stock Tech: '.$obj->stock_tech.' | Stock: '.$obj->stock.' | Marge : '.$obj->marge.' %</option>';
					}
				}
				else {
					echo 'no';
				}
			} 
			else {
				echo 'Il y a une probleme avec la requete sql.';
			}
		} 
		else 	{} 
	} 
	else {
		echo 'Il ne devrait pas avoir un accès direct à ce script !!!';
	}
?>