<?php
include("../config/common.php");

if($_GET['cli'] != '') {
	?>
	<table class="base" width="100%">
		<thead>
        	<tr>
            	<th colspan=4 style="background:#2c3e50">Informations Client (Cliquez pour &eacute;diter)</th>
            </tr>
      	</thead>
   	<?php
	$cli = $_GET['cli'];
	$sql="SELECT nom, rue, numero, boite, ville, cp, num_tva, mail as email, tel, gsm";
	$sql.=" FROM ".$tblpref."client";
	$sql.=" WHERE num_client=".$cli."";
	$req=mysql_query($sql);
	while ($results=mysql_fetch_object($req)) {
		?>
		<tr>
            <td class="right" width="25%">Nom :</td>
            <td class="edit_name left" id="name" width="25%"><?php echo $results->nom;?></td>
            <td class="right" width="25%">Mail :</td>
            <td class="edit_mail left" id="mail" width="25%">
            <?php
            if (empty($results->email)) {
                echo 'N.A.';
            } 
            else {
                echo $results->email;
            }
            ?>
            </td>
        </tr>
		<tr>
            <td class="right">Tel. :</td>
            <td class="edit_tel left" id="tel">
            <?php
            if (empty($results->tel)) {
                echo 'N.A.';
            } 
            else {
                echo $results->tel;
            }
            ?>
            </td>
            <td class="right">GSM :</td>
            <td class="edit_gsm left" id="gsm">
            <?php
            if (empty($results->gsm)) {
                echo 'N.A.';
            } 
            else {
                echo $results->gsm;
            }
            ?>
            </td>
        </tr>
		<tr>
            <td class="right">N° TVA :</td>
            <td class="edit_tva left" id="tva">
            <?php
            if (empty($results->num_tva)) {
				echo 'N.A.';
			} 
            else {
            	echo $results->num_tva;
            }
            ?>
            </td>
        </tr>
		<tr>
            <td class="right">Rue :</td>
            <td class="edit_rue left" id="rue">
            <?php
            if (empty($results->rue)) {
                echo 'N.A.';
            } 
            else {
                echo htmlentities($results->rue);
            }
            ?>
            </td>
        </tr>
		<tr>
            <td class="right">Num&eacute;ro :</td>
            <td class="edit_numero left" id="numero">
            <?php
            if (empty($results->numero)) {echo 'N.A.';} 
            else {
            echo $results->numero;
            }
            ?>
            </td>
            <td class="right">Boite :</td>
            <td class="edit_boite left" id="boite">
            <?php
            if (empty($results->boite)) {
                echo 'N.A.';
            } 
            else {
                echo $results->boite;
            }
            ?>
            </td>
        </tr>
		<tr>
            <td class="right">Code postal :</td>
            <td class="edit_cp left" id="cp">
            <?php
            if (empty($results->cp)) {
                echo 'N.A.';
            } 
            else {
                echo $results->cp;
            }
            ?>
            </td>
            <td class="right">Ville :</td>
            <td class="edit_ville left" id="ville">
            <?php
            if (empty($results->ville)) {
                echo 'N.A.';
            } 
            else {
                echo $results->ville;
            }
            ?>
            </td>
        </tr>
    <?php
	} //FIN WHILE
	?>
	</table>
<?php
} //FIN IF
?>