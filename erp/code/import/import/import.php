<br />



<script language="JavaScript" type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>

<?


// Liste les données de la table
// -------------------------------------------
include ('../conf/config.inc.php');
include ('../functions/mysql.php');

// on affiche les tables de la bdd
//pour que ce script fonctionne il faut au moins un enregistrement dans la table s?lectionn?e
function display_one_table($tablename){
	//$query="show fields from $tablename";
	//$result=mysql_query($query);
	$result = requette ("show fields from $tablename");
	$rows = mysql_num_rows($result);
	?>
	<table width ="99%" border="0" cellspacing="1" cellpadding="4" bgcolor="black">
	<tr>
	<th bgcolor="white" colspan="6" style="font-size:14px" align="center">Informations sur la table <i><?php echo $tablename?></i></th>
	</tr>
	<tr style="background-color:#fff">
	<td>Field</td>
	<td>Type</td>
	<td>Null</td>
	<td>Key</td>
	<td>Default</td>
	<td>Extra</td>
	</tr>
	<?php
	while ($row = mysql_fetch_row($result)) {
		?>
		<tr style="background-color:#fff">
		<td><?php echo $row[0] ?>&nbsp;</td>
		<td><?php echo $row[1] ?>&nbsp;</td>
		<td><?php echo $row[2] ?>&nbsp;</td>
		<td><?php echo $row[3] ?>&nbsp;</td>
		<td><?php echo $row[4] ?>&nbsp;</td>
		<td><?php echo $row[5] ?>&nbsp;</td>
		</tr>
		<?php
	}
	?>
	</table>
	<br />
	<?php
}///////////////////////
$result_tables = requette("SHOW TABLES FROM `".$bdd."`");
?>

<form action="" name="form_bdd" id="form_bdd" method="post" enctype="multipart/form-data">
Table de la base de donn&eacute;e qui va re&ccedil;evoir l'import<br>
	<select name="table"> 
<option value="" <?php if (!isset($_POST['table'])){ echo'selected '; } ?> >Choisissez une table</option>
<?php

while ($row = mysql_fetch_row($result_tables)) {

echo "<option ";
if (isset($_POST['table']) && $row[0]==$_POST['table']){ echo'selected '; }
echo "value=\"".$row[0]."\">".$row[0]."</option>";  
echo "\n";
}	
		?>
</select>
<br />
	<br>
		<strong>Fichier CSV ou TXT au format csv</strong><br /><br />
	<strong>Préparation du fichier : </strong><br />
	Ouvrir le fichier dans excel. Créer une nouvelle colonne le plus à droite possible que vous remplirez avec ce que vous voullez... <br />Enregistrez sous >> CSV.<br />
	Cela permet au moment de l'enregistrement  au format CSV de générer le bon nombre de point virgule si certaines lignes n'ont pas d'infos dans leur dernière colonne. En effet excel ne rajoute pas de ";" après la dernière valeur d'une ligne même si il reste des colonnes vides... Au moment de l'import les lignes incomplètes sont ignorées. Il faut donc formatter le fichier csv dans excel grâce à cette petite manip avant de l'enregistrer.<br /><br />
	<input type="file" name="fichiercsv" size="16">
	<?php if (!isset($_POST['del'])) { $_POST['del'] = ';' ;} ?>
	Délimiteur : 		<select name="del">
			<option value=";" <? echo ($_POST['del'] == ';' ? ' selected>; Point virgule' : '>; Point virgule'); 
			//opérateur ternaire => derrière le "?" c'est ce qu'on affiche si condition vraie, sinon c'est derrière le ":"selected>; Point virgule</option
?></option>
<option value="," <? echo ($_POST['del'] == ',' ? ' selected>, Virgule' : '>, Virgule'); 
?></option>
<option value=":" <? echo ($_POST['del'] == ':' ? ' selected>: Deux points' : '>: Deux points'); 
?></option>
<option value="-" <? echo ($_POST['del'] == '-' ? ' selected>- Tiret' : '>- Tiret'); 
?></option>
<option value="/" <? echo ($_POST['del'] == '/' ? ' selected>/ Slash' : '>/ Slash'); 
?></option>
<option value="|" <? echo ($_POST['del'] == '|' ? ' selected>| Barre' : '>| Barre'); 
?></option>
<option value="#" <? echo ($_POST['del'] == '#' ? ' selected># Dièse' : '># Dièse'); 
?></option>
</select>
<br>	<br>
<input type="hidden" name="etape2" value="1">
<input type="submit" value="Etape II > Correpondance des champs">
</form>

