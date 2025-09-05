<?php
include_once("../config/common.php");
//On récupères les valeurs
$rowid = $_REQUEST['id'] ;
$value = $_REQUEST['value'] ;
$columnId = $_REQUEST['columnId'] ; //id de la colonne de 0 à ...
//on met a jour la table cont_bon
$sql= "UPDATE ".$tblpref."cont_bon SET ";

if ($columnId ==10) {$sql.="commande";}
else if ($columnId ==11) {$sql.="recu";}

$sql.=" ='".$value."' WHERE num=".$rowid."";
$req = mysql_query($sql) or die('<script language="javascript">alert("Erreur SQL !\n\n'.$sql.'\n\n'.mysql_error().'\n\nVeuillez noter ce message et contacter Fast IT Service");</script>');


$sqlinfo ="SELECT cb.bon_num as bon_num, cb.fourn as fourn, cb.quanti as quanti, a.prix_htva as puht";
$sqlinfo.=" FROM ".$tblpref."cont_bon as cb";
$sqlinfo.=" LEFT JOIN ".$tblpref."article as a ON a.num=cb.article_num";
$sqlinfo.=" WHERE cb.num='".$rowid."'";
$reqsqlinfo=mysql_query($sqlinfo);
$obj=mysql_fetch_object($reqsqlinfo);

$bon_num=$obj->bon_num;
$fourn=$obj->fourn;
$pu_htva=$obj->puht;
$qty=$obj->quanti;
$tot_htva=$pu_htva*$qty;
//Si l'on passe l'etat à commander, cela crée un achat
$date_day=date('Y-m-d');
$date_ref=date('Ymd');
if ($columnId == 10) {
	if ($value == 'oui') {
		$sql="SELECT num, prix";
		$sql.=" FROM ".$tblpref."depense";
		$sql.=" WHERE type='AM' AND fournisseur='".$fourn."' AND date='".$date_day."'";
		$req=mysql_query($sql);
		$number=mysql_num_rows($req);
		if ($number > 0) {
			while ($obj=mysql_fetch_object($req)) {
				$num_dep=$obj->num;
				$old_montant=$obj->prix;
				$new_price=$old_montant+$tot_htva;
				$sql_achat="UPDATE ".$tblpref."depense SET prix='".$new_price."' WHERE num='".$num_dep."'";
				$req_achat=mysql_query($sql_achat);
				?>
				<script>
                alert('je sors de l\'update');
                </script>
                <?php
			}
		}
		else {
			$sql_achat="INSERT INTO ".$tblpref."depense(date, lib, fournisseur, prix, type) VALUES ('$date_day', 'AM".$date_ref.$fourn."', '$fourn', '$tot_htva', 'AM')";
			$req_achat=mysql_query($sql_achat);
			?>
			<script>
			alert('je sors de l\'insert');
			</script>
			<?php
		}
	}
}
//Si l'on passe l'état à reçu, on est inviter a rentrer un n° de série.


?>