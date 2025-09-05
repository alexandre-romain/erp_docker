<?php
			function dateEU_to_dateUSA1($date)
				{
					$inter=explode('-',$date);
					$day	= $inter[0];
					$month	= $inter[1];
					$year	= $inter[2];
					$date_correct = $year.'-'.$month.'-'.$day;
					
					return $date_correct;
				}
// Se connecter à la base de données
 	//on connecte la db
	$user= "root";//l'utilisateur de la base de donn?es mysql
	$pwd= "rootpass01";//le mot de passe ? la base de donn?es mysql
	$db= "gestion";//le nom de la base de donn?es mysql
	$host= "localhost";//l'adresse de la base de donn?es mysql 
	$default_lang= "fr";//la langue de l'interface et des factures : voir la doc pour les abbr?viations
	$tblpref= "gestsprl_";//prefixe des tables 
	mysql_connect($host,$user,$pwd) or die ("serveur de base de donn?es injoignable.");
	mysql_select_db($db) or die ("La base de donn?es est injoignable.");
	mysql_set_charset('ISO-8859-1');

// Obtenir la date actuelle
	$date_actuelle = date('Y-m-d');

// Sélectionner tous les contrats à facturer

	$sql_contrat = "SELECT id, id_cli, echeance, DATE_FORMAT(echeance,'%d/%m/%Y') AS echeance_fr, debut, periodicite, article, com_facture FROM gestsprl_contrat WHERE 1";
	$req_contrat = mysql_query($sql_contrat) or die('Erreur SQL !<br>'.$sql_contrat.'<br>'.mysql_error());
	
