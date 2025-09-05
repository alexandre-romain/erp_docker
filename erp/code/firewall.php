<?php 
	$nfrid=32; //next firewall rule id
	$nrid=138; //next row ID
	$npid=35; //next priority id

//Ouverture du fichier en mode R (lecture), stockage du résultat dans variable $fichierR
$fichierR = fopen('china_IP.txt', 'r');
//tant qu'on atteint pas 'eof'
while(!feof($fichierR))
{
	//on lit la ligne et on met le contenu dans variable
	$line = fgets($fichierR);
	//on splite le contenu de la ligne (séparateur = ;)
	list($firstip, $lastip) = explode(";", $line);
	//on traite la premiere ip (si termine par .0, on remplace par .1)
	if (substr($firstip, -2, 2) == '.0')
	{
		$firstipok  = substr($firstip, 0, strlen($firstip)-1).'1';
	} else { $firstipok = $firstip;}
	if (substr($lastip, -6, 4) == '.255')
	{
		$lastipok  = substr($lastip, 0, strlen($lastip)-3).'4';
	} else { $lastipok = $lastip;}
	/*TEST
	echo substr($firstip, -2, 2).'</br>';
	echo substr($lastip, -6, 4).'</br>';
	echo 'FIRSTIP = '.$firstip.'</br>';
	echo 'LASTIP = '.$lastip.'</br>';
	echo 'FIRSTIPOK = '.$firstipok.'</br>';
	echo 'LASTIPOK = '.$lastipok.'</br></br>';
	*/
	//on compose l'output
	echo 'FirewallRules['.$nfrid.'] = {}</br>';
	echo 'FirewallRules['.$nfrid.']["ToZoneType"] = "ANY"</br>';
	echo 'FirewallRules['.$nfrid.']["Action"] = "DROP"</br>';
	echo 'FirewallRules['.$nfrid.']["SourceAddressStart"] = "'.$firstipok.'"</br>';
	echo 'FirewallRules['.$nfrid.']["LogLevel"] = "2"</br>';
	echo 'FirewallRules['.$nfrid.']["FromZoneType"] = "INSECURE"</br>';
	echo 'FirewallRules['.$nfrid.']["_ROWID_"] = "'.$nrid.'"</br>';
	echo 'FirewallRules['.$nfrid.']["RuleType"] = "INSECURE_SECURE"</br>';
	echo 'FirewallRules['.$nfrid.']["SourceAddressEnd"] = "'.$lastipok.'"</br>';
	echo 'FirewallRules['.$nfrid.']["InsertFrmGui"] = "0"</br>';
	echo 'FirewallRules['.$nfrid.']["DestinationPublicInterface"] = "WAN1"</br>';
	echo 'FirewallRules['.$nfrid.']["ServiceName"] = "ANY"</br>';
	echo 'FirewallRules['.$nfrid.']["Status"] = "1"</br>';
	echo 'FirewallRules['.$nfrid.']["SourceAddressType"] = "2"</br>';
	echo 'FirewallRules['.$nfrid.']["TypeOfService"] = "0"</br>';
	echo 'FirewallRules['.$nfrid.']["PriorityId"] = "'.$npid.'"</br>';

	$nfrid++;
	$nrid++;
	$npid++;
}
//fermeture du fichier
fclose($fichierR);
?>
