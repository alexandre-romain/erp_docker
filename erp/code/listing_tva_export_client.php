<?php //date actuelle
$date = gmdate('D, d M Y H:i:s');
 
header("Content-Type: text/dat; charset: ISO-8859-1");
header('Content-Disposition: attachment; filename=export_clients.dat');
header('Last-Modified: '. $date . ' GMT');
header('Expires: ' . $date);
//header specifique IE :s parce que sinon il aime pas
if(preg_match('/msie|(microsoft internet explorer)/i', $_SERVER['HTTP_USER_AGENT'])){
  header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
  header('Pragma: public');
}else{
  header('Pragma: no-cache');
}
require_once("include/verif.php");
include_once("include/config/common.php");
include_once("include/config/var.php");
require("include/configav.php");	

//recuperation des post
$fact_min=isset($_POST['fact_min'])?$_POST['fact_min']:"";
$fact_max=isset($_POST['fact_max'])?$_POST['fact_max']:"";

//carriage return
$r = ''; 

//on imprime le header du fichier
$output = 'CreateKeyAll: Y'.$r.'
IgnoreAnalClosed: Y'.$r.'
DossierSelect: 001'.$r.'
AcctingSelect: 00'.$r.'
';


	$sql = "SELECT num, exported, acompte, coment, total_fact_h, DATE_FORMAT(echeance_fact,'%d/%m/%Y') AS echeance, DATE_FORMAT(date_fact,'%d/%m/%Y') AS date_2,tva FROM " . $tblpref ."facture WHERE num BETWEEN '".$fact_min."' AND '".$fact_max."'";
	$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
	
	//boucle sur toutes les factures
	while($data = mysql_fetch_array($req))
		{
			$num_doc = $data['num'];

			
			//données client
			$sql1 = "SELECT num_client, ".$tblpref."client.exported, mail, nom, nom2, rue, numero, boite, ville, cp, num_tva FROM " . $tblpref ."client RIGHT JOIN " . $tblpref ."facture on CLIENT = num_client WHERE  num = $num_doc";
			$req1 = mysql_query($sql1) or die('Erreur SQL !<br>'.$sql1.'<br>'.mysql_error());
			
			while($data1 = mysql_fetch_array($req1))
			{
				$num_client = $data1['num_client'];
				$nom = $data1['nom'];
				$nom2 = $data1['nom2'];
				if ($nom2 == ""){$nom2 = $nom;}
				$rue = $data1['rue'];
				$numero = $data1['numero'];
				$boite = $data1['boite'];
				$ville = $data1['ville'];
				$cp = $data1['cp'];
				$num_tva = $data1['num_tva'];
				$VAT_format = "BE";
				$VATType = "0";
				
				
				$num_tva = ereg_replace("[^0-9]","",$num_tva);
				if (strlen($num_tva) <= 9) { $num_tva = "0".$num_tva; }
				if ($num_tva == '0')
				{
					$num_tva = '';
					$VAT_format = "NA";
					$VATType = "7";
				}
						   
				$exported_client = $data1['exported'];
			}
			//on imprime le client si pas exported
			if ($exported_client!='oui')
			{

$output.= ''.$r.'
Customer:'.$num_client.$r.'
{'.$r.'
	FirstName:          	""'.$r.'
	LastName:           	"'.$nom2.'"'.$r.'
	Address:            	"'.$rue.' '.$numero.'"'.$r.'
	ZipCode:            	"'.$cp.'"'.$r.'
	City:               	"'.$ville.'"'.$r.'
	State:              	""'.$r.'
	Country:            	"BE"'.$r.'
	Title:              	""'.$r.'
	Company:            	"'.$nom.'"'.$r.'
	Department:         	""'.$r.'
	Office:             	""'.$r.'
	Assistant:          	""'.$r.'
	PhoneBusiness:      	""'.$r.'
	PhoneBusiness2:     	""'.$r.'
	PhoneFax:           	""'.$r.'
	PhoneAssistant:     	""'.$r.'
	PhoneHome:          	""'.$r.'
	PhoneHome2:         	""'.$r.'
	PhoneMobile:        	""'.$r.'
	PhonePager:         	""'.$r.'
	EMail:              	""'.$r.'
	EMail2:             	""'.$r.'
	EMail3:             	""'.$r.'
	EMail4:             	""'.$r.'
	EMail5:             	""'.$r.'
	URL:                	""'.$r.'
	URL2:               	""'.$r.'
	URL3:               	""'.$r.'
	URL4:               	""'.$r.'
	URL5:               	""'.$r.'
	VATNum:             	"'.$num_tva.'"'.$r.'
	VATFormat:          	"'.$VAT_format.'"'.$r.'
	VATType:            	'.$VATType.$r.'
	BankNum:            	""'.$r.'
	BankFormat:         	""'.$r.'
	BankNum2:           	""'.$r.'
	VATCode:            	"21"'.$r.'
	BankFormat2:        	""'.$r.'
	BankNum3:           	""'.$r.'
	BankFormat3:        	""'.$r.'
	BankNum4:           	""'.$r.'
	BankFormat4:        	""'.$r.'
	BankNum5:           	""'.$r.'
	BankFormat5:        	""'.$r.'
	BIC1:               	""'.$r.'
	BIC2:               	""'.$r.'
	BIC3:               	""'.$r.'
	BIC4:               	""'.$r.'
	BIC5:               	""'.$r.'
	IBAN1:              	""'.$r.'
	IBAN2:              	""'.$r.'
	IBAN3:              	""'.$r.'
	IBAN4:              	""'.$r.'
	IBAN5:              	""'.$r.'
	Language:           	0'.$r.'
	Category:           	""'.$r.'
	Memo:               	""'.$r.'
	GnrlID:             	""'.$r.'
	CtrzAcctID:         	""'.$r.'
	SuppID:             	""'.$r.'
	MaxRecallLevel:     	4'.$r.'
	LastRecallLevel:    	0'.$r.'
	DueDateID:          	""'.$r.'
	PayType:            	""'.$r.'
	Mask:               	""'.$r.'
	ToReestimate:       	N'.$r.'
	MultipleCrcy:       	N'.$r.'
	EAN:                	""'.$r.'
	BankID1:            	""'.$r.'
	BankID2:            	""'.$r.'
	BankID3:            	""'.$r.'
	BankID4:            	""'.$r.'
	BankID5:            	""'.$r.'
	BankIdentifier1:    	""'.$r.'
	BankIdentifier2:    	""'.$r.'
	BankIdentifier3:    	""'.$r.'
	BankIdentifier4:    	""'.$r.'
	BankIdentifier5:    	""'.$r.'
	LockAcct:           	N'.$r.'
	LockInvoice:        	0'.$r.'
	LockFinP:           	0'.$r.'
	LockFinM:           	0'.$r.'
	LockODP:            	0'.$r.'
	LockODM:            	0'.$r.'
	TransferCode:       	0'.$r.'
	firm_special:       	""'.$r.'
	SEPActive:          	N'.$r.'
	CompWebGroup:       	N'.$r.'
	DefaultBankID:      	1'.$r.'
	PayAccountID:       	""'.$r.'
	CommunicationType:  	0'.$r.'
	RecallMethod:       	0'.$r.'
	VendorID:           	""'.$r.'
	ConfirmNumber:      	0'.$r.'
	RebateRate:         	0.000000'.$r.'
	DiscountRate:       	0.000000'.$r.'
	CreditLimit:        	0.000000'.$r.'
	MinimumInvoiced:    	0.000000'.$r.'
	SpecialPrice:       	Y'.$r.'
	DeliveryNumber:     	0'.$r.'
	DeliveryPartial:    	Y'.$r.'
	DeliveryWithPrice:  	N'.$r.'
	InvoiceFrequency:   	0'.$r.'
	InvoiceGrouped:     	Y'.$r.'
	InvoiceNumber:      	0'.$r.'
	CrcyCreditLimit:    	"EUR"'.$r.'
	CrcyMinimumInvoiced:	"EUR"'.$r.'
}'.$r.'
';
			//on met a jour le client exported
			$sql12 = "UPDATE `" . $tblpref ."client` SET `exported` = 'oui' WHERE `num_client` = '$num_client'";
			mysql_query($sql12) or die('Erreur SQL11 !<br>'.$sql12.'<br>'.mysql_error());
			
			} //fin test sur exported_client
			
		} //fin boucle factures	

echo $output;
// 1 : on ouvre le fichier
/*$output = mb_convert_encoding($output, "ISO-8859-1");
$monfichier = fopen('./upload/export_cli.txt', 'a');
fputs($monfichier, $output);

// 3 : quand on a fini de l'utiliser, on ferme le fichier
fclose($monfichier);
file_put_contents($monfichier, utf8_decode(file_get_contents($monfichier)));*/
?>