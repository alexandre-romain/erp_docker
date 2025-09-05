<?
function connecter(){ 								// ouverture de connection
if(file_exists("../conf/config.inc.php")) {
	include('../conf/config.inc.php'); 
} else{
	include('conf/config.inc.php'); 
}

								// interogation de donnee de connection
	$connexion = mysql_connect($host, $user, $pass)or die('Erreur SQL : '.mysql_error());
	$choix_base = mysql_select_db($bdd, $connexion)or die('Erreur SQL : '.mysql_error());
}

function deconnecter(){ 							// fermeture de connection en cours
	mysql_close();
}

function requette($str_query, $connect=1){
	if ($connect==1){connecter();}					// si connect =1 on se connect
	$resultat = mysql_query($str_query)or die('Erreur SQL : '.mysql_error());
	if ($connect==1){deconnecter();}				// si connect =1 on se deconnect
	return $resultat;
}


function ajouter($bd_table, $str_champs_valeurs, $connect = 1){
	$i=0;
	$champs="";
	$valeurs="";
	
	if ($connect==1){connecter();} 					// si connect =1 on se connect
	
	//str_replace(" ", "", $str_champs_valeurs); 		// supprimer tout les espaces
	$resultat = split("#", $str_champs_valeurs); 	// decoupage ds le tableau sous forme: 'nom_de_chapmp=text a insere'
	
	for ($i = 0; $i<sizeof($resultat); $i++){  		// boucle - parcourir tableau
		$pos=strpos($resultat[$i],"=") ;			// on recupere la position de carractaire de decoupage
		$champs.=substr($resultat[$i], 0, $pos) . ", "; // on decoupe et stock des champs sous forme: 'champ1, champ2, ...'
		$valeurs.="'".substr($resultat[$i], $pos+1,strlen($resultat[$i])- $pos+1 )."', "; // sous forme: "'val1', 'val2', ..."
	}

	$champs=substr($champs,0,sizeof($valeurs)-3); 	// il faut enleve dernier - ", "
	$valeurs=substr($valeurs,0,sizeof($valeurs)-3);	// il faut enleve dernier - ", "
	
	$str_query="INSERT INTO ".$bd_table."(".$champs.") VALUES (".$valeurs.")"; //construction de query
	$resultat = requette($str_query ,0);							// envoi de query
	 
	if ($connect==1){deconnecter();}				// si connect =1 on se deconnect
	return $resultat;
}

//fonction qui verrifie l'existence d'un libelé dans un champ de la bdd
// ex verif_libelle ("contact", "nom", "toto");
function verif_exist($table, $champ, $exist, $connect=1){
	if ($connect==1){connecter();}					// si connect =1 on se connect
	$resultat = mysql_query("select * from ".$table." where ".$champ." ='".$exist."'")or die('Erreur SQL : '.mysql_error());
	$nb_result_e = mysql_num_rows($resultat);
	if ($nb_result_e > 0){
		return 1;
	}else {
		return 0;
	}
	if ($connect==1){deconnecter();}				// si connect =1 on se deconnect
}
?>
