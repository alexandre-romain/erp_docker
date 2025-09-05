<?php

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

// on importe la classe phpmailer
	require("/var/gestion/include/PHPMailer-5.1.0/class.phpmailer.php");

// Obtenir la date actuelle
$date_actuelle = date('Y-m-d');

// Sélectionner tous les paniers à renouveler

	$sql_panier = "SELECT id, id_cli, echeance, DATE_FORMAT(echeance,'%d/%m/%Y') AS echeance_fr, etat, cle_unique, debut, duree FROM gestsprl_panier WHERE 1";
	$req_panier = mysql_query($sql_panier) or die('Erreur SQL !<br>'.$sql_panier.'<br>'.mysql_error());
	
// Parcourir les résultats			
	
	while($panier = mysql_fetch_array($req_panier))
{
			
    // Obtenir les informations nécessaires
    $id_panier = $panier['id'];
	$id_cli = $panier['id_cli'];
    $debut = $panier['debut'];
    $duree = $panier['duree'];
    $echeance = $panier['echeance'];
	$echeance_fr = $panier['echeance_fr'];
    $cle_unique = $panier['cle_unique'];
    $etat = $panier['etat'];

    // Calculer la date de relance pour chaque mail
    $date_relance_1 = date('Y-m-d', strtotime($echeance . ' -30 days'));
    $date_relance_2 = date('Y-m-d', strtotime($echeance . ' -15 days'));
    $date_relance_3 = date('Y-m-d', strtotime($echeance . ' -7 days'));
	
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
		
    	// Vérifier si un mail doit être envoyé
    	if ($etat == 0 && $date_actuelle >= $date_relance_1) 
	{
        // Envoyer le premier mail de relance 30j
        $sujet = "Renouvellement de votre panier Fast IT Service";
        $message = "<p>Bonjour,</p>
					<p>Nous souhaitons vous rappeler que votre panier arrivera &agrave; expiration dans 30 jours.</p>
					<p>Le(s) article(s) suivant(s) doi(ven)t être renouvel&eacute;(s) pour le ".$echeance_fr." :</p>";
		$message .= "<table>
					<thead>
						<tr>
							<th>Article</th>
							<th>Part Number</th>
							<th>Quantit&eacute;</th>
							<th>Prix HT /P</th>
						</tr>
					</thead>
					<tbody>";
			
						// on récupère le contenu du panier
						$sql_panier2 = "SELECT * FROM gestsprl_cont_panier WHERE id_panier = '$id_panier'";
						$req_panier2 = mysql_query($sql_panier2) or die('Erreur SQL !<br>'.$sql_panier2.'<br>'.mysql_error());
						
						while($data_panier2 = mysql_fetch_array($req_panier2))
					{
						
						$id_product = $data_panier2['id_product'];
						$qty_product = $data_panier2['qty'];
						
						
							$sql_article = "SELECT * FROM gestsprl_article WHERE num = '$id_product'";
							$req_article = mysql_query($sql_article) or die('Erreur SQL !<br>'.$sql_article.'<br>'.mysql_error());
							
							while($data_article = mysql_fetch_array($req_article))
						{
							$nom_product = $data_article['article'];
							$marque_article = $data_article['marque'];
							$PA = $data_article['prix_htva'];
							$marge_article = $data_article['marge'];
							$reference_article = $data_article['reference'];
							//calcul du PV
							if ( ($marge_article == '0')){ 
								$prix_article = $PA; 
							}
							else { 
								$prix_article = (($marge_article / 100) + 1) * $PA; 
							}
							
							$message .= "<tr>
										<td>".$marque_article." ".$nom_product."</td>
										<td>".$reference_article."</td>
										<td>".$qty_product."</td>
										<td>".$prix_article." &euro;</td>
									</tr>";
							$prix_total_ht += ($prix_article*$qty_product);
						}
						
					}					
					
						
		$message .= "</tbody></table>
					<p>Veuillez cliquer sur le lien suivant pour vous connecter &agrave; : <a href='http://erp.fastitservice.be/renouvellement.php?code=".$cle_unique."'>Notre interface de renouvellement automatis&eacute;e</a>. </p>
					<p>Cordialement,</p>
					<p>L'&eacute;quipe de Fast IT Service </p>";
     

			$mail = new PHPMailer();
			$mail->IsSMTP(); // telling the class to use SMTP
			$mail->Host       = "192.168.50.230"; // SMTP server
			$mail->SMTPDebug  = 0;
			$staffEmail = "compta@fastitservice.be";
			$mail->From = $staffEmail;
			$mail->FromName = "Comptabilité - Fast IT Service";
			$mail->AddAddress($mail_cli); //destinataire
			$mail->AddReplyTo($staffEmail, "Fast IT Service");
			
			$mail->Subject = $sujet; 
			$mail->IsHTML(true);
			$mail->Body = $message;
			$mail->Send();


        // Mettre à jour le champ 'etat'
		$sql1 = "UPDATE gestsprl_panier SET etat = 1 WHERE id = $id_panier";
		mysql_query($sql1) OR die("<p>Erreur Mysql<br/>$sql1<br/>".mysql_error()."</p>");


    } 	
		elseif ($etat == 1 && $date_actuelle >= $date_relance_2) 
	{
        // Envoyer le deuxième mail de relance
        $sujet = "Rappel de renouvellement de votre panier Fast IT Service";
        $message = "<p>Bonjour,</p>
					<p>Nous souhaitons vous rappeler que votre panier arrivera &agrave; expiration dans 15 jours.</p>
					<p>Le(s) article(s) suivant(s) doi(ven)t être renouvel&eacute;(s) pour le ".$echeance_fr." :</p>";
		$message .= "<table>
					<thead>
						<tr>
							<th>Article</th>
							<th>Part Number</th>
							<th>Quantit&eacute;</th>
							<th>Prix HT /P</th>
						</tr>
					</thead>
					<tbody>";
			
						// on récupère le contenu du panier
						$sql_panier2 = "SELECT * FROM gestsprl_cont_panier WHERE id_panier = '$id_panier'";
						$req_panier2 = mysql_query($sql_panier2) or die('Erreur SQL !<br>'.$sql_panier2.'<br>'.mysql_error());
						
						while($data_panier2 = mysql_fetch_array($req_panier2))
					{
						
						$id_product = $data_panier2['id_product'];
						$qty_product = $data_panier2['qty'];
						
						
							$sql_article = "SELECT * FROM gestsprl_article WHERE num = '$id_product'";
							$req_article = mysql_query($sql_article) or die('Erreur SQL !<br>'.$sql_article.'<br>'.mysql_error());
							
							while($data_article = mysql_fetch_array($req_article))
							{
							$nom_product = $data_article['article'];
							$marque_article = $data_article['marque'];
							$PA = $data_article['prix_htva'];
							$marge_article = $data_article['marge'];
							$reference_article = $data_article['reference'];
							//calcul du PV
							if ( ($marge_article == '0')){ 
								$prix_article = $PA; 
							}
							else { 
								$prix_article = (($marge_article / 100) + 1) * $PA; 
							}
							
							$message .= "<tr>
										<td>".$marque_article." ".$nom_product."</td>
										<td>".$reference_article."</td>
										<td>".$qty_product."</td>
										<td>".$prix_article." &euro;</td>
									</tr>";
							$prix_total_ht += ($prix_article*$qty_product);
							}
						
					}					
					
						
		$message .= "</tbody></table>
					<p>Veuillez cliquer sur le lien suivant pour vous connecter &agrave; : <a href='http://erp.fastitservice.be/renouvellement.php?code=".$cle_unique."'>Notre interface de renouvellement automatis&eacute;e</a>. </p>
					<p>Cordialement,</p>
					<p>L'&eacute;quipe de Fast IT Service </p>";
	
			$mail = new PHPMailer();
			$mail->IsSMTP(); // telling the class to use SMTP
			$mail->Host       = "192.168.50.230"; // SMTP server
			$mail->SMTPDebug  = 0;
			$staffEmail = "compta@fastitservice.be";
			$mail->From = $staffEmail;
			$mail->FromName = "ERP - Fast IT Service";
			$mail->AddAddress($mail_cli); //destinataire
			$mail->AddReplyTo($staffEmail, "Fast IT Service");
			
			$mail->Subject = $sujet; 
			$mail->IsHTML(true);
			$mail->Body = $message;
			$mail->Send();

        // Mettre à jour le champ 'etat'
		$sql2 = "UPDATE gestsprl_panier SET etat = 2 WHERE id = $id_panier";
		mysql_query($sql2) OR die("<p>Erreur Mysql<br/>$sql2<br/>".mysql_error()."</p>");
		
    } 
		elseif ($etat == 2 && $date_actuelle >= $date_relance_3) 
	{
        // Envoyer le troisième mail de relance
        $sujet = "Dernier rappel de renouvellement de votre panier Fast IT Service";
        $message = "<p>Bonjour,</p>
					<p>Nous souhaitons vous rappeler que votre panier arrivera &agrave; expiration dans 7 jours.</p>
					<p><br><strong>Sans r&eacute;action de votre part, les services li&eacute;s pourraient &ecirc;tre suspendus !</strong><br><br></p>
					<p>Le(s) article(s) suivant(s) doi(ven)t être renouvel&eacute;(s) pour le ".$echeance_fr." :</p>";
		$message .= "<table>
					<thead>
						<tr>
							<th>Article</th>
							<th>Part Number</th>
							<th>Quantit&eacute;</th>
							<th>Prix HT /P</th>
						</tr>
					</thead>
					<tbody>";
			
						// on récupère le contenu du panier
						$sql_panier2 = "SELECT * FROM gestsprl_cont_panier WHERE id_panier = '$id_panier'";
						$req_panier2 = mysql_query($sql_panier2) or die('Erreur SQL !<br>'.$sql_panier2.'<br>'.mysql_error());
						
						while($data_panier2 = mysql_fetch_array($req_panier2))
					{
						
						$id_product = $data_panier2['id_product'];
						$qty_product = $data_panier2['qty'];
						
						
							$sql_article = "SELECT * FROM gestsprl_article WHERE num = '$id_product'";
							$req_article = mysql_query($sql_article) or die('Erreur SQL !<br>'.$sql_article.'<br>'.mysql_error());
							
							while($data_article = mysql_fetch_array($req_article))
							{
							$nom_product = $data_article['article'];
							$marque_article = $data_article['marque'];
							$PA = $data_article['prix_htva'];
							$marge_article = $data_article['marge'];
							$reference_article = $data_article['reference'];
							//calcul du PV
							if ( ($marge_article == '0')){ 
								$prix_article = $PA; 
							}
							else { 
								$prix_article = (($marge_article / 100) + 1) * $PA; 
							}
							
							$message .= "<tr>
										<td>".$marque_article." ".$nom_product."</td>
										<td>".$reference_article."</td>
										<td>".$qty_product."</td>
										<td>".$prix_article." &euro;</td>
									</tr>";
							$prix_total_ht += ($prix_article*$qty_product);
							}
						
					}					
					
						
		$message .= "</tbody></table>
					<p>Veuillez cliquer sur le lien suivant pour vous connecter &agrave; : <a href='http://erp.fastitservice.be/renouvellement.php?code=".$cle_unique."'>Notre interface de renouvellement automatis&eacute;e</a>. </p>
					<p>Cordialement,</p>
					<p>L'&eacute;quipe de Fast IT Service </p>";

			$mail = new PHPMailer();
			$mail->IsSMTP(); // telling the class to use SMTP
			$mail->Host       = "192.168.50.230"; // SMTP server
			$mail->SMTPDebug  = 0;
			$staffEmail = "compta@fastitservice.be";
			$mail->From = $staffEmail;
			$mail->FromName = "ERP - Fast IT Service";
			$mail->AddAddress($mail_cli); //destinataire
			$mail->AddReplyTo($staffEmail, "Fast IT Service");
			
			$mail->Subject = $sujet; 
			$mail->IsHTML(true);
			$mail->Body = $message;
			$mail->Send();

        // Mettre à jour le champ 'etat'
		$sql2 = "UPDATE gestsprl_panier SET etat = 3 WHERE id = $id_panier";
		mysql_query($sql2) OR die("<p>Erreur Mysql<br/>$sql2<br/>".mysql_error()."</p>");
		
    } 
		if ($etat == 3 && $date_actuelle >= $echeance) 
	{
        // Envoyer l'info a la compta
        $sujet = "RENOUVELLEMENT CLIENT NON EFFECTUÉ !!";
        $message = "<p>Bonjour,</p>
					<p>Le client ".$nom_cli." / ".$nom2_cli." n'a pas renouvel&eacute; son panier</p>
					<p>Veuillez prendre contact avec lui de pr&eacute;f&eacute;rence au ".$gsm_cli." / ".$tel_cli." ou, &agrave; d&eacute;faut par mail &agrave; l'adresse ".$mail_cli."</p>
					<p>Merci,</p>";

			$mail = new PHPMailer();
			$mail->IsSMTP(); // telling the class to use SMTP
			$mail->Host       = "192.168.50.230"; // SMTP server
			$mail->SMTPDebug  = 0;
			$staffEmail = "compta@fastitservice.be";
			$mail->From = $staffEmail;
			$mail->FromName = "ERP - Fast IT Service";
			$mail->AddAddress('compta@fastitservice.be', 'Compta Fast IT Service'); //destinataire
			$mail->AddReplyTo($staffEmail, "Fast IT Service");
			
			$mail->Subject = $sujet; 
			$mail->IsHTML(true);
			$mail->Body = $message;
			$mail->Send();

	}
}
?>