<p></p>
<p></p>
<?php if (isset($_POST['table']) && $_POST['table'] !="" && isset($_POST['etape2'])) {
	$del = $_POST['del'];
	if( empty($_FILES['fichiercsv']['tmp_name'])){
		exit("Vous n'avez pas choisi de fichier à uploader.");
	}
	?>
	<form action="" name="form_import" id="form_import" method="post">
	<?php
	// on cr?e cette variable ici avant de faire le test car elle peut servir ? la suppr?ssion aussi
		$content_dir = 'tmp/'; // dossier o? sera d?plac? le fichier

	
	//---------------------
		$tmp_file = $_FILES['fichiercsv']['tmp_name'];
		if( !is_uploaded_file($tmp_file) )
	{
		exit("Le fichier est introuvable.<br /> Vous n'avez pas choisi de fichier ? uploader.");
	}
		// on v?rifie maintenant l'extension
	//$type_file = substr($_FILES['fichier']['name'], strrpos($_FILES['fichier']['name'], "."));
	$type_file = $_FILES['fichiercsv']['type'];
	//echo 'nom du fichier :'.$tmp_file.'<br />';
	//echo  'type du fichier : '.$type_file.'<br />';
		
	$extensions_valides = array( 'csv' , 'txt' );
	$extension_upload = substr(  strrchr($_FILES['fichiercsv']['name'], '.')  ,1);
	if ( in_array($extension_upload,$extensions_valides) ){

		// on copie le fichier dans le dossier de destination
		$name_file = $_FILES['fichiercsv']['name'];
		
		if( !move_uploaded_file($tmp_file, $content_dir . $name_file) )
		{
			exit("Impossible de copier le fichier dans $content_dir");
		}
		
		echo "Le fichier $name_file a bien été uploadé<br />";
		
		display_one_table($_POST['table']);
		echo '<p>&nbsp;&nbsp;&nbsp;</p>';

	} else {
		echo "extension incorrecte. Vous pouvez uploader des <strong>csv, txt. </strong>";
	}

	if(file_exists("$content_dir"."$name_file")) {
		
		
		//on lis la 1ere ligne pour g?n?rer lles listes
		$fp = fopen("$content_dir"."$name_file", 'r');
		$str="";
		$cpt=0;
		
		$str .= fgets($fp, 99000);
		//echo $str;
		$str=trim($str);
		if (substr($str,-1,1) != $del){
			$str .= $del ;
		}
		
		//
		$tabcsv = explode ($del, $str);
		//echo $str;
		
		fclose ($fp);
		//on suppr les espaces
		
		
		//print_r($tabcsv);
		?>
		<table width ="95%" cellspacing="0" cellpadding="4" border="0" style="font-family:courier new;font-size:12px" align="center">
		<tr style="font-weight:bold">
		<td>Champ de la table<span style="padding-left:30px">Forcer valeur</span><span style="padding-left:30px">md5(Valeur)</span><hr></td>
		<td>Champ du fichier CSV<hr></td>
		</tr>
		<tr>
		<td> 
		<?php 
		
		//g?n?ration des listes de gauche avec les champs de la bdd
		
		$resQuery = requette("SHOW FIELDS FROM ".$_POST['table']." FROM ".$bdd);
		$fields = mysql_num_rows($resQuery);
		if (mysql_num_rows($resQuery) != 0) {
			$j = 0;
			while ($j < $fields) {
				?>
				<select name="colone<?php echo $j ; ?>"> 
				<option value="" <?php if (!isset($_POST['colone0'])){ echo'selected'; } ?> >Choisissez une colonne</option>

				<?php

				// on affiche les champs de la table choisie

				// titre des colonnes

				$i = 0;
				while ($i < $fields) {
					echo "<option ";
					if ($i == $j){ echo'selected '; }
					echo "value=\"";
					echo mysql_result($resQuery, $i);
					echo "\">";
					echo mysql_result($resQuery, $i);
					echo "</option>";  
					echo "\n";
					

					$i++;
				}
				echo "\n";

				?>  </select>
				<input type="text" size="10" name="force<?php echo $j; ?>" style="width:100px;margin-left:3px">
				<input type="checkbox" value ="1" name="crypte<?php echo $j; ?>" style="border:0; margin:0; padding=0; width:15px;margin-left:5px;">
				<hr>
				<?php  

				$j++;
			} // fin while j

		} ?></td>
		
		<td>

		<?php
		
		// g?n?ration des listes ---------------------------
		
		$j = 0;
		while ($j < $fields) {
			?>
			
			<select name="colonecsv<?php echo $j ; ?>"> 
			<option value="" >Aucune correspondance</option>

			<?php

			// on affiche les champs de la table choisie

			// titre des colonnes

			$i = 0;
			while ($i < count($tabcsv)-1) {
				echo "<option ";
				if ($i == $j){ echo 'selected '; }
				echo "value=\"";
				echo $i;
				echo "\">";
				echo $tabcsv[$i];
				echo "</option>";  
				echo "\n";
				$i++;
			}
			echo "\n";

			?>   </select>
			
			<hr>
			
			
			
			<?php 
			$j++;
		} //-------------------------------
		
		
	} else {
		echo 'erreur. Fichier csv mal uploadé.<p>&nbsp;&nbsp;&nbsp;</p>';
	}
		

	?>
		</td>
		</tr>
	<tr>
	<td>
	<input type="hidden" name="content_dir" value="<?php echo $content_dir ; ?>">		
	<input type="hidden" name="name_file" value="<?php echo $name_file ; ?>">
	<input type="hidden" name="table" value="<?php echo $_POST['table'] ; ?>">
	<input type="hidden" name="fields" value="<?php echo $fields ; ?>">
	<input type="hidden" name="del" value="<?php echo $_POST['del'] ; ?>">				
	<input type="hidden" name="nb_colones_csv" value="<?php echo count($tabcsv)-1 ; ?>">				
	<input type="hidden" name="listeok" value="1">
	<input type="submit"  value ="Etape III > Importer dans la bdd">	
	</td>
	</tr>
		
	<?php } //fin du if isset 
