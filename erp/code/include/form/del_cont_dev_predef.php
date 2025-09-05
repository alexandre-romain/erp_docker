<?php
include("../config/common.php");
include("../fonctions.php");

$id=$_REQUEST['id'];
//On récupère l'id du devis ainsi que les montant à soustraire
$sql="SELECT id_dev_predef, tot_art_htva, tot_tva_art, tot_art_recupel, tot_art_reprobel, tot_art_bebat, tot_art_auvibel FROM ".$tblpref."cont_dev_predef WHERE id='".$id."'";
$req=mysql_query($sql);
$obj=mysql_fetch_object($req);
$id_devis=$obj->id_dev_predef;
$montant_ht=$obj->tot_art_htva;
$montant_tva=$obj->tot_tva_art;
$montant_recupel=$obj->tot_art_recupel;
$montant_reprobel=$obj->tot_art_reprobel;
$montant_bebat=$obj->tot_art_bebat;
$montant_auvibel=$obj->tot_art_auvibel;
//On récupère les totaux du devis
$sql="SELECT tot_htva, tot_tva, tot_recupel, tot_reprobel, tot_auvibel, tot_bebat FROM ".$tblpref."dev_predef WHERE id='".$id_devis."'";
$req=mysql_query($sql);
$obj=mysql_fetch_object($req);
$tot_htva=$obj->tot_htva;
$tot_tva=$obj->tot_tva;
$tot_recupel=$obj->tot_recupel;
$tot_reprobel=$obj->tot_reprobel;
$tot_auvibel=$obj->tot_auvibel;
$tot_bebat=$obj->tot_bebat;
//On calcule les nouveaux totaux
$ntot_htva		=$tot_htva-$montant_ht;
$ntot_tva		=$tot_tva-$montant_tva;
$ntot_recupel	=$tot_recupel-$montant_recupel;
$ntot_reprobel	=$tot_reprobel-$montant_reprobel;
$ntot_auvibel	=$tot_auvibel-$montant_auvibel;
$ntot_bebat		=$tot_bebat-$montant_bebat;
//On maj les totaux du devis
$sql="UPDATE ".$tblpref."dev_predef SET tot_htva='".$ntot_htva."', tot_tva='".$ntot_tva."', tot_recupel='".$ntot_recupel."', tot_reprobel='".$ntot_reprobel."', tot_auvibel='".$ntot_auvibel."', tot_bebat='".$ntot_bebat."' WHERE id='".$id_devis."'";
$req=mysql_query($sql);
//On supprime l'article de cont_dev
$sql="DELETE FROM ".$tblpref."cont_dev_predef WHERE id='".$id."'";
$req=mysql_query($sql);
?>