// Parcourir les résultats			
	
	while($contrat = mysql_fetch_array($req_contrat))
{
			
    // Obtenir les informations nécessaires
    $id_contrat = $contrat['id'];
	$id_cli = $contrat['id_cli'];
    $debut = $contrat['debut'];
    $periodicite = $contrat['periodicite'];
    $echeance = $contrat['echeance'];
	$echeance_fr = $contrat['echeance_fr'];
    $article = $contrat['article'];
    $com_facture = $contrat['com_facture'];
	
	// infos client
	$sql_cli = "SELECT * FROM gestsprl_client WHERE num_client = '$id_cli'";
	$req_cli = mysql_query($sql_cli) or die('Erreur SQL !<br>'.$sql_cli.'<br>'.mysql_error());
				
		while($data_cli = mysql_fetch_array($req_cli))
	{
		$nom_cli = $data_cli['nom'];
		$nom2_cli = $data_cli['nom2'];
		$mail_cli = $data_cli['mail'];
		$tel_cli = $data_cli['tel'];
		$gsm_cli = $data_cli['gsm'];	
	}
		
    	// Vérifier si le contrat doit être renouvelé / facturé
    	if ($date_actuelle >= $echeance) 
	{

		//création de la facture + envoi au client
		
		// cr?ation du BDC
		
		$date = date('d/m/Y');
		//On split la date.
		list($jour,$mois,$annee) = preg_split('/\//', $date, 3);

		//on cr?e le bon de commande, vide.
		
		$sql1 = "INSERT INTO gestsprl_bon_comm(client_num, date) VALUES ('$id_cli', '$annee-$mois-$jour')";
		mysql_query($sql1) or die('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());
		$bon_num=mysql_insert_id();
		
		
		//on boucle sur les articles du contrat pour injection dans table cont_bon
			
			
				$sql_article = "SELECT * FROM gestsprl_article WHERE num = '$article'";
				$req_article = mysql_query($sql_article) or die('Erreur SQL !<br>'.$sql_article.'<br>'.mysql_error());
				
				$prix_total_ht = 0;
				$tot_tva = 0;
				
				while($data_article = mysql_fetch_array($req_article))
    			{
				$id_product = $data_article['num'];
				$nom_product = $data_article['article'];
				$marque_article = $data_article['marque'];
				$PA = $data_article['prix_htva'];
				$reference_article = $data_article['reference'];
				$fourn = $data_article['fourn'];
				$taux_tva = $data_article['taux_tva'];
				$marge = $data_article['marge'];
				//calcul du PV
				if ( ($marge == '0')){ 
					$prix_article = $PA; 
				}
				else { 
					$prix_article = (($marge / 100) + 1) * $PA; 
				}
				$total_htva = $prix_article * $periodicite ;
				$mont_tva = $total_htva / 100 * $taux_tva ;
				$mont_tva = sprintf("%.2f",$mont_tva);					
				
				$prix_total_ht += ($prix_article*$periodicite);
				$tot_tva += $mont_tva;

			//inserer les donn?es dans la table du conten des bons.
			$sql1 = "INSERT INTO gestsprl_cont_bon(p_u_jour, quanti, article_num, bon_num, tot_art_htva, to_tva_art, fourn) 
			VALUES ('$prix_article', '$periodicite', '$id_product', '$bon_num', '$total_htva', '$mont_tva', '$fourn')";
			mysql_query($sql1) or die('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());
			
			
				}

		// on met a jour l'enregistrement dans la table con_comm avec les totaux
		$sql2 = "UPDATE gestsprl_bon_comm SET tot_htva='".$prix_total_ht."', tot_tva='".$tot_tva."'  WHERE num_bon = $bon_num";
		mysql_query($sql2) OR die("<p>Erreur Mysql2<br/>$sql2<br/>".mysql_error()."</p>");
		
		
		// cr?ation du BL
		$sql1 = "INSERT INTO gestsprl_bl ( client_num, date, bon_num, tot_htva, tot_tva ) VALUES ( $id_cli, '$annee-$mois-$jour', $bon_num, $prix_total_ht, $tot_tva )";
		mysql_query($sql1) or die('Erreur SQL 2!<br>'.$sql1.'<br>'.mysql_error());
		$num_bl=mysql_insert_id();
		
		
		//on cr?e les lignes du bl dans la table gest_cont_bl (oblig? si on veutdes traces de tous ls bl ...)
		
		$sql3 = "SELECT * FROM gestsprl_cont_bon WHERE bon_num = $bon_num";
		$req = mysql_query($sql3) or die('Erreur SQL 3!<br>'.$sql3.'<br>'.mysql_error());
		while($data = mysql_fetch_array($req)) {
			$article_num = $data['article_num'];
			$quanti_bon = $data['quanti'];
			$tot_art_htva = $data['tot_art_htva'];
			$to_tva_art = $data['to_tva_art'];
			$p_u_jour = $data['p_u_jour'];
			$num_cont_bon = $data['num'];
			$livre = $data['livre'];
			$alivrer = $quanti_bon - $livre;
		
			$tot_art_htva = $alivrer * $p_u_jour;
			
			$sql4 = "SELECT taux_tva FROM gestsprl_article WHERE num = $article";
			$req4 = mysql_query($sql4) or die('Erreur SQL 4!<br>'.$sql4.'<br>'.mysql_error());
				
			while($data4 = mysql_fetch_array($req4)) 
			{
				$taux_tva = $data4['taux_tva'];
				$to_tva_art = $tot_art_htva / 100 * $taux_tva ;
			}
			//on cr?e la ligne du bl

				$sql4 = "INSERT INTO gestsprl_cont_bl(bl_num, article_num, quanti, tot_art_htva, to_tva_art, p_u_jour, num_cont_bon) 
				VALUES ('$num_bl', '$article_num', '$alivrer', '$tot_art_htva', '$to_tva_art', '$p_u_jour', '$num_cont_bon')";

			mysql_query($sql4) or die('Erreur SQL5 !<br>'.$sql4.'<br>'.mysql_error());
			
		
			//on met ? jour la quantit? livr?e pour chaque ligne
			$rqSql = "SELECT num_cont_bon,quanti FROM gestsprl_cont_bl WHERE bl_num = $num_bl";
			$result = mysql_query( $rqSql ) or die( "Ex?cution requ?te impossible.");
			while ( $row = mysql_fetch_array( $result)) {
				$sql5 = "UPDATE gestsprl_cont_bon SET livre=(livre+".$row['quanti'].") WHERE num = ".$row['num_cont_bon']."";
				mysql_query($sql5) OR die("<p>Erreur Mysql2<br/>$sql5<br/>".mysql_error()."</p>");
				
			}
			//mise a jour du prix total, du commentaire du BL + empeche modifs futures
			$sql2 = "UPDATE gestsprl_bl SET tot_htva='".$prix_total_ht."', tot_tva='".$tot_tva."', coment='".$coment."', status='1'  WHERE num_bl = $num_bl";
			mysql_query($sql2) OR die("<p>Erreur Mysql2<br/>$sql2<br/>".mysql_error()."</p>");
			
			
			//r?cup?ration du n? de bon de commande
			$rqSql = "SELECT bon_num, client_num FROM gestsprl_bl WHERE num_bl = $num_bl";
			$result = mysql_query( $rqSql ) or die( "Ex?cution requ?te impossible.");
			while ( $row = mysql_fetch_array( $result)) {
					$bon_num = $row["bon_num"];
					$client = $row["client_num"];
			}
			//on v?rifie si des bo restants pour ce bon de commande
			$rqSql2 = "SELECT quanti,livre, num as num_cont_bon FROM gestsprl_cont_bon WHERE bon_num = $bon_num";
			$result2 = mysql_query( $rqSql2 ) or die( "Ex?cution requ?te impossible.");
			$compteur = '0';
			while ( $row2 = mysql_fetch_array( $result2)) {
					$comparateur=mysql_num_rows($result2);
					$bo = $row2["quanti"] - $row2["livre"] ;
					$num_cont_bon = $row2['num_cont_bon'];
					if ($bo <='0') 
					{
					$compteur = $compteur+1;
					//on desactive la ligne du bon
					//$sql5 = "UPDATE gestsprl_cont_bon SET bl='1' WHERE num = $num_cont_bon";
					//mysql_query($sql5) OR die("<p>Erreur Mysql2<br/>$sql5<br/>".mysql_error()."</p>");
					}
			}
			
			//on empeche la transforation du bon de commande en nouveau bl
			if ($compteur == $comparateur)
			{
			$sql4 = "UPDATE gestsprl_bon_comm SET bl='end' WHERE num_bon = $bon_num";
			mysql_query($sql4) OR die("<p>Erreur Mysql2<br/>$sql4<br/>".mysql_error()."</p>");
			
			}
			//modif stock
			$rqSql3 = "SELECT article_num, quanti FROM gestsprl_cont_bl WHERE bl_num = $num_bl";
			$result3 = mysql_query( $rqSql3 ) or die( "ici.");
			while ( $row3 = mysql_fetch_array( $result3)) 
			{	
					$article_num = $row3['article_num'];
					$quanti = $row3['quanti'];
					$sql12 = "UPDATE `gestsprl_article` SET `stock` = (stock - $quanti) WHERE `num` = '$article'";
					mysql_query($sql12) or die('Erreur SQL12 !<br>'.$sql12.'<br>'.mysql_error());
					
			}		
		
		}
		
		// cr?ation de la facture
		
			//calcul de la prochaine echeance du contrat
			
			$dateDepartTimestamp = strtotime(str_replace('/', '-', $echeance));
			$dateFin = date('Y-m-d', strtotime('+'.$periodicite.' month', $dateDepartTimestamp));
			
			// on ajoute la période au commentaire de la facture

			$com_facture .= "\nPeriode : ".dateEU_to_dateUSA1($echeance)." -> ".dateEU_to_dateUSA1($dateFin);

			//on génère la date d'échéance de la facture
			//calcul de l'écheance
			$jour_echeance = $jour;
			$mois_echeance = $mois;
			$annee_echeance = $annee;
			$delai = 8;
			while ($i<$delai)
			{
			$jour_echeance = $jour_echeance +1;
				if ($jour_echeance >= 30) 
				{
				$mois_echeance = $mois_echeance +1;
				$jour_echeance = 1;
					if ($mois_echeance == 13)
					{
					$annee_echeance = $annee_echeance +1;
					$mois_echeance = 1;
					} 
				}
				$i = $i+1;
			}
			//on récupère les infos client
			$sql = " SELECT nom, nom2, num_tva from gestsprl_client WHERE num_client = $client ";
			$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
			while($data = mysql_fetch_array($req)) {
				$nom = $data['nom'];
				$nom_html =  htmlentities (urlencode ($nom));
				$nom2 = $data['nom2'];
				$num_tva = $data['num_tva'];
			}
			//on teste si num_tva est intracom
			if (preg_match('/^(BE|\d{2}|NA)/', $num_tva) === 1) {
    		$intracom = "non";
			} else {
    		$intracom = "oui";
			}

			//on crée la facture avec les infos dispo pour locker le n° au plus vite
			$sql1 = "INSERT INTO gestsprl_facture(coment, client, date_fact, echeance_fact, tva)
				 VALUES ('$com_facture', '$client', '$annee-$mois-$jour', '$annee_echeance-$mois_echeance-$jour_echeance', '$intracom')";
			mysql_query($sql1) or die('Erreur SQL1 !<br>'.$sql1.'<br>'.mysql_error());
			$message="Facture enregistrée";
			//on recherche le numero de la dernière facture créee
			$sql = "SELECT MAX(num) As Maxi FROM gestsprl_facture";
			$result = mysql_query($sql) or die('Erreur');
			$obj=mysql_fetch_object($result);
			$num=$obj->Maxi;

			//on traite les bl à facturer

				$sql 	= "SELECT tot_htva, tot_tva FROM gestsprl_bl WHERE num_bl = $num_bl";
				$result  	= mysql_query($sql) or die ("requete foreach1 impossible");
				while ($data = mysql_fetch_array($result)){
				$tot_htva_facture = $data['tot_htva'];
				$tot_tva_facture = $data['tot_tva'];
				
				}
					//on met le n° de facture + statut fact = ok
					$sql2 = "UPDATE gestsprl_bl SET fact='ok', fact_num='".$num."' WHERE num_bl = $num_bl";
					mysql_query($sql2) or die('Erreur SQL2 !<br>'.$sql2.'<br>'.mysql_error());

			//on met a jour les totaux sur la facture
			$tot_ttc_facture = $tot_htva_facture + $tot_tva_facture;
			$sql2 = "UPDATE gestsprl_facture SET  total_fact_h ='".$tot_htva_facture."', total_fact_ttc='".$tot_ttc_facture."' WHERE num = $num";
			mysql_query($sql2) or die('Erreur SQL2 !<br>'.$sql2.'<br>'.mysql_error());
		
		
			//on génère un nouveau code unique & on met a jour la date d'échéance
			$sql4 = "UPDATE gestsprl_contrat SET  echeance='".$dateFin."' WHERE id = $id_contrat";
			mysql_query($sql4) or die('Erreur SQL2 !<br>'.$sql4.'<br>'.mysql_error());		

		$pdf_user = "client";
		$num_doc = $num;
		$lang= "fr";
		include ("/var/gestion/fpdf/fact_pdf.php");
    } 

}



?>