else if (isset($_POST['etape2'])){
		echo ' Vous n\'avez pas choisi de table où importer les données';
}?>
</table>
</form>
<p>&nbsp;&nbsp;&nbsp;</p>

<?php if (isset($_POST['listeok'])){
	echo '<strong>Traitement du fichier CSV</strong> <br /><br />';
	$del = $_POST['del']; //choix du d?limiteur
	$content_dir = $_POST['content_dir'];
	$name_file = $_POST['name_file'];
	$table = $_POST['table'];
	//nb de champs dans la table
	$fields = $_POST['fields'];
	$nb_colones_csv = $_POST['nb_colones_csv'];

	//on lis la 1ere ligne pour g?n?rer lles listes
	$fp = fopen("$content_dir"."$name_file", 'r');
	$str="";
	$cpt=0;
	while (!feof($fp)) {
		$str = fgets($fp, 99000);
		
		
		//on ?vite les lignes vides
		if(!empty($str)){
			//si on a pas de ; ? la fin d'une ligne on en ajoute une
			//$str = "azerty";
			$str=trim($str);
			//echo 'dernier car de la ligne = '.substr($str,-1,1).'<br>';
			if (substr($str,-1,1) != $del){
				$str .= $del ;
			}
			//on remplace les ' par \'
			$str = str_replace ("'","\'",$str);
			
			$nbcar = strlen($str);
			//on cherche les caract?res de s?paration
			//echo 'nb de char sur la ligne='.$nbcar.'<br>';
			$valligne [] ="";
			// pour placer la valeur chaque fois dans la case suivante du tableau temporaire valligne
			$vallignecpt = 0; 
			
			
			//PARSAGE DES VALEURS
			// SI ON DEBUTE PAR UN "
			
			while ($nbcar != 0){
				
				$pos1=0;
				
				if (substr($str,0,1) == '"'){
					$pos1 = 1;
					$trouve=0;
					for ($pos=0 ; $trouve!= 1; $pos++){
						$sepa = substr($str,$pos,2); 
						//echo 'caractere analis?='.$sepa.'<br>';
						if( $sepa== '"'.$del){
							$pos2 = $pos; //on r?cup?re la position du debut de l'enregistrement
							//echo 'pos1='.$pos1.'<br>';
							//echo 'pos2='.$pos2.'<br>';
							$long = $pos2 - $pos1; //longueuur de la chaine à extraire
							$tempstr = substr($str, $pos1, $long ); //on recup le reste de la ligne
							
							//echo 'compteur ='. $vallignecpt.'<br>';
							
							//sinon on remplis avec la valeur trouvée
							$valligne [$vallignecpt] = $tempstr ;
							
							$vallignecpt++;
							//echo "<strong>Valeur ajoutée=</strong>".$tempstr.'<br><br>';
							$trouve=1;
							$str = substr ($str, ($pos2+2));
							//echo 'Nouvelle Phrase='.$str.'<br>';
							$nbcar = strlen($str);
						}
					}
				} else {
					$pos1 = 0;
					$trouve=0;
					for ($pos=0 ; $trouve!= 1; $pos++){
						$sepa = substr($str,$pos,1); 
						//echo 'caractere analis?='.$sepa.'<br>';
						if( $sepa == $del){
							$pos2 = $pos; //on r?cup?re la position du debut de l'enregistrement
							//echo 'pos1='.$pos1.'<br>';
							//echo 'pos2='.$pos2.'<br>';
							$long = $pos2 - $pos1; //longueuur de la chaine ? extraire
							$tempstr = substr($str, $pos1, $long ); //on recup la valeur
							
							//echo 'compteur ='. $vallignecpt.'<br>';
							
							$valligne [$vallignecpt] = $tempstr ;
							
							$vallignecpt++;
							//echo "<strong> valeur ajout?e=</strong>".$tempstr.'<br><br>';
							$trouve=1;
							$str = substr ($str, ($pos2+1));
							//echo 'nouvelle Phrase='.$str.'<br>';
							$nbcar = strlen($str);
						}
					}

				}
				
			}
			
			//print_r ($valligne);
			$tabcsv[$cpt] = $valligne;
			$valligne = "";
			$cpt ++;
			//echo $str.'<br>';
		}
	}
	fclose ($fp);
	//print_r ($tabcsv);

	
		
		
	//g?n?ration de la requette
		
		$colones = "(" ;
	for ($g=0; $g<$fields; $g++) {
		
		$colones .=  '`'.$_POST["colone$g"].'`';
		//pour ne pas ajouter de virgule apres la derniere colone on teste
		if ($g < ($fields-1)){
			$colones .= ", ";
		}
	}
	$colones .= " ) ";
	//echo '<br>colones = '.$colones;
	//echo '<br> csv : ';
	//echo $_POST['colonecsv0'];
		
	echo $nb_colones_csv.' champs dans le fichier '.$name_file.'<br />'; 
	echo $fields.' champs dans la table '.$table.'<br />'; 

	//génération de la requette
	$numligneval = 1;//compteur qui va donner le numero à la ligne des valeurs ...pour ne pas avoir de trou dans l'index du tableau
	//on incr?mente les lignes
	for ($u=1; $u<=($cpt-1) ; $u++) {
		// on verrifie que le paRsage de la ligne soit bien fait en regardant que tabcsv contient bien le même nombre de champs pour cette ligne que le nombre de champs de la 1ere ligne du fichier csv
		if (count($tabcsv[$u]) == $nb_colones_csv) {			
			$valeurs[$numligneval] = "(" ;
			//on remplis les valeurs en fonction du nb de colones
			for ($m=0; $m<$fields ; $m++) {
				
				$tempcol = 'colonecsv'.$m;
				//on stocke la valeur sans les espaces avant et après

				$tempforce = 'force'.$m;
				$tempcrypte = 'crypte'.$m;
				//	echo '$tempforce = '.$tempforce;
				//	echo ' = '.$_POST[$tempforce];
				//	echo '<br>';
				if ( $_POST[$tempforce] != ""){
					//si on a demandé un cryptage de ce champ ..le @ car si on a pas coché la case ça affiche une erreur
					if ( @$_POST[$tempcrypte] == 1){
					@$valeurs[$numligneval] .= '\''.md5(trim($_POST[$tempforce])).'\'';
					} else {
					@$valeurs[$numligneval] .= '\''.trim($_POST[$tempforce]).'\'';
					}
				} else {
					if ( @$_POST[$tempcrypte] == 1){
					// on evite d'afficher un erreur d'index indefini sur la table si on a pas choisi de correspondance de champ avec @
					@$valeurs[$numligneval] .= '\''.md5(trim($tabcsv[$u][$_POST[$tempcol]])).'\'';
					} else {
					// on evite d'afficher un erreur d'index indefini sur la table si on a pas choisi de correspondance de champ avec @
					@$valeurs[$numligneval] .= '\''.trim($tabcsv[$u][$_POST[$tempcol]]).'\'';
					}
					
				}
				//pour ne pas ajouter de virgule apres la derniere colone on teste
				
				if ($m < ($fields-1)){
					$valeurs[$numligneval] .= ", ";
				}
			}
			$valeurs[$numligneval] .= " ) ";
			$numligneval++;
		} else {
			//print_r ($tabcsv[$numligneval]);
			//echo'<br>';
			echo '<font color="red">Ligne '.($numligneval+1).' du fichier '.$name_file.' -> Erreur : '.count($tabcsv[$u]).' champs au lieu de '.$nb_colones_csv.' </font> - Ligne ignorée. <br />';
			//on remplis quand m?me le tableau des valeurs mais cette ligne sera ignor?e lors des insert ... ?a permet de garder le compteur des lignes ? jour au niveau du journal des erreurs sql
			$valeurs[$numligneval] = "";
			$numligneval++;
		}
		
	}
		
		// FONCTIONS D'IMPORT DANS LA BDD
	/* ?a n'est pas tout ? fait la m?me que dans mysql.php qui est en include
car celle ci affiche les erreurs sans couper le traitement en cas d'erreurs.
C'est celle l ? qu'on va donc utiliser */

	function requette_avec_erreur($str_query, $connect=1){
		if ($connect==1){connecter();}					// si connect =1 on se connect
		$resultat = mysql_query($str_query);
		if ($connect==1){deconnecter();}				// si connect =1 on se deconnect
		if ($resultat)
		{
			return $resultat;
		}
		else
		{
			
			return 0;
			//erreur(3); //si on veux renvoyer ? une action pr?cise en cas d'erreur
		}
		
	}
	echo '<br /><strong>import en cours</strong> <br /><br />';
	$erreur_sql = ""; //on initialise le journal des erreurs
		//insert dans la base
	echo 'La ligne 1 du fichier CSV correspond à la définition des champs. <br />';
	connecter();
	for ($u=1; $u<$numligneval; $u++) {		
		if ($valeurs[$u] != ""){
			$req = "INSERT INTO $table $colones VALUES $valeurs[$u] ";
			//echo "<br>".$req.'<br />';
			
			if (requette_avec_erreur($req,0)) {
				echo 'ajout de la ligne '.($u+1).' du fichier '.$name_file.'.<br />';
			} else {
				$erreur_sql .= '<font color="red">ligne '.($u+1).' du fichier '.$name_file.' -> Erreur SQL '.mysql_errno().' : '.mysql_error().'</font><br>';
				echo '<font color="red">ligne '.($u+1).' -> Erreur SQL</font><br />';
			}
		}
		
	}
		deconnecter();
	echo '<br /><strong>Fin de l\'import</strong><br /> ';
	// affichage des erreurs
	echo '<strong> JOURNAL DES ERREURS SQL</strong><br />';
	if (!empty($erreur_sql)){
		echo $erreur_sql;
	} else {
		echo 'Pas d\'erreurs détectées lors de l\'import';
	}
		echo '<p>&nbsp;&nbsp;&nbsp;</p>';
		
}?>