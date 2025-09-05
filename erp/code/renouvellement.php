<?php
// on r�cup�re le code unique en GET
if (isset($_GET['code'])) 
{
 	//on connecte la db
	$user= "root";//l'utilisateur de la base de donn�es mysql
	$pwd= "rootpass01";//le mot de passe � la base de donn�es mysql
	$db= "gestion";//le nom de la base de donn�es mysql
	$host= "localhost";//l'adresse de la base de donn�es mysql 
	$default_lang= "fr";//la langue de l'interface et des factures : voir la doc pour les abbr�viations
	$tblpref= "gestsprl_";//prefixe des tables 
	mysql_connect($host,$user,$pwd) or die ("serveur de base de donn�es injoignable.");
	mysql_select_db($db) or die ("La base de donn�es est injoignable.");
	mysql_set_charset('ISO-8859-1');
  
  
	$code = $_GET['code'];
	$sql = "SELECT duree, id, id_cli, DATE_FORMAT(echeance,'%d/%m/%Y') AS echeance FROM gestsprl_panier WHERE cle_unique = '$code'";
	$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
	
	//echo mysql_num_rows($req);
	
  	if (mysql_num_rows($req) == 1) // on v�rifie qu'il y a bien une entr�e qui correspond au code unique fourni
  {
  			while($data = mysql_fetch_array($req))
    	{
			$id_panier = $data['id'];
			$id_cli = $data['id_cli'];
			$echeance = $data['echeance'];
			$duree = $data['duree'];
			$dateDepartTimestamp = strtotime(str_replace('/', '-', $echeance));
			$dateFin = date('d-m-Y', strtotime('+'.$duree.' month', $dateDepartTimestamp));

			
		}
		    $sql_cli = "SELECT * FROM gestsprl_client WHERE num_client = '$id_cli'";
			$req_cli = mysql_query($sql_cli) or die('Erreur SQL !<br>'.$sql_cli.'<br>'.mysql_error());
			
			while($data_cli = mysql_fetch_array($req_cli))
    	{
			
    		$nom_cli = $data_cli['nom'];
			$mail_cli = $data_cli['mail'];
		}
		//echo "<br>".$nom_cli;
			
			//on affiche le contenu de la page
			?>
		<!DOCTYPE html>
		<html>
		<head>
			<title>Renouvellement de votre panier Fast IT Service</title>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<style>
				body {
					font-family: Arial, sans-serif;
					margin: 0;
					padding: 0;
				}
				header {
					background-color: #333;
					color: #fff;
					padding: 20px;
					text-align: center;
				}
				h1 {
					margin: 0;
				}
				.container {
					max-width: 800px;
					margin: 0 auto;
					padding: 20px;
					text-align: center;
				}
				.btn {
					background-color: #ff6600;
					border: none;
					color: #fff;
					padding: 10px 20px;
					border-radius: 5px;
					text-decoration: none;
					font-size: 1.2em;
					margin-top: 20px;
					display: inline-block;
				}
				.btn:hover {
					background-color: #cc5500;
					cursor: pointer;
				}
				table {
					border-collapse: collapse;
					margin: 20px auto;
				}
				table th, table td {
					padding: 10px;
					border: 1px solid #ccc;
				}
				table th {
					background-color: #333;
					color: #fff;
				}
			</style>
		</head>
		<body>
			<header>
				<h1>Renouvellement de vo(s) article(s) Fast IT Service</h1>
			</header>
			<div class="container">
				<h2>Bienvenue <? echo $nom_cli; ?> !</h2>
				<p>Cher client, vo(s)tre produit(s) ci-dessous doivent &ecirc;tre renouvel&eacute;s au plus tard pour le <strong><? echo $echeance; ?></strong> </p>
				<table>
					<thead>
						<tr>
							<th>Article</th>
							<th>Part Number</th>
							<th>Quantit&eacute;</th>
							<th>Prix HT /P</th>
						</tr>
					</thead>
					<tbody>
<?
// on r�cup�re le contenu du panier

		    $sql_panier = "SELECT * FROM gestsprl_cont_panier WHERE id_panier = '$id_panier'";
			$req_panier = mysql_query($sql_panier) or die('Erreur SQL !<br>'.$sql_panier.'<br>'.mysql_error());
			
			while($data_panier = mysql_fetch_array($req_panier))
    	{
			
    		$id_product = $data_panier['id_product'];
			$qty_product = $data_panier['qty'];
			
			
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
				
				echo "<tr>
							<td>".$marque_article." ".$nom_product."</td>
							<td>".$reference_article."</td>
							<td>".$qty_product."</td>
							<td>".$prix_article." &euro;</td>
						</tr>";
				$prix_total_ht += ($prix_article*$qty_product);
				}
			
		}					

?>
					</tbody>
				</table>
				<p>
					Afin de ne pas subir de coupure de service, nous vous invitons &agrave; proc&eacute;der au renouvellement <br><br>
					en validant le formulaire ci-apr&egrave;s : 
</p>
				<p>&nbsp;				</p>
				<form action="renouvellement.php"  method="post">
					<p>
						<input type="checkbox" name="cond_gen" value="cond_gen" required>
						J'ai pris connaissance des <a href="http://www.fastitservice.be/include/conditions_generales_Fast_IT.pdf" target="_blank">conditions g&eacute;n&eacute;rales de vente de Fast IT Service</a>
					</p>
					<p>
						<input type="checkbox" name="accord" value="accord" required>
						Je marque mon accord pour renouveler les articles list&eacute;s ci-dessus pour la p&eacute;riode<br><br>du <? echo $echeance; ?> au <? echo str_replace('-', '/', $dateFin); ?> et pour la somme totale de <? echo $prix_total_ht; ?> &euro; HT <a href="http://www.fastitservice.be/include/conditions_generales_Fast_IT.pdf" target="_blank"></a></p>
				    <p><input type="hidden" name="step" value="renew">
					<input type="hidden" name="id_panier" value="<? echo $id_panier; ?>">
					<input type="hidden" name="id_cli" value="<? echo $id_cli; ?>">
					<input type="hidden" name="code" value="<? echo $code; ?>">
					<input type="submit" value="Je valide le renouvellement" class="btn">
				  </p>
			  </form>
				<p>Une fois le renouvellement confirm&eacute;, vous recevrez votre facture par mail &agrave; l'adresse <? echo $mail_cli; ?></p>
				<p>&nbsp;</p>
				<p>&nbsp;</p>
				<p>Si vous ne souhaitez pas renouveler les produits ou que vous souhaitez &ecirc;tre contact&eacute; au sujet de ce renouvellement, merci de nous en faire part en cliquant sur le bouton ci-apr&egrave;s :</p>
				<form action="renouvellement.php"  method="post">
				<p>
				  <input type="hidden" name="step" value="contact">
				  <input type="hidden" name="nom_cli" value="<? echo $nom_cli; ?>">
				  <input type="hidden" name="id_panier" value="<? echo $id_panier; ?>">
				  <input type="hidden" name="mail_cli" value="<? echo $mail_cli; ?>">
					<input type="submit" value="Contactez moi !" class="btn">
				  </p>
			  </form>
		</div>
		</body>
		</html>
		<?
	
	} 
	else 
	{
		echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
				"http://www.w3.org/TR/html4/loose.dtd">
				<html>
				<head>
				<title>Oupsss !</title>
				<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
				</head>
				
				<body>
				<div align="center"><br><br>Votre code unique est p&eacute;rim&eacute; ou incorrect ! <a href="mailto:compta@fastitservice.be">Contactez nous</a></div>
				</body>
				</html>';
				
		exit;

	} 

} else // aucun code n'a �t� fourni, l'acc�s est refus� et la page ferm�e.
 {
	// on v�rifie si step a une valeur
	$step=isset($_POST['step'])?$_POST['step']:"";
	
	if ($step == "")
	{
		$step=isset($_GET['step'])?$_GET['step']:"";
	}
	
	if ($step == "thankyou")
	
	{
		echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
				"http://www.w3.org/TR/html4/loose.dtd">
				<html>
				<head>
				<title>Merci !</title>
				<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
				</head>
				
				<body>
				<div align="center"><br><br>Votre facture vous a &eacute;t&eacute; envoy&eacute;e par email. Merci !<br><br> Veuillez fermer cette fen&ecirc;tre.</div>
				</body>
				</html>';
				
		exit;
	}

	if ($step == "contact")
	
	{
		//envoi d'un mail a la compta pour pr�venir que le client souhaite �tre recontact�.
		$nom_cli=isset($_POST['nom_cli'])?$_POST['nom_cli']:"";
		$id_panier=isset($_POST['id_panier'])?$_POST['id_panier']:"";
		$mail_cli=isset($_POST['mail_cli'])?$_POST['mail_cli']:"";
		
		
		require("./include/PHPMailer-5.1.0/class.phpmailer.php");
		
			$mail = new PHPMailer();
			$mail->IsSMTP(); // telling the class to use SMTP
			$mail->Host       = "192.168.50.230"; // SMTP server
			$mail->SMTPDebug  = 0;
			$staffEmail = "compta@fastitservice.be";
			$mail->From = $staffEmail;
			$mail->FromName = "ERP - Fast It Service";
			$mail->AddAddress('compta@fastitservice.be', 'Compta_FastItService');
			$mail->AddReplyTo($staffEmail, "Fast It Service");
			$mail->Subject = "Rappeler client au sujet du renouvellement de son panier";
			$mail->IsHTML(true);
			$mail->Body = "<p>Prendre contact avec ".$nom_cli." au sujet du panier ".$id_panier."</p>
			<p>Son adresse email est <a href=\"mailto:".$mail_cli."\">".$mail_cli."</a></p>
			";
			$mail->Send();
			
			echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
					"http://www.w3.org/TR/html4/loose.dtd">
					<html>
					<head>
					<title>Merci !</title>
					<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
					</head>
					
					<body>
					<div align="center"><br><br>Un email nous a &eacute;t&eacute; envoy&eacute;. Nous prendrons contact avec vous rapidement !<br><br> Veuillez fermer cette fen&ecirc;tre.</div>
					</body>
					</html>';
				

			exit;
	}

	if ($step == "renew")
	
	{
 	//on connecte la db
	$user= "root";//l'utilisateur de la base de donn�es mysql
	$pwd= "rootpass01";//le mot de passe � la base de donn�es mysql
	$db= "gestion";//le nom de la base de donn�es mysql
	$host= "localhost";//l'adresse de la base de donn�es mysql 
	$default_lang= "fr";//la langue de l'interface et des factures : voir la doc pour les abbr�viations
	$tblpref= "gestsprl_";//prefixe des tables 
	mysql_connect($host,$user,$pwd) or die ("serveur de base de donn�es injoignable.");
	mysql_select_db($db) or die ("La base de donn�es est injoignable.");
	mysql_set_charset('ISO-8859-1');
	
		//traitement du renouvellement
		$id_panier=isset($_POST['id_panier'])?$_POST['id_panier']:"";
		$id_cli=isset($_POST['id_cli'])?$_POST['id_cli']:"";
		$code=isset($_POST['code'])?$_POST['code']:"";
		
		// on evite les factures en doublon en recheckant le code
		$sql_code = "SELECT * FROM gestsprl_panier WHERE cle_unique = '$code'";
		$req_code = mysql_query($sql_code) or die('Erreur SQL !<br>'.$sql_code.'<br>'.mysql_error());

		if (mysql_num_rows($req_code) <= 0)
	  	{
			//si la facture a déjà été renouvelée, on recharge la page, ce qui enverra le client sur l'erreur l'informant que son code a déjà été utilisé.
		echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
				"http://www.w3.org/TR/html4/loose.dtd">
				<html>
				<head>
				<title>Oupsss !</title>
				<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
				</head>
				
				<body>
				<div align="center"><br><br>Votre code unique est p&eacute;rim&eacute; ou incorrect ! <a href="mailto:compta@fastitservice.be">Contactez nous</a></div>
				</body>
				</html>';
				
		exit;
		}
		
		// cr�ation du BDC
		
		$date = date('d/m/Y');
		//On split la date.
		list($jour,$mois,$annee) = preg_split('/\//', $date, 3);

		//on cr�e le bon de commande, vide.
		
		$sql1 = "INSERT INTO gestsprl_bon_comm(client_num, date) VALUES ('$id_cli', '$annee-$mois-$jour')";
		mysql_query($sql1) or die('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());
		$bon_num=mysql_insert_id();
		
		
		//on boucle sur les articles du panier pour injection dans table cont_bon

		    $sql_panier = "SELECT * FROM gestsprl_cont_panier WHERE id_panier = '$id_panier'";
			$req_panier = mysql_query($sql_panier) or die('Erreur SQL !<br>'.$sql_panier.'<br>'.mysql_error());
			
			while($data_panier = mysql_fetch_array($req_panier))
    	{
			
    		$id_product = $data_panier['id_product'];
			$qty_product = $data_panier['qty'];
			
			
				$sql_article = "SELECT * FROM gestsprl_article WHERE num = '$id_product'";
				$req_article = mysql_query($sql_article) or die('Erreur SQL !<br>'.$sql_article.'<br>'.mysql_error());
				
				while($data_article = mysql_fetch_array($req_article))
    			{
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
				$total_htva = $prix_article * $qty_product ;
				$mont_tva = $total_htva / 100 * $taux_tva ;
				$mont_tva = sprintf("%.2f",$mont_tva);					
				
				$prix_total_ht += ($prix_article*$qty_product);
				$tot_tva += $mont_tva;

			//inserer les donn�es dans la table du conten des bons.
			$sql1 = "INSERT INTO gestsprl_cont_bon(p_u_jour, quanti, article_num, bon_num, tot_art_htva, to_tva_art, fourn) 
			VALUES ('$prix_article', '$qty_product', '$id_product', '$bon_num', '$total_htva', '$mont_tva', '$fourn')";
			mysql_query($sql1) or die('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());
			
			
				}
		}					
		// on met a jour l'enregistrement dans la table con_comm avec les totaux
		$sql2 = "UPDATE gestsprl_bon_comm SET tot_htva='".$prix_total_ht."', tot_tva='".$tot_tva."'  WHERE num_bon = $bon_num";
		mysql_query($sql2) OR die("<p>Erreur Mysql2<br/>$sql2<br/>".mysql_error()."</p>");
		
		
		// cr�ation du BL
		$sql1 = "INSERT INTO gestsprl_bl ( client_num, date, bon_num, tot_htva, tot_tva ) VALUES ( $id_cli, '$annee-$mois-$jour', $bon_num, $prix_total_ht, $tot_tva )";
		mysql_query($sql1) or die('Erreur SQL 2!<br>'.$sql1.'<br>'.mysql_error());
		$num_bl=mysql_insert_id();
		
		
		//on cr�e les lignes du bl dans la table gest_cont_bl (oblig� si on veutdes traces de tous ls bl ...)
		
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
			
			$sql4 = "SELECT taux_tva FROM gestsprl_article WHERE num = $article_num";
			$req4 = mysql_query($sql4) or die('Erreur SQL 4!<br>'.$sql4.'<br>'.mysql_error());
				
			while($data4 = mysql_fetch_array($req4)) 
			{
				$taux_tva = $data4['taux_tva'];
				$to_tva_art = $tot_art_htva / 100 * $taux_tva ;
			}
			//on cr�e la ligne du bl

				$sql4 = "INSERT INTO gestsprl_cont_bl(bl_num, article_num, quanti, tot_art_htva, to_tva_art, p_u_jour, num_cont_bon) 
				VALUES ('$num_bl', '$article_num', '$alivrer', '$tot_art_htva', '$to_tva_art', '$p_u_jour', '$num_cont_bon')";

			mysql_query($sql4) or die('Erreur SQL5 !<br>'.$sql4.'<br>'.mysql_error());
			
		
			//on met � jour la quantit� livr�e pour chaque ligne
			$rqSql = "SELECT num_cont_bon,quanti FROM gestsprl_cont_bl WHERE bl_num = $num_bl";
			$result = mysql_query( $rqSql ) or die( "Ex�cution requ�te impossible.");
			while ( $row = mysql_fetch_array( $result)) {
				$sql5 = "UPDATE gestsprl_cont_bon SET livre=(livre+".$row['quanti'].") WHERE num = ".$row['num_cont_bon']."";
				mysql_query($sql5) OR die("<p>Erreur Mysql2<br/>$sql5<br/>".mysql_error()."</p>");
				
			}
			//mise a jour du prix total, du commentaire du BL + empeche modifs futures
			$sql2 = "UPDATE gestsprl_bl SET tot_htva='".$prix_total_ht."', tot_tva='".$tot_tva."', coment='".$coment."', status='1'  WHERE num_bl = $num_bl";
			mysql_query($sql2) OR die("<p>Erreur Mysql2<br/>$sql2<br/>".mysql_error()."</p>");
			
			
			//r�cup�ration du n� de bon de commande
			$rqSql = "SELECT bon_num, client_num FROM gestsprl_bl WHERE num_bl = $num_bl";
			$result = mysql_query( $rqSql ) or die( "Ex�cution requ�te impossible.");
			while ( $row = mysql_fetch_array( $result)) {
					$bon_num = $row["bon_num"];
					$client = $row["client_num"];
			}
			//on v�rifie si des bo restants pour ce bon de commande
			$rqSql2 = "SELECT quanti,livre, num as num_cont_bon FROM gestsprl_cont_bon WHERE bon_num = $bon_num";
			$result2 = mysql_query( $rqSql2 ) or die( "Ex�cution requ�te impossible.");
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
					$sql12 = "UPDATE `gestsprl_article` SET `stock` = (stock - $quanti) WHERE `num` = '$article_num'";
					mysql_query($sql12) or die('Erreur SQL12 !<br>'.$sql12.'<br>'.mysql_error());
					
			}		
		
		}
		
		// cr�ation de la facture
		
			// on récupère le commentaire
			
			$sql = "SELECT com_facture, echeance, duree FROM gestsprl_panier WHERE id = '$id_panier'";
			$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());

			while($data = mysql_fetch_array($req))
			{
			$com_facture = $data['com_facture'];
			//recuperation de la prochaine echeance du panuier
			$duree = $data['duree'];
			$echeance = $data['echeance'];
			$dateDepartTimestamp = strtotime(str_replace('/', '-', $echeance));
			$dateFin = date('Y-m-d', strtotime('+'.$duree.' month', $dateDepartTimestamp));
			}
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
			
			$new_cle = bin2hex(openssl_random_pseudo_bytes(25));
			
			$sql4 = "UPDATE gestsprl_panier SET  etat ='0', echeance='".$dateFin."', cle_unique='".$new_cle."' WHERE id = $id_panier";
			mysql_query($sql4) or die('Erreur SQL2 !<br>'.$sql4.'<br>'.mysql_error());		
		
		//redirection pour récupérer la facture par le client
		
		header('Location: ./fpdf/fact_pdf.php?num='.$num.'&pdf_user=client');
		
	}
	//on redirige sur le site si pas de code ni de step
	else { header('Location: http://www.fastitservice.be'); }
 }
 

 ?>