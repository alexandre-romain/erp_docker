<br/>
<form name="form_bon" method="post" action="ca_client_parmois.php">
<table class="main_table" align="center">
  	<tr>
		<td class="main_table_header" colspan="3"><?php echo $lang_statistiques_par_client; ?></td>
  	</tr>
    <tr>
      <th class="subtitle"><?php echo $lang_client; ?></th>
      <th class="subtitle">Année</th>
    </tr>
	<tr>
		<td class="main_table">
			<?php
			$rqSql ="SELECT num_client, nom FROM " . $tblpref ."client WHERE actif != 'non'ORDER BY nom"; 
			$result = mysql_query( $rqSql ) or die( "Exécution requête impossible.");
			?>
			<SELECT NAME='client'>
				<OPTION VALUE=0>Choisissez</OPTION>
				<?php
				while ( $row = mysql_fetch_array( $result)) {
					$numclient = $row["num_client"];
					$nom = $row["nom"];
					?>
					<OPTION VALUE='<?php echo $numclient; ?>'><? echo $nom; ?> </OPTION>
				<?
				}
				?>
			</SELECT>
		</td>
		<td class="main_table">
        	<select name="an">
            	<?php
				//Permet de lister les années ==> Changer $i < 2016 pour augmenter la valeur finale; changer $i=2004 pour modifier la valeur initiale
				for ($i=2004 ; $i < 2016 ; $i++) {
					echo '<option value="'.$i.'">'.$i.'</option>';
				}
				?>
           	</select>
      	</td>
  	</tr>
	<tr>
    	<td colspan="3" class="main_table_header">
    		<input type="submit" name="Submit" value="<? echo $lang_envoyer; ?>" class="submit">
        </td>
    </tr>
</table>
</form>
<br/>