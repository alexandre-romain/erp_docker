<?php
/////INFOS DE CONNEXION BDD + CONNEXION/////
$user= "hidden";//l'utilisateur de la base de donn�es mysql
$pwd= "hidden";//le mot de passe � la base de donn�es mysql
$db= "gestion";//le nom de la base de donn�es mysql
$host= "localhost";//l'adresse de la base de donn�es mysql 
$default_lang= "fr";//la langue de l'interface et des factures : voir la doc pour les abbr�viations
$tblpref= "gestsprl_";//prefixe des tables 
mysql_connect($host,$user,$pwd) or die ("serveur de base de donn�es injoignable. V�rifiez dans common.php si $host est correct.");
mysql_select_db($db) or die ("La base de donn�es est injoignable. V�rifiez dans common.php si $user, $pwd, $db sont exacts.");
mysql_set_charset('ISO-8859-1');
/////FIN INFOS DE CONNEXION BDD + CONNEXION/////

//Cle cryptage
$cle = '66655544412345';
//Fonction n�cessaire au cryptage/decryptage
if (!function_exists('TableAscii')) {
	function TableAscii() {
		for ($i=0; $i!=255; $i++) {
			$Tab[$i] = chr($i);
		}
		return $Tab;
	}
}
//Fonction de cryptage Password
function Crypter($sMdp, $cle) {    
    if (Empty($sMdp) || !is_numeric($cle)) {
        return false;
    }
    $sTmp = $sMdp;
    $tmp  = $sMdp;
	//$i=0;
    while ($i < strlen($sMdp)) {
        $sTmp = substr($sTmp, 0, $i) . (chr(ord($sMdp[$i]) ^ ($cle >> 8)));
        $cle = (ord($sTmp[$i]) + $cle) * 43;
        $i++;
    }
    $Tab = TableAscii();
    for ($i=0; $i!=strlen($sTmp); $i++) {
        for ($j=0; $j!=255; $j++) {
            if ($sTmp[$i] == $Tab[$j]) $Result .= $j . '-';
        }
    }
    return substr($Result, 0, strlen($Result)-1);
}
//Fonction de decryptage Password
function Decrypter($sMdp, $cle) {
    $Tab = TableAscii();  
    $i = 0;
    $aVar = explode('-', $sMdp);
    if (is_array($aVar)) {
        foreach ($aVar as $val) {
            if ( $val > 255 || !is_numeric($val) ) {
                return false;
            }
            for ($j=0; $j!=255; $j++) {
                if ($val == $j) $sTmp .= $Tab[$j];
            }
        }        
    } 
	else {
        return false;
    }
    $sMdp   = $sTmp;
    $Result = $sMdp;
    $i = 0;
    while ($i < strlen($sMdp)) {
        $Result[$i]  = (chr(ord($sMdp[$i]) ^ ($cle >> 8)));
        $cle = (ord($sTmp[$i]) + $cle) * 43;
        $i++;
    }
    return $Result;
}
//Fonction demandant l'authentification via "navigateur"
function headerDefine() {
header( 'WWW-Authenticate: basic realm="Fast IT Service"' ); 
header( 'HTTP/1.0 401 Unauthorized'); 
echo "Veuillez vous identifier !!\n\n Votre IP a �t� logg�e."; 
exit();
}

//Demande d'authentification si l'user ne l'est pas
if(!isset($_SERVER[PHP_AUTH_USER])) 
{
	headerDefine(); //Si l'user n'est pas encore authentifi�, on lui demande de le faire via le "popup" navigateur.
} 
else 
{
	$PHP_AUTH_USER = strtolower($_SERVER[PHP_AUTH_USER]); 							//On place le login renseign� par l'user dans une variable
	$sql="SELECT * FROM ".$tblpref."user WHERE login='".$PHP_AUTH_USER."'";			//On construit une request sql de mani�re a pouvoir r�cup�rer le mdp stock� en BDD
	$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());	//On l'ex�cute
	$data = mysql_fetch_array($req);												//On l'ex�cute tjs
	$mdp_db = $data['pwd'];															//On stocke le password provenant de la DB dans la variable "$mdp_db"
	$mdp = Crypter($_SERVER[PHP_AUTH_PW], $cle);									//On crypte le password renseign� par l'utilisateur, de mani�re � pouvoir le comparer avec celui stock� en DB
	$date = date("d/m/Y");
	if (($mdp_db != $mdp) || ($mdp == ""))											//Si les deux password crypt�s sont diff�rents, on redemande � l'utilisateur de saisir � nouveau ces identifiants.
	{
	headerDefine(); 
	exit;
	}
}
?>